<?php
  $main_categories = Category::root_category()->children();
?>
<nav>
  <ul class="wrapper">
  <?php foreach($main_categories as $main_category): 
        $main_path = "/".get_key($main_category->name)."/".$main_category->id;
  ?>
    <li class="category">
      <a href="<?php echo $main_path; ?>"><?php echo $main_category->name; ?></a>
      <table class="sub_nav"><tr><td class="col">
        <h6 class="header">Categories</h6>
        <?php foreach($main_category->visible_children() as $sub_category): 
            $path = "/".get_key($main_category->name)."/".get_key($sub_category->name)."/".$sub_category->id;
        ?>
        <a href="<?php echo $path; ?>"><?php echo $sub_category->name; ?></a>
        <?php endforeach; ?>
      </td><td class="col">
        <h6 class="header">Brands</h6>
        <?php foreach($main_category->brands() as $brand): 
              $path = $main_path."?bid={$brand->id}";
        ?>
        <a href="<?php echo $path; ?>"><?php echo $brand->name; ?></a>
        <?php endforeach; ?>
      </td></tr></table>
    </li>
  <?php endforeach; ?>
  </ul>
</nav>