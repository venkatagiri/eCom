<?php 
  require_once("../../_/init.php");
  check_login();
  
  if(isset($_POST['create'])) {
    $product = Product::make($_POST['product']);
    $uploader = new Uploader($_FILES['product-image'], PRODUCT_PATH);
    
    if($uploader->is_uploaded()) {
      $product->image = $uploader->file_name;
      
      if($product->create()) {
        $session->message("Product '{$product->name}' was created successfully!");
        redirect_to("show?id={$product->id}");
      } else {
        $message = "Product creation failed! Please try again after sometime!";
      }
    } else {
      $message = $uploader->errors.join(', ');
    }
  } else {
    $product = new Product();
  }
  
?>
<?php get_admin_header('New | Products'); ?>

<h1>Products / New</h1>

<form method="post" enctype="multipart/form-data" name="form_product" class="form">
  <div class="entry">
    <label for="product[name]">Name</label>
    <input type="text" name="product[name]" value="<?php echo $product->name; ?>"/>
  </div>
  
  <div class="entry">
    <label for="product[description]">Description</label>
    <textarea name="product[description]" rows="6"><?php echo $product->description; ?></textarea>
  </div>
  
  <div class="entry">
    <label for="product[image]">Image</label>
    <input type="file" name="product-image" />
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
    <input type="checkbox" name="product[visible]" value="1" <?php if($product->visible == '1') echo "checked=\"checked\""; ?> />
  </div>
  
  <div class="entry">
    <label for="submit"> </label>
    <input type="submit" name="create" value="Create" />
    <input type="button" name="cancel" value="Cancel" onclick="window.location='/admin/products'" />
  </div>
  
</form>

<?php get_admin_footer(); ?>
