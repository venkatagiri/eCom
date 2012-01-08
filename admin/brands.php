<?php
	require_once("../_/init.php");
  check_login();

  if(isset($_POST["submit"]) && $_POST["action"] == "add") {
    $brand_name = $_POST["brand_name"];
    if($brand_name != "") {
      if(Brand::exists($brand_name)) {
        $message = "Duplicate Brand name";
      } else {
        $brand = new Brand();
        $brand->name = $brand_name;
        if($brand->save()) {
          $session->message("$brand_name brand was created successfully.");
          redirect_to("brands");
        } else {
          $message = "There was an error while saving the brand. Please try again!";
        }
      }
    } else {
      $message = "Invalid Brand Name";
    }
  }

  $brands = Brand::find_all();

?>
<?php get_admin_header('Brands'); ?>

<h1>Brands</h1>

<form action="" method="post">
  <input type="hidden" name="action" value="add" />
  <input type="text" name="brand_name" value="" />
  <input type="submit" name="submit" value="Add" />
</form>

<h3>There are <?php echo count($brands);  ?> brands.</h3>

<table class="table">
  <tr class="header">
    <th>Name</th>
    <th>Visible</th>
    <th>Categories</th>
  </tr>
  <?php foreach($brands as $brand): ?>
  <tr>
    <td><?php echo $brand->name; ?></td>
    <td><input type="checkbox" <?php if($brand->is_visible == '1') echo "checked='checked'"; ?>/></td>
    <td><?php echo $brand->categories; ?></td>
  </tr>
  <?php endforeach; ?>
</table>
<br />
<a href="brands" class="button">Add a New Brand</a>

<?php get_admin_footer(); ?>
