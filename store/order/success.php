<?php 
  require_once("../../core/init.php");

  if(!$session->get('order_id')) redirect_to('/'); // Invalid Request

  $order = Order::find_by_id($session->get('order_id'));

  if(!$order) redirect_to('/'); // Invalid Request
  if(!$session->get('payment_successful')) redirect_to('/'); // Invalid Order
  
  $customer = Customer::find_by_id($order->customer_id);
  
?>
<?php get_store_meta('Success | Order'); ?>

<body>
<header><div class="wrapper">
  <span class="right" style="padding:15px 30px 0 0;">Hi, <?php echo $customer->email; ?></span>
  <h1><?php echo STORE_NAME; ?></h1>
</div></header>

<div class="content wrapper order-page">

<section role="main" id="main" class="only-section">
<h1>Thank you for your purchase!</h1>

<div class="success-summary">
  <p>Your order has been received and here are the details.</p>
  <table class="details">
    <tr>
      <th>Order No.</th>
      <td><?php echo $order->id; ?></td>
    </tr>
    <tr>
      <th>Products</th>
      <td>
        <?php foreach($order->products() as $product) { ?>
          <?php echo $product->quantity; ?> - <?php echo $product->name; ?>(Rs. <?php echo $product->price; ?>)
        <?php } ?>
      </td>
    </tr>
    <tr>
      <th>Total Amount</th>
      <td>Rs. <?php echo ($order->total_amount); ?></td>
    </tr>
    <tr>
      <th>Shipping Address</th>
      <td><?php echo nl2br($order->address()); ?></td>
    </tr>
  </table>
  <p>You will receive an order confirmation email(<?php echo $order->shipping_email; ?>) with details of your order and a link to track its progress</p>
</div>
</section>

<?php get_store_footer(); ?>