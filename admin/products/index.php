<?php
  require_once("../../_/init.php");
  check_login();
  
  $products = Product::find_all();
?>
<?php get_admin_header('Products'); ?>

<h1>Products&nbsp;<a href="new" style="border:0" title="Add a new Product">+</a></h1>

<table class="table">
  <tr class="header">
    <th style="width:25%;">Name</th>
    <th style="width:15%;">Brand</th>
    <th style="width:15%;">Category</th>
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
    <td style="text-align:center;"><?php echo $product->price; ?></td>
    <td style="text-align:center;"><?php echo $product->quantity; ?></td>
    <td style="text-align:center;"><input type="checkbox" disabled="disabled" <?php if($product->visible == '1') echo " checked='checked' "; ?>/></td>
    <td><a href="show?id=<?php echo $product->id; ?>">Edit</a></td>
  </tr>
  <?php endforeach; ?>
</table>


<?php get_admin_footer(); ?>
