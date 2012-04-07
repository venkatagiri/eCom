<?php
  $main_categories = Category::root_category()->children();
?>
<nav>
  <ul class="wrapper">
  <?php foreach($main_categories as $main_category) { ?>
    <li class="category">
      <a href="<?php echo "/".$main_category->key; ?>"><?php echo $main_category->name; ?></a>
      <div class="sub_nav">
      <?php foreach($main_category->visible_children() as $sub_category) { ?>
        <a href="<?php echo "/".$main_category->key."/".$sub_category->key; ?>"><?php echo $sub_category->name; ?></a>
      <?php } ?>
      </div>
    </li>
  <?php } ?>
    <li class="right">
      <form method="GET" action="/search">
        <input type="text" name="q" id="search_box" value="" size="25" placeholder="Search and you will find it..." />
      </form>
    </li>
  </ul>
</nav>