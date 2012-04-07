<?php
  require_once("../core/init.php");
  parse_str($_SERVER['QUERY_STRING'], $QS);
  sanitize($QS, array('key', 'brand', 'price', 'page'));
  $page = isset($QS['page']) ? $QS['page'] : 1;
  unset($QS['page']); // Remove it from the query_string
  
  if(!isset($QS['key']) || $QS['key'] == "" || count(explode('/', $QS['key'])) > 2) {
    return show_404(true);
  }

  $key = end(explode('/', $QS['key']));
  unset($QS['key']); // Removing category key from the query string.
  $category = Category::find_by_key($key);
  if(!$category) {
    return show_404(true);
  }
  
  if(isset($QS['brand']) || isset($QS['price'])) {
    $filters = true;

    $sql = "(category_id = {$category->id} OR category_id IN ( SELECT id FROM categories WHERE parent_id={$category->id} ))";

    // ~ Search Filters
    // Brand
    if(isset($QS['brand'])) {
      // TODO: Throw 404 for invalid brand id.
      $brand = $QS['brand'];
      $sql .= " AND brand_id = {$brand} ";
    }
    // Price
    if(isset($QS['price'])) {
      // TODO: Throw 404 for invalid price.
      $price = $QS['price'];
      $start_price = $PRICE_RANGE[$price]['start_price'];
      $end_price = $PRICE_RANGE[$price]['end_price'];
      $sql .= " AND (price > {$start_price} AND price <= {$end_price}) ";
    }

    list($pg, $products) = Product::find_with_pagination($sql, $page);

    if(!$products) {    
      $error = "No products match your filters!";
    }
  } else {
    $filters = false;
    $new_arrivals = Product::new_arrivals($category->id); // TODO: Change to $category->new_arrivals();
    // TODO: $featured_products = $category->featured_products();
    // TODO: $best_selling = $category->best_selling();
  }

  if($category->is_sub_category()) {
    $main_category = $category->parent();
    $heading = $main_category->name . " / " . $category->name;
    $category_path = $main_category->key."/".$category->key;
  } else {
    $main_category = $category;
    $heading = $category->name;
    $category_path = $category->key;
  }
  
?>

<?php get_store_header($category->name); ?>

<div class="breadcrumbs">
  <a href="/">Home</a>
  <?php if($main_category == $category) { ?>
   » <?=$category->name?>
  <?php } else { ?>
   » <a href="/<?=$main_category->key?>"><?=$main_category->name?></a>
   » <?=$category->name?>
  <?php } ?>
</div>

<h1><?php echo $heading; ?></h1>

<aside>
  <div class="box">
    <ul>
      <li>
        <h6 class="header">» Brands</h6>
        <ul class="list">
        <?php
          $tmp_QS = $QS;
          unset($tmp_QS['brand']);
          if(isset($brand)) {
            $b = Brand::find_by_id($brand);
            $query_string = http_build_query($tmp_QS);
            echo "<li class='active'>{$b->name}<a href='?{$query_string}' class='clear-filter'></a></li>";
          } else {
            foreach($main_category->brands() as $b) {
              $tmp_QS['brand'] = $b->id;
              $query_string = http_build_query($tmp_QS);
              if(isset($brand) && $b->id == $brand) $is_active = 'class="active"';
              else $is_active = "";
              
              echo "<li><a href='?{$query_string}' {$is_active}>{$b->name}</a></li>";
            }
          }
        ?>
        </ul>
      </li>
      <li>
        <h6 class="header">» Price</h6>
        <ul class="list">
        <?php 
          $tmp_QS = $QS;
          unset($tmp_QS['price']);
          if(isset($price)) {
            $query_string = http_build_query($tmp_QS);
            $value = $PRICE_RANGE[$price];
            echo "<li class='active'>{$value['text']}<a href='?{$query_string}' class='clear-filter'></a></li>";
          } else {
            foreach($PRICE_RANGE as $key => $value) {
              $tmp_QS['price'] = $key;
              $query_string = http_build_query($tmp_QS);
              if(isset($price) && $key == $price) $is_active = 'class="active"';
              else $is_active = "";
              
              echo "<li><a href='?{$query_string}' {$is_active}>{$value['text']}</a></li>";
            }
          }
        ?>
        </ul>
      </li>
    </ul>
  </div>
</aside>

<section role="main">

<?php if($filters) { ?>

  <?php if(isset($error)) { ?>
    <h2><?php echo $error; ?></h2>
  <?php } else { ?>

  <ul class="products">
  <?php foreach($products as $product): ?>
    <li><a href="/<?=$product->key?>/p<?=$product->id?>" class="product">
      <div class="image">
        <img src="/assets/product/<?php echo $product->image; ?>"
          alt="<?php echo $product->name; ?>" />
      </div>
      <div class="name"><?php echo $product->name; ?></div>
      <div class="price">Rs. <?php echo $product->price; ?></div>
    </a></li>
  <?php endforeach; ?>
  </ul>

  <div class="page_controls">
  <?php
      if($pg->total_pages() > 1) {
        $tmp_QS = $QS;
        unset($tmp_QS['key']); // Removing category key from the query string.
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
  
  <?php } // end if(error) ?>

<?php } else { ?>

  <h2 class="sub-heading">» New Arrivals</h2>
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

<?php } ?>

</section>

<?php get_store_footer(); ?>