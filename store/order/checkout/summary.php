<?php 
  require_once("../../../core/init.php");

  if(!$session->get('order_id')) redirect_to('/'); // Invalid Request

  $order = Order::find_by_id($session->get('order_id'));

  if(!$order) redirect_to('/'); // Invalid Request! LOG HERE

  $customer = $session->get_customer();
?>
<?php get_store_meta('Order Summary | Checkout | Shopping Cart'); ?>

<body>
<header><div class="wrapper">
  <span class="right" style="padding:15px 30px 0 0;">Hi, <?php echo $customer->email; ?></span>
  <h1><?php echo STORE_NAME; ?></h1>
</div></header>

<div class="content wrapper shopping-cart-page">

<section role="main" id="main" class="only-section">
<h1>3. Order Summary</h1>

<form action="redirect_to_ccavenue" method="post" name="summary_form" class="form">  
  <input type="hidden" name="order_id" value="<?php echo $order->id; ?>" />
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
  <br />
  <input type="image" name="continue" value="Continue" src="/images/proceed-to-payment.png" />
</form>

</section>

<?php get_store_footer(); ?>