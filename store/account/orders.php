<?php 
  require_once("../../core/init.php");
  check_customer_login();
  $customer = $session->get_customer();

  parse_str($_SERVER['QUERY_STRING'], $QS);
  sanitize($QS, array('page', 'status'));
  $page = isset($QS['page']) ? $QS['page'] : 1;
  
  list($pg, $orders) = Order::find_with_pagination("customer_id={$customer->id}", $page, 10);
  
  if(empty($orders)) {
    $error = "Boo Hoo! No Orders to show. Go on and shop to you heart's content at <a href='/'>the store</a>";
  }
?>
<?php get_store_header('My Orders | Account'); ?>

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

<h1>My Orders</h1>

<?php if(isset($error)) { ?>

<div class="error"><?php echo $error; ?></div>

<?php } else { ?>

<table class="table">
  <tr class="header">
    <th style="width:10%;">Order No.</th>
    <th style="width:25%;">Products</th>
    <th style="width:25%;">Shipping Address</th>
    <th style="width:15%;">Total Amount</th>
    <th style="width:15%;">Status</th>
  </tr>
  <?php foreach($orders as $order): ?>
  <tr>
    <td><a href="order_details?id=<?=$order->id?>"># <?=$order->id?></a></td>
    <td>
      <?php foreach($order->products() as $product) { ?>
        <?=$product->name?> - Rs. <?=$product->price?>
      <?php } ?>
    </td>
    <td><?=nl2br($order->address())?></td>
    <td>Rs. <?=$order->total_amount?></td>
    <td><?=$ORDER_STATUS[$order->status]?></td>
  </tr>
  <?php endforeach; ?>
</table>

<div class="page_controls">
<?php
    if($pg->total_pages() > 1) {
      if($pg->previous_exists()) {
        echo "<a href='?page={$pg->previous_page()}' >&laquo; Previous</a>&nbsp;&nbsp;";
      }
      for($i=1; $i<=$pg->total_pages(); $i++) {
        if($i == $page) {
          echo "&nbsp;&nbsp;<strong>{$i}</strong>&nbsp;&nbsp;";
        } else {
          echo "&nbsp;&nbsp;<a href='?page={$i}'>{$i}</a>&nbsp;&nbsp;";
        }
      }
      if($pg->next_exists()) {
        echo "&nbsp;&nbsp;<a href='?page={$pg->next_page()}' >Next &raquo;</a>";
      }      
    }
?>
</div>

<?php } ?>

</section>

<?php get_store_footer(); ?>