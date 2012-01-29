<?php
  $main_categories = Category::root_category()->children();
  function _key($str) {
    return str_replace(' ', '-', trim(strtolower($str)));
  }
?>
<nav>
  <ul class="wrapper">
  <?php foreach($main_categories as $main_category): ?>
    <li class="category">
      <a href="/categories/<?php echo _key($main_category->name);?>"><?php echo $main_category->name; ?></a>
      <table class="sub_nav"><tr><td class="col">
        <h6 class="header">Categories</h6>
        <?php foreach($main_category->children() as $sub_category): ?>
        <a href="/categories/<?php echo _key($sub_category->name);?>"><?php echo $sub_category->name; ?></a>
        <?php endforeach; ?>
      </td><td class="col">
        <h6 class="header">Brands</h6>
        <?php foreach($main_category->brands() as $brand): ?>
        <a href="/categories/<?php echo _key($main_category->name);?>?brand_id=<?php echo $brand->id; ?>"><?php echo $brand->name; ?></a>
        <?php endforeach; ?>
      </td></tr></table>
    </li>
  <?php endforeach; ?>
  </ul>
</nav>
