<?php 
  require_once("../../core/init.php");
  check_login();
  
  if(isset($_POST['save'])) {
    $product = Product::make($_POST['product']);
    $product_attributes = ProductAttribute::make_array($_POST['product']['attribute']);
    $product_features = ProductFeature::make_array($_POST['product']['feature']);
    $uploader = new Uploader($_FILES['product-image'], $IMAGES_PATH['PRODUCT']);
    
    $old_attr_ids = ProductAttribute::get_ids($product->id);
    $old_feature_ids = ProductFeature::get_ids($product->id);

    if($uploader->is_uploaded()) {
      // TODO A new image is attached, delete old image.
      $product->image = $uploader->file_name;
      if($product->save() 
          && $product->add_attributes($product_attributes)
          && $product->add_features($product_features)) {
        ProductAttribute::delete_attributes($old_attr_ids);
        ProductFeature::delete_features($old_feature_ids);
        $session->message("Product '{$product->name}' was updated successfully!");
        redirect_to("show?id={$product->id}");
      } else {
        $message = "Product updation failed! Please try again after sometime!";
      }
    } else if($uploader->error_code() == 4) {
      if($product->save() 
          && $product->add_attributes($product_attributes)
          && $product->add_features($product_features)) {
        ProductAttribute::delete_attributes($old_attr_ids);
        ProductFeature::delete_features($old_feature_ids);
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
      return show_404();
    }
    $product_attributes = $product->attributes();
    $product_features = $product->features();
  } else {
    return show_404();
  }
  
?>
<?php get_admin_header('Show | Products'); ?>

<span class="right">
  <input type="submit" name="save" value="Save" onclick="$('#save').click();"/>
  <input type="button" name="delete" value="Delete" onclick="$('#delete').click();" />
  <input type="button" name="back" value="Back to List" onclick="window.location='/admin/products'" />
</span>

<h1>Products</h1>

<form method="post" enctype="multipart/form-data" name="form_product" class="form">
  <input type="hidden" name="product[id]" value="<?php echo $product->id; ?>" />
  
  <h2 class="sub_heading">General</h2>
  <div class="entry right">
    <input type="hidden" name="product[image]" value="<?php echo $product->image; ?>" />
    <img src="/assets/product/<?php echo $product->image; ?>" style="max-width:300px;max-height:300px;" />
  </div>
  <div class="entry">
    <label for="product[name]">Name</label>
    <input type="text" name="product[name]" value="<?php echo $product->name; ?>"/>
  </div>
  <div class="entry">
    <label for="product[short_description]">Short Description<br />(upto 250 chars)</label>
    <textarea name="product[short_description]" rows="8" 
      onkeydown="if(value.length>250)value=value.substr(0,250); if(value.length==250)if(window.event.keyCode>46 && window.event.keyCode<112 || window.event.keyCode>123)return false;"><?php echo $product->short_description; ?></textarea>
  </div>
  <div class="entry">
    <label for="product[description]">Description</label>
    <textarea name="product[description]" rows="15" class="long"><?php echo $product->description; ?></textarea>
  </div>
  <div class="entry">
    <label for="product[status]">Status</label>
    <select name="product[status]">
      <option value="0" <?php if($product->status == '0') echo "selected=\"selected\""; ?> >Disabled</option>
      <option value="1" <?php if($product->status == '1') echo "selected=\"selected\""; ?> >Enabled</option>
    </select>
  </div>
  
  <h2 class="sub_heading">Data</h2>
  <div class="entry">
    <label for="product[image]">Image</label>
    <input type="file" name="product-image" />
  </div>
  <div class="entry">
    <label for="product[price]">Price</label>
    <input type="text" name="product[price]" value="<?php echo $product->price; ?>" class="short" />
  </div>
  <div class="entry">
    <label for="product[quantity]">Quantity</label>
    <input type="text" name="product[quantity]" value="<?php echo $product->quantity; ?>" class="short" />
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

  <h2 class="sub_heading">Key Features</h2>
  <div class="entry" id="features-list">
    <?php 
      $count = 0;
      foreach($product_features as $pf) {
        $count++;
    ?>
    <div class="entry feature_entry">
      <label for="product[category_id]">Feature <?php echo $count; ?></label>
      <input type="text" name="product[feature][<?php echo $count; ?>][value]" value="<?php echo $pf->value; ?>" />
    </div>
    <?php
      }
      while($count < 4) {
        $count++;
    ?>
    <div class="entry feature_entry">
      <label for="product[category_id]">Feature <?php echo $count; ?></label>
      <input type="text" name="product[feature][<?php echo $count; ?>][value]" value="" />
    </div>
    <?php
      }
    ?>
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
    <input type="submit" name="save" value="Save" id="save" />
    <input type="button" name="delete" value="Delete" id="delete" />
    <input type="button" name="back" value="Back to List" onclick="window.location='/admin/products'" />
  </div>
</form>

<script>
$("#delete").click(function() {
  if(confirm("Are you sure you want to delete?")) {
    window.location = "/admin/products/delete?id=<?php echo $product->id ?>";
  }
});
</script>

<?php get_admin_footer(); ?>