<?php
  require_once("../../core/init.php");
  check_login();
  
  if(isset($_POST['create'])) {
    $banner = Banner::make($_POST['banner']);
    $uploader = new Uploader($_FILES['banner-image'], $IMAGES_PATH['BANNER']);
    
    if($uploader->is_uploaded()) {
      $banner->image = $uploader->file_name;
      
      if($banner->create()) {
        $session->message("Banner '{$banner->name}' was created successfully!");
        redirect_to("show?id={$banner->id}");
      } else {
        $message = "Banner creation failed! Please try again after sometime!";
      }
    } else {
      $message = join(', ', $uploader->errors);
    }
  } else {
    $banner = new Banner();
  }

?>
<?php get_admin_header('New | Banners'); ?>

<h1>Banners</h1>

<form method="post" enctype="multipart/form-data" name="form_banners" class="form">
  <div class="entry">
    <label for="banner[name]">Name</label>
    <input type="text" name="banner[name]" value="<?php echo $banner->name; ?>"/>
  </div>
  
  <div class="entry">
    <label for="banner[type]">Type</label>
    <select name="banner[type]">
      <option value="0">Select a Type</option>
      <?php 
        foreach($BANNER_TYPES as $key => $value) {
          echo "<option value=\"{$key}\"";
          if($key == $banner->type) echo "selected='selected'";
          echo ">$value</option>";
        }
      ?>
    </select>
  </div>
    
  <div class="entry">
    <label for="banner[category_id]">Category</label>
    <select name="banner[category_id]">
      <?php echo list_main_categories($banner->category_id); ?>
    </select>
    (Only applicable when 'Category' is selected in above list)
  </div>
 
  <div class="entry">
    <label for="banner[image]">Image</label>
    <input type="file" name="banner-image" />
  </div>
  
  <div class="entry">
    <label for="banner[link]">Link</label>
    <input type="text" name="banner[link]" value="<?php echo $banner->link; ?>"/>
  </div>

  <div class="entry">
    <label for="banner[width]">Width</label>
    <input type="text" name="banner[width]" size="4" value="<?php echo $banner->width; ?>" style="width: 40px;"/> px
  </div>
  
  <div class="entry">
    <label for="banner[height]">Height</label>
    <input type="text" name="banner[height]" size="4" value="<?php echo $banner->height; ?>" style="width: 40px;"/> px
  </div>

  <div class="entry">
    <label for="banner[visible]">Visible?</label>
    <input type="checkbox" name="banner[visible]" value="1" <?php if($banner->visible == '1') echo "checked=\"checked\""; ?> />
  </div>

  <div class="entry">
    <label for="submit"> </label>
    <input type="submit" name="create" value="Create" />
    <input type="button" name="cancel" value="Cancel" onclick="window.location='/admin/banners'" />
  </div>
  
</form>

<?php get_admin_footer(); ?>
