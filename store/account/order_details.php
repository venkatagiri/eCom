<?php 
  require_once("../../core/init.php");
  check_customer_login();

  $customer = $session->get_customer();
  $order = false;
  
  if(isset($_GET['id']) && $_GET['id'] != "") {
    $order = Order::find_one("id = {$_GET['id']} AND customer_id = {$customer->id}");
    if(!$order) {
      redirect_to('orders');
    }
  } else {
    redirect_to('orders');
  }
  
?>
<?php get_store_header('Show | Orders'); ?>

<aside>
  <ul>
    <li class="box">
      <h6 class="header">Controls</h6>
      <ul class="list">
        <li><a href="orders">My Orders</a></li>
        <li><a href="address">Shipping Address</a></li>
        <li><a href="password">Change Password</a></li>
      </ul>
    </li>
  </ul>
</aside>

<section role="main" id="main">

<h1>Orders / #<?=$order->id?></h1>

<table class="details">
  <tr>
    <th>Order No.</th>
    <td><?=$order->id?></td>
  </tr>
  <tr>
    <th>Products</th>
    <td>
      <?php foreach($order->products() as $product) { ?>
        <?=$product->name?> - Rs. <?=$product->price?>
      <?php } ?>
    </td>
  </tr>
  <tr>
    <th>Total Amount</th>
    <td>Rs. <?=$order->total_amount?></td>
  </tr>
  <tr>
    <th>Name</th>
    <td><?=$order->shipping_name?></td>
  </tr>
  <tr>
    <th>Shipping Address</th>
    <td><?=nl2br($order->address())?></td>
  </tr>
  <tr>
    <th>Status</th>
    <td><?=$ORDER_STATUS[$order->status]?></td>
  </tr>
</table>

</section>

<?php get_store_footer(); ?>