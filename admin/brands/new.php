<?php 
  require_once("../../core/init.php");
  check_login();
  
  if(isset($_POST['create'])) {
    $brand = Brand::make($_POST['brand']);
    
    if($brand->create()) {
      $session->message("Brand '{$brand->name}' was created successfully!");
      redirect_to("show?id={$brand->id}");
    } else {
      $message = "Brand creation failed! Please try again after sometime!";
    }
  } else {
    // An empty brand. Just a place holder to reduce repetition.
    $brand = new Brand();
  }
  
?>
<?php get_admin_header('New | Brands'); ?>

<h1>New / Brands</h1>

<form method="post" name="form_brand" class="form">
  <div class="entry">
    <label for="brand[name]">Name</label>
    <input type="text" name="brand[name]" value="<?php echo $brand->name; ?>"/>
  </div>
  
  <div class="entry">
    <label for="brand[description]">Description</label>
    <textarea name="brand[description]" rows="4"><?php echo $brand->description; ?></textarea>
  </div>
  
  <div class="entry">
    <label for="brand[categories]">Category</label>
    <select name="brand[categories]">
      <?php echo list_main_categories($brand->categories); ?>
    </select>
  </div>
  
  <div class="entry">
    <label for="brand[visible]">Visible?</label>
    <input type="checkbox" name="brand[visible]" value="1" <?php if($brand->visible == '1') { ?>checked="checked" <?php } ?> />
  </div>
  
  <div class="entry">
    <label for="submit"> </label>
    <input type="submit" name="create" value="Create" />
    <input type="button" name="cancel" value="Cancel" onclick="window.location='/admin/brands'" />
  </div>
</form>

<?php get_admin_footer(); ?>
