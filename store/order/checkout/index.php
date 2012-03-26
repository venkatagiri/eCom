<?php 
  require_once("../../../core/init.php");

  if(!isset($_POST['order'])) redirect_to('/'); // Invalid Request!

  $order = new Order();
  $order->status = 1; // Empty Order

  if(!$order->save()) {
    die('order create fail!');
    // TODO: Show a page with message as "Technical Problems"
  }

  $total_amount = 0;
  $ops = array();

  foreach($_POST['order']['product'] as $p) {
    $op = OrderProduct::make(array(
      'order_id' => $order->id,
      'product_id' => $p['product_id'],
      'name' => $p['name'],
      'price' => $p['price'],
      'quantity' => $p['quantity']
    ));
    if(!$op->save())  {
      die('op save fail');
      // TODO: delete the order products, the order and redirect to home page.
    }
    $ops[] = $op;
    $total_amount += ($op->price * $op->quantity);
  }

  $order->no_of_products = count($ops);
  $order->total_amount = $total_amount;

  if(!$order->save()) {
    die('order update fail!');
    // TODO: delete the order and throw an error with "technical problems" & put some logs here!!
  }

  $session->set('order_id', $order->id);

  redirect_to("login");
?>