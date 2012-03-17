<?php 
  require_once("../../core/init.php");
  check_login();

  if(isset($_POST['save'])) {
    $attribute = Attribute::make($_POST['attribute']);
    
    if($attribute->save()) {
      $session->message("Attribute '{$attribute->name}' was saved successfully!");
      redirect_to("show?id={$attribute->id}");
    } else {
      $message = "An error occured while saving! Please try again after sometime!";
    }
  }
  
  if(!isset($_GET['id']) || $_GET['id'] == 1) {
    return show_404();
  } else {
    $attribute = Attribute::find_by_id($_GET['id']);
    if(!$attribute) {
      return show_404();
    }
  }
  
?>
<?php get_admin_header('Show | Attributes'); ?>

<h1>Attributes</h1>

<form method="post" name="form_attribute" class="form">
  <input type="hidden" name="attribute[id]" value="<?php echo $attribute->id; ?>" />
  <div class="entry">
    <label for="name">Name</label>
    <input type="text" name="attribute[name]" value="<?php echo $attribute->name; ?>"/>
  </div>
  
  <div class="entry">
    <label for="attribute[group_id]">Group</label>
    <?php if($attribute->group_id == 1) { ?>
      <input type="hidden" name="attribute[group_id]" value="<?php echo $attribute->group_id; ?>" />
      <input type="text" name="group-name" readonly value="<?php echo $attribute->group()->name; ?>" />
    <?php } else { ?>
      <select name="attribute[group_id]">
      <?php 
        foreach(Attribute::all_groups() as $group) { 
          if($group->id == $attribute->group_id) $is_selected='selected="selected"';
          else $is_selected = '';
      ?>
        <option value="<?php echo $group->id; ?>" <?php echo @$is_selected; ?> >
          <?php echo $group->name; ?>
        </option>
      <?php } ?>
      </select>
    <?php } ?>
  </div>
  
  <div class="entry">
    <label for="submit"> </label>
    <input type="submit" name="save" value="Save" />
    <input type="button" name="delete" value="Delete" id="delete" />
    <input type="button" name="back" value="Back to List" onclick="window.location='/admin/attributes'" />
  </div>
</form>

<script>
$("#delete").click(function() {
  if(confirm("Are you sure you want to delete?")) {
    window.location = "/admin/attributes/delete?id=<?php echo $attribute->id ?>";
  }
});
</script>

<?php get_admin_footer(); ?>