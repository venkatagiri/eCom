<?php 
  require_once("../../core/init.php");
  check_login();
  
  $root = Attribute::root_group();
  $groups = $root->attributes();
?>
<?php get_admin_header('Attributes'); ?>

<h1>Attributes</h1>

<script>
window.onload = function() {
  var toggles = document.querySelectorAll('.node > .toggle');
  for(var i=0, len=toggles.length; i < len; ++i) {
    toggles[i].addEventListener('click', function() {
      this.parentNode.classList.toggle('opened');
      this.parentNode.classList.toggle('closed');
    });
  }
};
</script>

<ul id="root-node" class="list">
  <li class="node opened">
    <span class="toggle"></span>
    <span class="header"><?php echo $root->name; ?></span>
    <a href="new?group_id=<?php echo $root->id ?>" title="Add an Attribute Group" class="add_category">+</a>
    <ul class="list">
    <?php foreach($groups as $group) { ?>
      <li class="node closed">
        <span class="toggle"></span>
        <a href="show?id=<?php echo $group->id; ?>" class="header"><?php echo $group->name; ?></a>
        <a href="new?group_id=<?php echo $group->id; ?>" title="Add a new Attribute " class="add_category">+</a>
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

<?php get_admin_footer(); ?>
