<?php 
  require_once("../_/init.php");
  parse_str($_SERVER['QUERY_STRING'], $QS);
  sanitize($QS, array('cid', 'bid', 'page'));
  $page = isset($QS['page']) ? $QS['page'] : 1;
  unset($QS['page']); // Remove it from the query_string
  
  if(!isset($QS['cid'])) {
    echo "404";
    return;
  }
  
  $category = Category::find_by_id($QS['cid']);
  if(!$category) {
    echo "404";
    return;
  }
  
  $sql = "(category_id = {$category->id} OR category_id IN ( SELECT id FROM categories WHERE parent_id={$category->id} ))";
  if(isset($QS['bid'])) {
    $brand = Brand::find_by_id($QS['bid']);
    $sql .= " AND brand_id = {$brand->id} ";
  }
  
  list($pg, $products) = Product::find_with_pagination($sql, $page);
  
  if(!$products) {
    $error = "There are no Products to list in this cateogory.";
  }
  
  if($category->parent_id != 1) {
    $main_category = $category->parent();
    $heading = $main_category->name . " / " . $category->name;
  } else {
    $main_category = $category;
    $heading = $category->name;
  }
  
  if(isset($brand)) $heading .= " / " . $brand->name;
?>
<?php get_header($category->name.' | Categories'); ?>

<aside>
  <ul class="filters">
    <li class="box filter">
      <h6 class="header">Categories</h6>
      <ul class="list">
      <?php foreach(Category::main_categories() as $c): 
            $path = "/".get_key($c->name)."/".$c->id;
            if($c->id == $main_category->id) $is_active = 'class="active"';
            else $is_active = "";
      ?>
        <li><a href="<?php echo $path; ?>" <?php echo $is_active; ?> ><?php echo $c->name; ?></a></li>
      <?php endforeach; ?>
      </ul>
    </li>
    <li class="box filter">
      <h6 class="header">Sub-Categories</h6>
      <ul class="list">
      <?php foreach($main_category->children() as $sub_category): 
            $path = "/".get_key($main_category->name)."/".get_key($sub_category->name)."/".$sub_category->id;
            if(isset($brand)) $path .= "?bid={$brand->id}";
            if($sub_category->id == $category->id) $is_active = 'class="active"';
            else $is_active = "";
      ?>
        <li><a href="<?php echo $path; ?>" <?php echo $is_active; ?> ><?php echo $sub_category->name; ?></a></li>
      <?php endforeach; ?>
      </ul>
    </li>
    <li class="box filter">
      <h6 class="header">Brands</h6>
      <ul class="list">
      <?php foreach($main_category->brands() as $b): 
            $path = "/".get_key($main_category->name);
            if($main_category !== $category) $path .= "/".get_key($category->name);
            $path .= "/".$category->id."?bid={$b->id}";
            if(isset($brand) && $b->id == $brand->id) $is_active = 'class="active"';
            else $is_active = "";
      ?>
        <li><a href="<?php echo $path; ?>" <?php echo $is_active; ?> ><?php echo $b->name; ?></a></li>
      <?php endforeach; ?>
      </ul>
    </li>
  </ul>
</aside>

<section role="main">
  <h1><?php echo $heading; ?></h1>
  
<?php if(isset($error)) { ?>

  <h2><?php echo $error; ?></h2>

<?php } else {?>

  <ul class="products">
  <?php foreach($products as $product): 
        $path = "/products/".get_key($product->name)."/".$product->id;
  ?>
    <li><a href="<?php echo $path; ?>" class="product">
      <div class="product-image">
        <img src="/assets/p/<?php echo $product->image; ?>"
          alt="<?php echo get_key($product->name); ?>" />
      </div>
      <div class="product-name"><?php echo $product->name; ?></div>
      <div class="product-price">Rs. <?php echo $product->price; ?></div>
    </a></li>
  <?php endforeach; ?>
  </ul>
  
  <div class="page_controls">
  <?php
      if($pg->total_pages() > 1) {
        $tmp_QS = $QS;
        if($pg->previous_exists()) {
          $tmp_QS['page'] = $pg->previous_page();
          $query_string = http_build_query($tmp_QS);
          echo "<a href='?{$query_string}' >&laquo; Previous</a>&nbsp;&nbsp;";
        }
        for($i=1; $i<=$pg->total_pages(); $i++) {
          $tmp_QS['page'] = $i;
          $query_string = http_build_query($tmp_QS);
          if($i == $page) {
            echo "&nbsp;&nbsp;<strong>{$i}</strong>&nbsp;&nbsp;";
          } else {
            echo "&nbsp;&nbsp;<a href='?{$query_string}'>{$i}</a>&nbsp;&nbsp;";
          }
        }
        if($pg->next_exists()) {
          $tmp_QS['page'] = $pg->next_page();
          $query_string = http_build_query($tmp_QS);
          echo "&nbsp;&nbsp;<a href='?{$query_string}' >Next &raquo;</a>";
        }      
      }
  ?>
  </div>
  
<?php } //endif ?>

</section>

<?php get_footer(); ?>
