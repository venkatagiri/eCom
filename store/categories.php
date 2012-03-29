<?php
  require_once("../core/init.php");
  parse_str($_SERVER['QUERY_STRING'], $QS);
  sanitize($QS, array('key', 'bid', 'page'));
  $page = isset($QS['page']) ? $QS['page'] : 1;
  unset($QS['page']); // Remove it from the query_string
  
  if(!isset($QS['key']) || $QS['key'] == "" || count(explode('/', $QS['key'])) > 2) {
    return show_404(true);
  }

  $key = end(explode('/', $QS['key']));

  $category = Category::find_by_key($key);
  if(!$category) {
    return show_404(true);
  }
  
  $sql = "(category_id = {$category->id} OR category_id IN ( SELECT id FROM categories WHERE parent_id={$category->id} ))";
  if(isset($QS['bid'])) {
    $brand = Brand::find_by_id($QS['bid']);
    $sql .= " AND brand_id = {$brand->id} ";
  }
  
  if($category->parent_id != 1) {
    $main_category = $category->parent();
    $heading = $main_category->name . " / " . $category->name;
  } else {
    $main_category = $category;
    $heading = $category->name;
  }
  
  if(isset($brand)) $heading .= " / " . $brand->name;
  
  $new_arrivals = Product::new_arrivals($category->id);
?>

<?php get_store_header($category->name.' | Categories'); ?>

<h1><?php echo $heading; ?></h1>

<aside>
  <ul class="filters">
    <li class="box filter">
      <h6 class="header">Categories</h6>
      <ul class="list">
      <?php foreach(Category::main_categories() as $c): 
        $path = "/{$c->key}";
        if($c->id == $main_category->id) $is_active = 'class="active"';
        else $is_active = "";
        echo "<li><a href=\"{$path}\" {$is_active}>{$c->name}</a>";
        
        // If this category is currently active, show the sub-categories.
        if($c->id == $main_category->id) {
          echo "<ul class=\"sub_list\">";
          foreach($main_category->visible_children() as $sub_category) {
            $path = "/{$main_category->key}/{$sub_category->key}";
            if(isset($brand)) $path .= "?bid={$brand->id}";
            if($sub_category->id == $category->id) $is_active = 'class="active"';
            else $is_active = "";
            echo "<li><a href=\"{$path}\" {$is_active}>&raquo; {$sub_category->name}</a></li>";
          }
          echo "</ul>";
        }
        echo "</li>";
      endforeach; ?>
      </ul>
    </li>
    <li class="box filter">
      <h6 class="header">Brands</h6>
      <ul class="list">
      <?php foreach($main_category->brands() as $b): 
        $path = "/{$main_category->key}";
        if($main_category !== $category) $path .= "/{$category->key}";
        $path .= "?bid={$b->id}";
        if(isset($brand) && $b->id == $brand->id) $is_active = 'class="active"';
        else $is_active = "";
        
        echo "<li><a href=\"{$path}\" {$is_active}>{$b->name}</a></li>";
      endforeach; ?>
      </ul>
    </li>
  </ul>
</aside>

<section role="main">
  
  <h2 class="sub-heading">New Arrivals</h2>
  <ul class="products">
  <?php foreach($new_arrivals as $product): ?>
    <li><a href="/<?=$product->key?>/p<?=$product->id?>" class="product">
      <div class="image">
        <img src="/assets/product/<?php echo $product->image; ?>"
          alt="<?php echo $product->key; ?>" />
      </div>
      <div class="name"><?php echo $product->name; ?></div>
      <div class="price">Rs. <?php echo $product->price; ?></div>
    </a></li>
  <?php endforeach; ?>
  </ul>

</section>

<?php get_store_footer(); ?>