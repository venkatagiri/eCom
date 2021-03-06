<?php 
  require_once("../../core/init.php");
  check_login();
  
  $root = Category::root_category();
  $main_categories = $root->children();

?>
<?php get_admin_header('Categories'); ?>

<h1>Categories</h1>

<ul id="root-node" class="list">
  <li class="node opened">
    <span class="toggle"></span>
    <span class="header"><?php echo $root->name; ?></span>
    <a href="new?parent_id=<?php echo $root->id ?>" title="Add a sub Category" class="new_entry">+</a>
    <ul class="list">
    <?php foreach($main_categories as $main_category) { ?>
      <li class="node closed">
        <span class="toggle"></span>
        <a href="show?id=<?php echo $main_category->id; ?>" class="header"><?php echo $main_category->name; ?></a>
        <a href="new?parent_id=<?php echo $main_category->id; ?>" title="Add a sub Category" class="new_entry">+</a>
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

<script>
$('.node > .toggle').click(function() {
  $(this).parent().toggleClass('opened').toggleClass('closed');
});
</script>

<?php get_admin_footer(); ?>