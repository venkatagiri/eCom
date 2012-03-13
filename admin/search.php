<?php 
  require_once("../core/init.php");
  parse_str($_SERVER['QUERY_STRING'], $QS);
  sanitize($QS, array('q', 'cid', 'bid', 'page'));
  $page = isset($QS['page']) ? $QS['page'] : 1;
  unset($QS['page']); // Remove it from the query_string
  
  if(isset($QS['q']) && isset($QS['cid'])) {
    $search_type = CATEGORY_SEARCH;
    $query = $QS['q'];
    $category = Category::find_by_id($QS['cid']);
    
    $sql = " LOWER(name) LIKE '%{$query}%' ";
    $sql .= " AND (category_id = {$category->id} OR category_id in (SELECT id FROM categories WHERE parent_id = {$category->id}))";
    
    if(isset($QS['bid'])) {
      $brand = Brand::find_by_id($QS['bid']);
      $sql .= " AND brand_id = {$brand->id} ";
    }

    if($category->parent_id != 1) {
      $main_category = $category->parent();
    } else {
      $main_category = $category;
    }
    
    list($pg, $products) = Product::find_with_pagination($sql, $page);
    
    if(empty($products)) {
      $error = "No Products match your search. Please try again!";
    }
  } else if(isset($QS['q'])) {
    $search_type = GENERIC_SEARCH;
    $query = $QS['q'];
    
    $sql = "LOWER(name) LIKE '%{$query}%'";
    list($pg, $products) = Product::find_with_pagination($sql, $page);
    
    if(empty($products)) {
      $error = "No Products match your search. Please try again!";
    }
  } else {
    return show_404();
  }
?>
<?php get_admin_header('Search'); ?>

<aside>
  <?php 
    switch($search_type):
    case CATEGORY_SEARCH:
  ?>
  <ul class="filters">
    <li class="box filter">
      <h6 class="header">Categories</h6>
      <ul class="list">
      <?php 
        $tmp_QS = $QS;
        foreach(Category::main_categories() as $c) {
          $tmp_QS['cid'] = $c->id;
          unset($tmp_QS['bid']);
          $query_string = http_build_query($tmp_QS);
          if(isset($main_category) && $c->id == $main_category->id) $is_active = 'class="active"';
          else $is_active = "";
          echo "<li><a href=\"?{$query_string}\" {$is_active}>{$c->name}</a>";
          
          // If this category is currently active, show the sub-categories.
          if($c->id == $main_category->id) {
            echo "<ul class=\"sub_list\">";
            foreach($main_category->visible_children() as $sub_category) {
              $tmp_QS['cid'] = $sub_category->id;
              $query_string = http_build_query($tmp_QS);
              if(isset($category) && $sub_category->id == $category->id) $is_active = 'class="active"';
              else $is_active = "";
              echo "<li><a href=\"?{$query_string}\" {$is_active}>&raquo; {$sub_category->name}</a></li>";
            }
            echo "</ul>";
          }
          echo "</li>";
        }
      ?>
      </ul>
    </li>
    <li class="box filter">
      <h6 class="header">Brands</h6>
      <ul class="list">
      <?php
          $tmp_QS = $QS;
          foreach($main_category->brands() as $b) {
            $tmp_QS['bid'] = $b->id;
            $query_string = http_build_query($tmp_QS);
            if(isset($brand) && $b->id == $brand->id) $is_active = 'class="active"';
            else $is_active = "";
            echo "<li><a href=\"?{$query_string}\" {$is_active}>{$b->name}</a></li>";
          }
      ?>
      </ul>
    </li>
  </ul>
  <?php
    break;
    case GENERIC_SEARCH:
  ?>
  <ul class="filters">
    <li class="box filter">
      <h6 class="header">Categories</h6>
      <ul class="list">
      <?php
          $tmp_QS = $QS;
          foreach(Category::main_categories() as $c) {
            $tmp_QS['cid'] = $c->id;
            $query_string = http_build_query($tmp_QS);
            echo "<li><a href=\"?{$query_string}\">{$c->name}</a></li>";
          }
      ?>
      </ul>
    </li>
  </ul>
  <?php
    break;
    endswitch;
  ?>

</aside>

<section role="main">
<h1>Search Results - '<?php echo $query; ?>'</h1>

<?php if(isset($error)) { ?>

  <h2><?php echo $error; ?></h2>

<?php } else { ?>
  
<table class="table">
  <tr class="header">
    <th>Name</th>
    <th style="width:20%;">Brand</th>
    <th style="width:20%;">Category</th>
    <th style="width:5%;">Price</th>
    <th style="width:5%;">Qty</th>
    <th style="width:5%;">Visible</th>
    <th style="width:5%;"></th>
  </tr>
  <?php foreach($products as $product): ?>
  <tr>
    <td><?php echo $product->name; ?></td>
    <td><?php echo $product->brand()->name; ?></td>
    <td><?php echo $product->category()->name; ?></td>
    <td style="text-align:center;"><?php echo $product->price; ?></td>
    <td style="text-align:center;"><?php echo $product->quantity; ?></td>
    <td style="text-align:center;"><input type="checkbox" disabled="disabled" <?php if($product->visible == '1') echo " checked='checked' "; ?>/></td>
    <td><a href="/admin/products/show?id=<?php echo $product->id; ?>">Edit</a></td>
  </tr>
  <?php endforeach; ?>
</table>

<div style="text-align:center; " class="page_controls">
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

<?php get_admin_footer(); ?>
