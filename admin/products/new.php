<?php 
  require_once("../../core/init.php");
  check_login();
  
  if(isset($_POST['create'])) {
    $product = Product::make($_POST['product']);
    $product_attributes = ProductAttribute::make_array($_POST['product']['attribute']);
    $uploader = new Uploader($_FILES['product-image'], $IMAGES_PATH['PRODUCT']);
    
    if($uploader->is_uploaded()) {
      $product->image = $uploader->file_name;
      
      if($product->create() && ProductAttribute::create_attributes($product_attributes, $product->id)) {
        $session->message("Product '{$product->name}' was created successfully!");
        redirect_to("show?id={$product->id}");
      } else {
        if(isset($product->id)) {
          $product->delete();
          unset($product->id);
        }
        $message = "Product creation failed! Please try again after sometime!";
      }
    } else {
      $message = join(', ', $uploader->errors);
    }
  } else {
    $product = new Product();
    $product_attributes = array();
  }
  
?>
<?php get_admin_header('New | Products'); ?>

<span class="right">
  <input type="button" name="back" value="Back" onclick="window.location='/admin/products'" />
  <input type="submit" name="create" value="Create" onclick="document.form_product.submit();"/>
</span>

<h1>Products / New</h1>

<form method="post" enctype="multipart/form-data" name="form_product" class="form">
  
  <h2 class="sub_heading">General</h2>
  <div class="entry">
    <label for="product[name]">Name</label>
    <input type="text" name="product[name]" value="<?php echo $product->name; ?>"/>
  </div>
  <div class="entry">
    <label for="product[description]">Description</label>
    <textarea name="product[description]" rows="6"><?php echo $product->description; ?></textarea>
  </div>
  <div class="entry">
    <label for="product[visible]">Visible?</label>
    <input type="checkbox" name="product[visible]" value="1" <?php if($product->visible == '1') echo "checked=\"checked\""; ?> />
  </div>
  
  <h2 class="sub_heading">Data</h2>
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
    <select name="product[brand_id]">
      <?php echo list_brands($product->brand_id); ?>
    </select>
  </div>
  <div class="entry">
    <label for="product[category_id]">Category</label>
    <select name="product[category_id]">
      <?php echo list_categories($product->category_id); ?>
    </select>
  </div>

  <h2 class="sub_heading">Attributes</h2>
  <div class="entry" id="attributes-list">
    <div class="entry attribute_entry hidden">
      <input type="hidden" name="attribute-id" value="" />
      <input type="hidden" name="group-id" value="" />
      <input type="hidden" name="attribute-name" value="" />
      <label for="">Attribute Name</label>
      <input type="text" name="attribute-value" value="" />
      <input type="button" name="remove_entry" class="remove_entry" value="-" style="margin-left: 10px;" title="Remove" />
    </div>
    <?php 
      $count = 0;
      foreach($product_attributes as $pa) {
        $count++;
    ?>
    <div class="entry attribute_entry">
      <input type="hidden" name="product[attribute][<?php echo $count; ?>][attribute_id]" value="<?php echo $pa->attribute_id; ?>" />
      <input type="hidden" name="product[attribute][<?php echo $count; ?>][group_id]" value="<?php echo $pa->group_id; ?>" />
      <input type="hidden" name="product[attribute][<?php echo $count; ?>][name]" value="<?php echo $pa->name; ?>" />
      <label for="product[attribute][<?php echo $count; ?>][value]"><?php echo $pa->name; ?></label>
      <input type="text" name="product[attribute][<?php echo $count; ?>][value]" value="<?php echo $pa->value; ?>" />
      <input type="button" name="remove_entry" class="remove_entry" value="-" style="margin-left: 10px;" title="Remove" />
    </div>
    <?php } ?>
  </div>
  <div class="entry" style="padding-left: 10px;">  
    <select name="attributes" id="select_list">
      <option value="0">Select an Attribute</option>
    <?php foreach(Attribute::all_attributes() as $a) { ?>
      <option value="<?php echo $a->id; ?>" data-groupid="<?php echo $a->group_id; ?>" ><?php echo $a->name; ?></option>
    <?php } ?>
    </select>
    <input type="button" name="add_entry" id="add_entry" value="+" style="margin-left: 10px;"/>
  </div>
  <script>
    var $select_list = $("#select_list");
    var $attribute_entry = $("#attributes-list").find(".attribute_entry.hidden");
    var count=<?php echo $count; ?>;
    $("#add_entry").click(function() {
        // If the attribute is not selected or already added, return.
        if($select_list.val() == 0) return;
        if($('#attributes-list').find('input[name*=attribute_id][value='+$select_list.val()+']').length > 0) return;
        count++;
        $attribute_entry.clone().removeClass("hidden")
          .find("label").attr( {
            "for" : "product[attribute]["+count+"][attribute_id]"
          }).text($("#select_list option:selected").text()).end()
          .find("input[name=attribute-id]").attr({
            "name" : "product[attribute]["+count+"][attribute_id]",
            "value" : $select_list.val()
          }).end()
          .find("input[name=group-id]").attr({
            "name" : "product[attribute]["+count+"][group_id]",
            "value" : $select_list.find(':selected').attr('data-groupid')
          }).end()
          .find("input[name=attribute-name]").attr({
            "name": "product[attribute]["+count+"][name]",
            "value" : $("#select_list option:selected").text()
          }).end()
          .find("input[name=attribute-value]").attr({
            "name": "product[attribute]["+count+"][value]"
          }).end()
          .appendTo("#attributes-list");
    });
    $("#attributes-list").on("click", "input.remove_entry", function() {
      $(this).parent().remove();
    });
  </script>

  <div class="entry">
    <label for="submit"> </label>
    <input type="submit" name="create" value="Create" />
    <input type="button" name="cancel" value="Cancel" onclick="window.location='/admin/products'" />
  </div>
  
</form>

<?php get_admin_footer(); ?>