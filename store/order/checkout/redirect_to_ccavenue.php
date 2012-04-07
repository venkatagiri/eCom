<?php
  require_once("../../../core/init.php");
  require_once(LIB_ROOT."/lib/ccavenue.php");

  if(!isset($_POST['order_id']) && !isset($_POST['payment_gateway'])) redirect_to('/'); // Invalid Request.

  $order = Order::find_by_id(__($_POST['order_id']));
  if(!$order) redirect_to('/'); // Invalid Request.

  $customer = $session->get_customer();

  $Merchant_Id = $CCAVENUE['MERCHANT_ID'];
  $WorkingKey = $CCAVENUE['WORKING_KEY'];
  $Amount = $order->total_amount;
  $Order_Id = $order->id;
  $Redirect_Url = "http://".SERVER_NAME."/order/checkin/ccavenue.php";

  $Checksum = getCheckSum($Merchant_Id,$Amount,$Order_Id ,$Redirect_Url,$WorkingKey);

  $billing_cust_name = $order->shipping_name;
  $billing_cust_address = $order->shipping_address;
  $billing_cust_city = $order->shipping_city;
  $billing_zip = $order->shipping_pincode;
  $billing_cust_state = $order->shipping_state;
  $billing_cust_country = $order->shipping_country;
  $billing_cust_tel = $order->shipping_telephone;
  $billing_cust_email = $order->shipping_email;

  $delivery_cust_name = $order->shipping_name;
  $delivery_cust_address = $order->shipping_address;
  $delivery_cust_city = $order->shipping_city;
  $delivery_zip_code = $order->shipping_pincode;
  $delivery_cust_state = $order->shipping_state;
  $delivery_cust_country = $order->shipping_country;
  $delivery_cust_tel = $order->shipping_telephone;
  $delivery_cust_notes = "";

  $Merchant_Param = "" ;
?>
<html>
<head><title>Redirecting</title></head>
<body onload="document.forms[0].submit();">
<h2 style="margin-top:30px; text-align:center;">
Redirecting to Payment Gateway... Please wait!!! Do not Press BackButton/Refresh
</h2>

<form action="https://www.ccavenue.com/shopzone/cc_details.jsp" method="post">
  <input type="hidden" name="Merchant_Id" value="<?php echo $Merchant_Id; ?>">
  <input type="hidden" name="Amount" value="<?php echo $Amount; ?>">
  <input type="hidden" name="Order_Id" value="<?php echo $Order_Id; ?>">
  <input type="hidden" name="Redirect_Url" value="<?php echo $Redirect_Url; ?>">
  <input type="hidden" name="Checksum" value="<?php echo $Checksum; ?>">
  <input type="hidden" name="billing_cust_name" value="<?php echo $billing_cust_name; ?>"> 
  <input type="hidden" name="billing_cust_address" value="<?php echo $billing_cust_address; ?>"> 
  <input type="hidden" name="billing_cust_country" value="<?php echo $billing_cust_country; ?>"> 
  <input type="hidden" name="billing_cust_state" value="<?php echo $billing_cust_state; ?>"> 
  <input type="hidden" name="billing_zip" value="<?php echo $billing_zip; ?>"> 
  <input type="hidden" name="billing_cust_tel" value="<?php echo $billing_cust_tel; ?>"> 
  <input type="hidden" name="billing_cust_email" value="<?php echo $billing_cust_email; ?>"> 
  <input type="hidden" name="delivery_cust_name" value="<?php echo $delivery_cust_name; ?>"> 
  <input type="hidden" name="delivery_cust_address" value="<?php echo $delivery_cust_address; ?>"> 
  <input type="hidden" name="delivery_cust_country" value="<?php echo $delivery_cust_country; ?>"> 
  <input type="hidden" name="delivery_cust_state" value="<?php echo $delivery_cust_state; ?>"> 
  <input type="hidden" name="delivery_cust_tel" value="<?php echo $delivery_cust_tel; ?>"> 
  <input type="hidden" name="delivery_cust_notes" value="<?php echo $delivery_cust_notes; ?>"> 
  <input type="hidden" name="Merchant_Param" value="<?php echo $Merchant_Param; ?>"> 
  <input type="hidden" name="billing_cust_city" value="<?php echo $billing_cust_city; ?>"> 
  <input type="hidden" name="billing_zip_code" value="<?php echo $billing_zip; ?>"> 
  <input type="hidden" name="delivery_cust_city" value="<?php echo $delivery_cust_city; ?>"> 
  <input type="hidden" name="delivery_zip_code" value="<?php echo $delivery_zip_code; ?>"> 
</form>
</body>
</html>