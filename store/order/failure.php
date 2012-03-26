<?php 
  require_once("../../core/init.php");

  if(!$session->get('order_id')) redirect_to('/'); // Invalid Request

  $order = Order::find_by_id($session->get('order_id'));

  if(!$order) redirect_to('/'); // Invalid Request
  if(!$session->get('payment_failure')) redirect_to('/'); // Invalid Order
  
  $customer = Customer::find_by_id($order->customer_id);
  
?>
<?php get_store_meta('Failure | Order'); ?>

<body>
<header><div class="wrapper">
  <span class="right" style="padding:15px 30px 0 0;">Hi, <?php echo $customer->email; ?></span>
  <h1><?php echo STORE_NAME; ?></h1>
</div></header>

<div class="content wrapper order-page">

<section role="main" id="main" class="only-section">
<h1>Oops!</h1>

<div class="failure-summary">
  <p>Looks like the transaction has failed!</p>
  <p>If you feel this is in <strong>error</strong> and have already paid, feel free to fill out <a href="/account/request_refund">this form</a> and apply for a refund!</p>
</div>
</section>

<?php get_store_footer(); ?>