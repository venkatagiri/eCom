<?php 
  require_once("../../_/init.php");
  check_login();
  
  if(isset($_POST['save'])) {
    $product = Product::make($_POST['product']);
    $uploader = new Uploader($_FILES['product-image'], PRODUCT_PATH);
    
    if($uploader->is_uploaded()) {
      // TODO A new image is attached, delete old image.
      $product->image = $uploader->file_name;
      if($product->save()) {
        $session->message("Product '{$product->name}' was updated successfully!");
        redirect_to("show?id={$product->id}");
      } else {
        $message = "Product updation failed! Please try again after sometime!";
      }
    } else if($uploader->error_code() == 4) {
      if($product->save()) {
        $session->message("Product '{$product->name}' was updated successfully!");
        redirect_to("show?id={$product->id}");
      } else {
        $message = "Product updation failed! Please try again after sometime!";
      }
    } else {
      $message = join(', ', $uploader->errors);
    }
  } else if(isset($_GET['id']) && $_GET['id'] != "") {
    $product = Product::find_by_id($_GET['id']);
    if(!$product) {
      echo "404";
      return;
    }
  } else {
    echo "404";
    return;
  }
  
?>
<?php get_admin_header('Show | Products'); ?>

<h1>Products</h1>

<?php if(isset($error)) { ?>

<div class="error"><?php echo $error; ?></div>

<?php } else {?>

<form method="post" enctype="multipart/form-data" name="form_product" class="form">
  <input type="hidden" name="product[id]" value="<?php echo $product->id; ?>" />
  
  <div class="entry right">
    <input type="hidden" name="product[image]" value="<?php echo $product->image; ?>" />
    <img src="/assets/p/<?php echo $product->image; ?>" style="max-width:300px;max-height:300px;" />
  </div>
  
  <div class="entry">
    <label for="product[name]">Name</label>
    <input type="text" name="product[name]" value="<?php echo $product->name; ?>"/>
  </div>
  
  <div class="entry">
    <label for="description">Description</label>
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
    <input type="checkbox" name="product[visible]" value="1" <?php if($product->visible == '1') { ?>checked="checked" <?php } ?> />
  </div>
  
  <div class="entry">
    <label for="submit"> </label>
    <input type="submit" name="save" value="Save" />
    <input type="button" name="cancel" value="Cancel" onclick="window.location='/admin/products'" />
  </div>
  
</form>

<?php } ?>

<?php get_admin_footer(); ?>
