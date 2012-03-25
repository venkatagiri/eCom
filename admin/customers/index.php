<?php
  require_once("../../core/init.php");
  check_login();
  parse_str($_SERVER['QUERY_STRING'], $QS);
  sanitize($QS, array('page', 'status'));
  $page = isset($QS['page']) ? $QS['page'] : 1;
  
  list($pg, $customers) = Customer::find_with_pagination('1=1', $page, 10);
  
  if(empty($customers)) {
    $error = "No customers to show.";
  }
?>
<?php get_admin_header('Customers'); ?>

<h1>Customers</h1>

<?php if(isset($error)) { ?>

<div class="error"><?php echo $error; ?></div>

<?php } else { ?>

<table class="table">
  <tr class="header">
    <th>Email</th>
    <th style="width:25%;">Name</th>
    <th style="width:10%;">City</th>
    <th style="width:10%;">State</th>
    <th style="width:15%;">Telephone</th>
    <th style="width:5%;"></th>
  </tr>
  <?php foreach($customers as $customer): ?>
  <tr>
    <td><?php echo $customer->email; ?></td>
    <td><?php echo $customer->first_name . " " . $customer->last_name; ?></td>
    <td><?php echo $customer->city; ?></td>
    <td><?php echo $customer->state; ?></td>
    <td><?php echo $customer->telephone; ?></td>
    <td><a href="show?id=<?php echo $customer->id; ?>">Show</a></td>
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