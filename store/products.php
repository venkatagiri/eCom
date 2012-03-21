<?php 
  require_once("../core/init.php"); 
  parse_str($_SERVER['QUERY_STRING'], $QS);
  sanitize($QS, array('pid'));

  if(!isset($QS['pid'])) {
    return show_404(true);
  }
  
  $product = Product::find_by_id($QS['pid']);
  
  if(!$product) {
    return show_404(true);
  }
?>
<?php get_store_header('Products'); ?>

<aside>
  <ul class="filters">
    <li class="box filter">
      <h6 class="header">Similar Products</h6>
      <ul class="list">
        <li><a href="#">Dell</a></li>
        <li><a href="#">HP</a></li>
        <li><a href="#" class="last">Apple</a></li>
      </ul>
    </li>
  </ul>
</aside>

<section role="main">
  <div class="product-image">
    <img src="/assets/product/<?php echo $product->image; ?>"/>
  </div>
  <div class="product-intro">
    <h1 class="product-name"><?php echo $product->name; ?></h1>
    <ul class="product-features">
      <?php foreach($product->features() as $feature) { ?>
        <li><?php echo $feature->value; ?></li>
      <?php } ?>
    </ul>
    <input type="image" src="/images/order-now.jpg" id="order-now" />
    <div class="product-price">
      Price:<strong>Rs. <?php echo $product->price; ?></strong>
    </div>
  </div>
  <div class="product-details clear">
    <h2 class="sub-heading">Details of <?php echo $product->name; ?></h2>
    <p class="product-description"><?php echo nl2br($product->description); ?></p>
  </div>
</section>

<?php get_store_footer(); ?>