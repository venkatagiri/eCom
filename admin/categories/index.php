<?php 
  require_once("../../_/init.php");
  check_login();
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
  <?php echo build_categories_tree(Category::find_by_id(1)); ?>
</ul>

<?php get_admin_footer(); ?>
