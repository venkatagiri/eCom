<?php
  require_once("../../core/init.php");
  check_login();
  parse_str($_SERVER['QUERY_STRING'], $QS);
  sanitize($QS, array('page'));
  $page = isset($QS['page']) ? $QS['page'] : 1;
  
  list($pg, $products) = Product::find_with_pagination('1=1', $page, 10);
  
  if(empty($products)) {
    $error = "No Products to show";
  }
?>
<?php get_admin_header('Products'); ?>

<h1>Products<a href="new" class="new" title="Add a new Product">+</a></h1>

<?php if(isset($error)) { ?>

<div class="error"><?php echo $error; ?></div>

<?php } else {?>

<table class="table">
  <tr class="header">
    <th>Name</th>
    <th style="width:20%;">Brand</th>
    <th style="width:20%;">Category</th>
    <th style="width:15%;">Last Modified</th>
    <th style="width:5%;">Price</th>
    <th style="width:5%;">Qty</th>
    <th style="width:5%;">Visible</th>
    <th style="width:5%;"></th>
  </tr>
  <?php foreach($products as $product): ?>
  <tr>
    <td><?php echo $product->name; ?></td>
    <td><?php echo $product->brand()->name; ?></td>
    <td><?php echo $product->category()->name; ?></td>
    <td><?php echo $product->date_modified; ?></td>
    <td style="text-align:center;"><?php echo $product->price; ?></td>
    <td style="text-align:center;"><?php echo $product->quantity; ?></td>
    <td style="text-align:center;"><input type="checkbox" disabled="disabled" <?php if($product->visible == '1') echo " checked='checked' "; ?>/></td>
    <td><a href="show?id=<?php echo $product->id; ?>">Edit</a></td>
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
