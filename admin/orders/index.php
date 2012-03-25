<?php
  require_once("../../core/init.php");
  check_login();
  parse_str($_SERVER['QUERY_STRING'], $QS);
  sanitize($QS, array('page', 'status'));
  $page = isset($QS['page']) ? $QS['page'] : 1;
  
  list($pg, $orders) = Order::find_with_pagination('1=1', $page, 10);
  
  if(empty($orders)) {
    $error = "No Orders to show.";
  }
?>
<?php get_admin_header('Orders'); ?>

<h1>Orders</h1>

<?php if(isset($error)) { ?>

<div class="error"><?php echo $error; ?></div>

<?php } else { ?>

<table class="table">
  <tr class="header">
    <th>Name</th>
    <th style="width:25%;">Email</th>
    <th style="width:15%;">Total Amount</th>
    <th style="width:15%;">Status</th>
    <th style="width:5%;"></th>
  </tr>
  <?php foreach($orders as $order): ?>
  <tr>
    <td><?php echo $order->shipping_name; ?></td>
    <td><?php echo $order->shipping_email; ?></td>
    <td>Rs. <?php echo $order->total_amount; ?></td>
    <td><?php echo $ORDER_STATUS[$order->status]; ?></td>
    <td><a href="show?id=<?php echo $order->id; ?>">Show</a></td>
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

<?php get_admin_footer(); ?>