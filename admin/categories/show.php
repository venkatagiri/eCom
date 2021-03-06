<?php 
  require_once("../../core/init.php");
  check_login();

  if(isset($_POST['save'])) {
    $category = Category::make($_POST['category']);
    
    if($category->save()) {
      $session->message("Category '{$category->name}' was saved successfully!");
      redirect_to("show?id={$category->id}");
    } else {
      $message = "An error occured while saving! Please try again after sometime!";
    }
  }
  
  if(!isset($_GET['id']) || $_GET['id'] == 1) {
    return show_404();
  } else {
    $category = Category::find_by_id($_GET['id']);
    if(!$category) {
      return show_404();
    }
  }
  
?>
<?php get_admin_header('Show | Categories'); ?>

<h1>Categories</h1>

<form method="post" name="form_category" class="form">
  <input type="hidden" name="category[id]" value="<?php echo $category->id; ?>" />
  <div class="entry">
    <label for="name">Name</label>
    <input type="text" name="category[name]" value="<?php echo $category->name; ?>"/>
  </div>
  
  <div class="entry">
    <label for="description">Description</label>
    <textarea name="category[description]" rows="4"><?php echo $category->description; ?></textarea>
  </div>
  
  <div class="entry">
    <label for="parent_id">Parent Category</label>
    <input type="hidden" name="category[parent_id]" value="<?php echo $category->parent_id; ?>" />
    <input type="text" name="parent_category_name" readonly value="<?php echo $category->parent()->name; ?>"/>
  </div>
  
  <div class="entry">
    <label for="visible">Visible?</label>
    <input type="checkbox" name="category[visible]" value="1" <?php if($category->visible == '1') { ?>checked="checked" <?php } ?> />
  </div>
  
  <div class="entry">
    <label for="submit"> </label>
    <input type="submit" name="save" value="Save" />
    <input type="button" name="delete" value="Delete" id="delete" />
    <input type="button" name="back" value="Back to List" onclick="window.location='/admin/categories'" />
  </div>
</form>

<script>
$("#delete").click(function() {
  if(confirm("Are you sure you want to delete?")) {
    window.location = "/admin/categories/delete?id=<?php echo $category->id ?>";
  }
});
</script>

<?php get_admin_footer(); ?>