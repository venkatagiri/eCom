<?php 
  require_once("../../_/init.php");
  check_login();
  
  if(isset($_POST['submit'])) {
    $brand = Brand::make($_POST['brand']);
    $brand->id = $_GET['id'];
    
    if($brand->save()) {
      $session->message("Brand '{$brand->name}' was updated successfully!");
      redirect_to("show?id={$brand->id}");
    } else {
      $message = "Brand updation failed! Please try again after sometime!";
    }
  } else if(isset($_GET['id']) && $_GET['id'] != "") {
    $brand = Brand::find_by_id($_GET['id']);
    if(!$brand) {
      $error = "Invalid Brand ID. Please go back and try again!";
    }
  } else {
    $error = "Oops! Looks like something went wrong! ";
  }
  
?>
<?php get_admin_header('Show | Brands'); ?>

<h1>Brands</h1>

<?php if(isset($error)) { ?>

<h2><?php echo $error; ?></h2>

<?php } else {?>

<form method="post" name="form_brand" class="form">
  <div class="entry">
    <label for="brand[name]">Name</label>
    <input type="text" name="brand[name]" value="<?php echo $brand->name; ?>"/>
  </div>
  
  <div class="entry">
    <label for="description">Description</label>
    <textarea name="brand[description]" rows="3"><?php echo $brand->description; ?></textarea>
  </div>
  
  <div class="entry">
    <label for="brand[visible]">Visible?</label>
    <input type="checkbox" name="brand[visible]" value="1" <?php if($brand->visible == '1') { ?>checked="checked" <?php } ?> />
  </div>
  
  <div class="entry">
    <label for="brand[categories]">Category</label>
    <?php echo list_main_categories($brand->categories); ?>
  </div>
  
  <div class="entry">
    <label for="submit"> </label>
    <input type="submit" name="submit" value="Save" />
  </div>
</form>

<?php } ?>

<?php get_admin_footer(); ?>
