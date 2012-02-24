<?php 
  require_once("../../core/init.php");
  check_login();
  
  $root = Category::root_category();
  $main_categories = $root->children();

?>
<?php get_admin_header('Categories'); ?>

<h1>Categories</h1>

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
    <a href="new?parent_id=<?php echo $root->id ?>" title="Add a sub Category" class="add_category">+</a>
    <ul class="list">
    <?php foreach($main_categories as $main_category) { ?>
      <li class="node closed">
        <span class="toggle"></span>
        <a href="show?id=<?php echo $main_category->id; ?>" class="header"><?php echo $main_category->name; ?></a>
        <a href="new?parent_id=<?php echo $main_category->id; ?>" title="Add a sub Category" class="add_category">+</a>
        <ul class="list">
        <?php foreach($main_category->children() as $sub_category) { ?>
          <li class="node leaf">
              <span class="toggle"></span>
              <a href="show?id=<?php echo $sub_category->id; ?>" class="header"><?php echo $sub_category->name; ?></a>
          </li>
        <?php } ?>
        </ul>
      </li>
    <?php } ?>
    </ul>
  </li>
</ul>

<?php get_admin_footer(); ?>
