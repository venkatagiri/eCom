<?php 
  require_once("../../core/init.php");
  check_login();
  
  if(isset($_POST['save'])) {
    $brand = Brand::make($_POST['brand']);
    
    if($brand->save()) {
      $session->message("Brand '{$brand->name}' was updated successfully!");
      redirect_to("show?id={$brand->id}");
    } else {
      $message = "Brand updation failed! Please try again after sometime!";
    }
  } else if(isset($_GET['id']) && $_GET['id'] != "") {
    $brand = Brand::find_by_id($_GET['id']);
    if(!$brand) {
      return show_404();
    }
  } else {
    return show_404();
  }
  
?>
<?php get_admin_header('Brands'); ?>

<h1>Brands</h1>

<form method="post" name="form_brand" class="form">
  <input type="hidden" name="brand[id]" value="<?php echo $brand->id; ?>" />
  <div class="entry">
    <label for="brand[name]">Name</label>
    <input type="text" name="brand[name]" value="<?php echo $brand->name; ?>"/>
  </div>
  
  <div class="entry">
    <label for="description">Description</label>
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
    <input type="submit" name="save" value="Save" />
    <input type="button" name="delete" value="Delete" id="delete" />
    <input type="button" name="back" value="Back to List" onclick="window.location='/admin/brands'" />
  </div>
</form>

<script>
$("#delete").click(function() {
  if(confirm("Are you sure you want to delete?")) {
    window.location = "/admin/brands/delete?id=<?php echo $brand->id ?>";
  }
});
</script>

<?php get_admin_footer(); ?>