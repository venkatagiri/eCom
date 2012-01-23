<?php 
  require_once("../../_/init.php");
  check_login();
  
  if(isset($_POST['submit'])) {
    $category = Category::make($_POST['category']);
    
    if($category->create()) {
      $session->message("Category '{$category->name}' was created successfully!");
      redirect_to("show?id={$category->id}");
    } else {
      $message = "Category creation failed! Please try again after sometime!";
    }
  } else {
    // An empty category. Just a place holder to reduce repetition.
    $category = new Category();
  }
  
  if(!isset($_GET['parent_id'])) {
    $error = "Oops! Looks like something went wrong! ";
  } else {
    $parent_category = Category::find_by_id($_GET['parent_id']);
    if(!$parent_category) {
      $error = "Invalid Parent Category";
    }
  }
  
?>
<?php get_admin_header('New | Categories'); ?>

<h1>Categories / New</h1>

<?php if(isset($error)) { ?>

<h2><?php echo $error; ?></h2>

<?php } else {?>

<form method="post" name="form_category" class="form">
  <div class="entry">
    <label for="name">Name</label>
    <input type="text" name="category[name]" value="<?php echo $category->name; ?>"/>
  </div>
  
  <div class="entry">
    <label for="description">Description</label>
    <textarea name="category[description]" rows="3"><?php echo $category->description; ?></textarea>
  </div>
  
  <div class="entry">
    <label for="parent_id">Parent Category</label>
    <input type="hidden" name="category[parent_id]" value="<?php echo $parent_category->id; ?>" />
    <input type="text" name="parent_name" readonly value="<?php echo $parent_category->name; ?>"/>
  </div>
  
  <div class="entry">
    <label for="visible">Visible?</label>
    <input type="checkbox" name="category[visible]" value="1" <?php if($category->visible == '1') { ?>checked="checked" <?php } ?> />
  </div>
  
  <div class="entry">
    <label for="submit"> </label>
    <input type="submit" name="submit" value="Create" />
  </div>
</form>

<?php } ?>

<?php get_admin_footer(); ?>
