<?php 
  require_once("../../core/init.php");
  check_login();
  
  if(isset($_POST['create'])) {
    $attribute = Attribute::make($_POST['attribute']);
    
    if($attribute->create()) {
      $session->message("Attribute was successfully created!");
      redirect_to("show?id={$attribute->id}");
    } else {
      $message = "Attribute creation failed! Please try again after sometime!";
    }
  } else {
    // An empty attribute. Just a place holder to reduce repetition.
    $attribute = new Attribute();
  }
  
  if(!isset($_GET['group_id'])) {
    return show_404();
  } else {
    $group = Attribute::find_by_id($_GET['group_id']);
    if(!$group || ($group->group_id != 1 && $group->id != 1)) {
      return show_404();
    }
  }
  
?>
<?php get_admin_header('New | Attributes'); ?>

<h1>Attributes / New</h1>

<form method="post" name="form_attribute" class="form">
  <div class="entry">
    <label for="attribute[name]">Name</label>
    <input type="text" name="attribute[name]" value="<?php echo $attribute->name; ?>"/>
  </div>
  
  <div class="entry">
    <label for="attribute[group_id]">Group</label>
    <?php if($group->id == 1) { ?>
      <input type="hidden" name="attribute[group_id]" value="<?php echo $group->id; ?>" />
      <input type="text" name="group-name" readonly value="<?php echo $group->name; ?>" />
    <?php } else { ?>
      <select name="attribute[group_id]">
      <?php 
        foreach(Attribute::all_groups() as $g) { 
          if($group->id == $g->id) $is_selected = 'selected="selected"';
          else $is_selected = '';
      ?>
        <option value="<?php echo $g->id; ?>" <?php echo @$is_selected; ?> >
          <?php echo $g->name; ?>
        </option>
      <?php } ?>
      </select>
    <?php } ?>
  </div>
  
  <div class="entry">
    <label for="submit"> </label>
    <input type="submit" name="create" value="Create" />
    <input type="button" name="cancel" value="Cancel" onclick="window.location='/admin/attributes'" />
  </div>
</form>

<?php get_admin_footer(); ?>
