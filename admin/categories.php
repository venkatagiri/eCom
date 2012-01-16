<?php 
  require_once("../_/init.php");
  check_login();
?>
<?php get_admin_header('Categories'); ?>

<h1>Categories</h1>

<script>
window.onload = function() {
  var nodes = document.querySelectorAll('.node > .header');
  for(var i=0, len=nodes.length; i < len; ++i) {
    nodes[i].addEventListener('click', function() {
      this.parentNode.classList.toggle('opened');
      this.parentNode.classList.toggle('closed');
    });
  }
};
</script>

<ul id="root-node" class="list">
  <li class="node opened">
    <span class="header">Root Category</span>
    <ul class="list">
      <li class="node opened">
        <span class="header">Electronics</span>
        <ul class="list">
          <li class="node leaf">
            <span class="header">Cell Phones</span>
          </li>
          <li class="node closed">
            <span class="header">Cameras</span>
            <ul class="list">
              <li class="node leaf">Accessories</li>
              <li class="node leaf">Digital Cameras</li>
            </ul>
          </li>
          <li class="node opened">
            <span class="header">Computers</span>
            <ul class="list">
              <li class="node leaf">Build Your Own</li>
              <li class="node leaf">Laptops</li>
            </ul>
          </li>
        </ul>
      </li>
      <li class="node opened">
        <span class="header">Electronics</span>
        <ul class="list">
          <li class="node leaf">
            <span class="header">Cell Phones</span>
          </li>
          <li class="node opened">
            <span class="header">Cameras</span>
            <ul class="list">
              <li class="node leaf">Accessories</li>
              <li class="node leaf">Digital Cameras</li>
            </ul>
          </li>
          <li class="node closed">
            <span class="header">Computers</span>
            <ul class="list">
              <li class="node leaf">Build Your Own</li>
              <li class="node leaf">Laptops</li>
            </ul>
          </li>
        </ul>
      </li>
    </ul>
  </li>
</ul>

<?php get_admin_footer(); ?>
