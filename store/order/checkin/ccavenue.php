<?php 
  require_once("../../../core/init.php");
  require(LIB_ROOT."/lib/ccavenue.php");

  $Merchant_Id = $CCAVENUE['MERCHANT_ID'];
  $WorkingKey = $CCAVENUE['WORKING_KEY'];
  $Amount= $_REQUEST['Amount'];
  $Order_Id= $_REQUEST['Order_Id'];
  $Merchant_Param= $_REQUEST['Merchant_Param'];
  $Checksum= $_REQUEST['Checksum'];
  $AuthDesc=$_REQUEST['AuthDesc'];
    
  $Checksum = verifyChecksum($Merchant_Id, $Order_Id , $Amount,$AuthDesc,$Checksum,$WorkingKey);

  if($Checksum=="true" && $AuthDesc=="Y") {
    $order = Order::find_by_id($Order_Id);

    if($order->is_expired()) {
      // Show the failure page with expired message.
      // Also, provide a link to ask for refunding!
      $order->status = ORDER_EXPIRED;
      $order->save();

      if(!$session->get('order_id')) $session->set('order_id', $order->id);
      $session->set('payment_failure', true);
      redirect_to('/order/failure?expired');
    }

    // TODO: Transaction was done within the time-limit(decide this value(configurable?))
    $order->status = ORDER_PROCESSING;
    $order->save();
    if(!$session->get('order_id')) $session->set('order_id', $order->id);
    $session->set('payment_successful', true);

    // TODO: Save the returned address back to customer/order. Decide!
    // TODO: Send the email to the customer with order details!
    // file_get_contents("http://kshiitij.com/tickets/send_ticket.php?seat_nos={$ticket->seat_nos}&language=English&ticket_id={$Order_Id}&amount={$ticket->amount}&show_time=3:15+PM&quantity={$quantity}&name={$ticket->name}&email={$ticket->email}");
    redirect_to('/order/success');
  } else if($Checksum=="true" && $AuthDesc=="B") {
    // This condition should NEVER come true!
    redirect_to('/');
  } else if($Checksum=="true" && $AuthDesc=="N") {
    // TODO: Transaction failed! Show message that "transaction failed".
    // Ask if there was an error during transaction.
    // If he did pay the money and it failed, provide a refund form.
    $order = Order::find_by_id($Order_Id);
    $order->status = ORDER_FAILED;
    if(!$order->save()) {
      log_admin(ECOM_ERROR, "Order", "Order #{$order->id} save failed while ORDER_FAILED was set as status!");
    }
    if(!$session->get('order_id')) $session->set('order_id', $order->id);
    $session->set('payment_failure', true);
    redirect_to('/order/failure');
  } else {
    redirect_to('/');
  }
?>