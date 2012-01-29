<?php
  require_once("../../_/init.php");
  check_login();

  $brands = Brand::find_all();

?>
<?php get_admin_header('Brands'); ?>

<a href="new" title="Add a new Brand" class="button right" style="font-size:90%;">Add a new Brand</a>
<h1>Brands&nbsp;<a href="new" style="border:0" title="Add a new Brand">+</a></h1>

<table class="table">
  <tr class="header">
    <th style="width:25%;">Name</th>
    <th style="width:30%;">Description</th>
    <th>Categories</th>
    <th style="width:5%;">Visible</th>
    <th style="width:5%;"></th>
  </tr>
  <?php foreach($brands as $brand): ?>
  <tr>
    <td><?php echo $brand->name; ?></td>
    <td><?php echo $brand->description; ?></td>
    <td><?php echo $brand->categories(); ?></td>
    <td style="text-align:center;"><input type="checkbox" disabled="disabled" <?php if($brand->visible == '1') echo "checked='checked'"; ?>/></td>
    <td><a href="show?id=<?php echo $brand->id; ?>">Edit</a></td>
  </tr>
  <?php endforeach; ?>
</table>

<?php get_admin_footer(); ?>
