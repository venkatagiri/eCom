<?php 
  require_once("_/init.php");
  //print_r($_SERVER);
  //return;
  
  if(!isset($_GET['cid'])) {
    echo "404";
    return;
  }
  
  $category = Category::find_by_id(__($_GET['cid']));
  if(!$category) {
    echo "404";
    return;
  }
  
  $sql = "(category_id = {$category->id} OR category_id IN ( SELECT id FROM categories WHERE parent_id={$category->id} ))";
  if(isset($_GET['bid'])) {
    $brand = Brand::find_by_id(__($_GET['bid']));
    $sql .= " AND brand_id = {$brand->id} ";
  }
  $products = Product::find_where($sql);
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
            $path = "/categories/".get_key($c->name)."/".$c->id;
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
            $path = "/categories/".get_key($main_category->name)."/".get_key($sub_category->name)."/".$sub_category->id;
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
            $path = "/categories" . $_SERVER['PATH_INFO'] . "?bid={$b->id}";
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
  
<?php } //endif ?>

</section>

<?php get_footer(); ?>
