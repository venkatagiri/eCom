<?php 
  require_once("../../core/init.php");
  check_login();
  
  $root = Attribute::root_group();
  $groups = $root->attributes();
?>
<?php get_admin_header('Attributes'); ?>

<h1>Attributes</h1>

<ul id="root-node" class="list">
  <li class="node opened">
    <span class="toggle"></span>
    <span class="header"><?php echo $root->name; ?></span>
    <a href="new?group_id=<?php echo $root->id ?>" title="Add an Attribute Group" class="new_entry">+</a>
    <ul class="list">
    <?php foreach($groups as $group) { ?>
      <li class="node closed">
        <span class="toggle"></span>
        <a href="show?id=<?php echo $group->id; ?>" class="header"><?php echo $group->name; ?></a>
        <a href="new?group_id=<?php echo $group->id; ?>" title="Add a new Attribute " class="new_entry">+</a>
        <ul class="list">
        <?php foreach($group->attributes() as $attribute) { ?>
          <li class="node leaf">
              <span class="toggle"></span>
              <a href="show?id=<?php echo $attribute->id; ?>" class="header"><?php echo $attribute->name; ?></a>
          </li>
        <?php } ?>
        </ul>
      </li>
    <?php } ?>
    </ul>
  </li>
</ul>

<script>
$('.node > .toggle').click(function() {
  $(this).parent().toggleClass('opened').toggleClass('closed');
});
</script>

<?php get_admin_footer(); ?>