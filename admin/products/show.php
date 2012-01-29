<?php 
  require_once("../../_/init.php");
  check_login();
  
  if(isset($_POST['submit'])) {
    $product = Product::make($_POST['product']);
    $product->id = $_GET['id'];
    
    if($product->save()) {
      $session->message("Product '{$product->name}' was updated successfully!");
      redirect_to("show?id={$product->id}");
    } else {
      $message = "Product updation failed! Please try again after sometime!";
    }
  } else if(isset($_GET['id']) && $_GET['id'] != "") {
    $product = Product::find_by_id($_GET['id']);
    if(!$product) {
      $error = "Invalid Product ID. Please go back and try again!";
    }
  } else {
    $error = "Oops! Looks like something went wrong! ";
  }
  
?>
<?php get_admin_header('Show | Products'); ?>

<h1>Products</h1>

<?php if(isset($error)) { ?>

<h2><?php echo $error; ?></h2>

<?php } else {?>

<form method="post" name="form_product" class="form">
  <div class="entry">
    <label for="product[name]">Name</label>
    <input type="text" name="product[name]" value="<?php echo $product->name; ?>"/>
  </div>
  
  <div class="entry">
    <label for="description">Description</label>
    <textarea name="product[description]" rows="3"><?php echo $product->description; ?></textarea>
  </div>
  
  <div class="entry">
    <label for="product[price]">Price</label>
    <input type="text" name="product[price]" value="<?php echo $product->price; ?>"/>
  </div>
  
  <div class="entry">
    <label for="product[quantity]">Quantity</label>
    <input type="text" name="product[quantity]" value="<?php echo $product->quantity; ?>"/>
  </div>
  
  <div class="entry">
    <label for="product[brand_id]">Brand</label>
    <?php echo list_brands($product->brand_id); ?>
  </div>
  
  <div class="entry">
    <label for="product[category_id]">Category</label>
    <?php echo list_categories($product->category_id); ?>
  </div>
  
  <div class="entry">
    <label for="product[visible]">Visible?</label>
    <input type="checkbox" name="product[visible]" value="1" <?php if($product->visible == '1') { ?>checked="checked" <?php } ?> />
  </div>
  
  <div class="entry">
    <label for="submit"> </label>
    <input type="submit" name="submit" value="Save" />
  </div>
  
</form>

<?php } ?>

<?php get_admin_footer(); ?>
