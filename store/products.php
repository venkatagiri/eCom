<?php 
  require_once("../core/init.php"); 
  
  if(!isset($_GET['pid'])) {
    echo "404";
    return;
  }
  
  $pid = __($_GET['pid']);
  $product = Product::find_by_id($pid);
  
  if(!$product) {
    echo "404";
    return;
  }
?>
<?php get_header('Products'); ?>

<?php if(isset($error)) { ?>

<h2><?php echo $error; ?></h2>

<?php } else { ?>

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
    <img src="/assets/p/<?php echo $product->image; ?>"/>
  </div>
  <h1 class="product-names"><?php echo $product->name; ?></h1>
  <p class="product-description"><?php echo $product->description; ?></p>
  <input type="image" src="/images/buy-now.jpg" id="buy-now"/>
  <div class="product-price">
    Price:<strong>Rs. <?php echo $product->price; ?></strong>
  </div>
</section>
  
<?php } //endif ?>

<?php get_footer(); ?>
