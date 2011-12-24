<?php require_once("_/init.php"); ?>
<?php get_header('Search'); ?>

  <h1>Search Results - #query</h1>
  <aside>
    <ul class="filters">
      <li class="box filter">
        <h6 class="header">Brands</h6>
        <ul class="list">
          <li><a href="#">Dell</a></li>
          <li><a href="#">HP</a></li>
          <li><a href="#" class="last">Apple</a></li>
        </ul>
      </li>
      <li class="box filter">
        <h6 class="header">Categories</h6>
        <ul class="list">
          <li><a href="#">Comps</a></li>
          <li><a href="#">Mobiles</a></li>
          <li><a href="#" class="last">Electronics</a></li>
        </ul>
      </li>
    </ul>
  </aside>
  <section role="main">
    <ul class="products">
      <li><a href="#buy" class="product">
        <img src="images/product-image.jpg" 
          alt="Product Name" />
        <div class="product-name">Samsung Galaxy Ace(S5830)</div>
        <div class="product-price">Rs. 13995</div>
      </a></li>
      <li><a href="#buy" class="product">
        <img src="images/product-image.jpg" 
          alt="Product Name" />
        <div class="product-name">Samsung Galaxy S</div>
        <div class="product-price">Rs. 30000</div>
      </a></li>
      <li><a href="#buy" class="product">
        <img src="images/product-image.jpg" 
          alt="Product Name" />
        <div class="product-name">Samsung Galaxy SII</div>
        <div class="product-price">Rs. 300</div>
      </a></li>
      <li><a href="#buy" class="product">
        <img src="images/product-image.jpg" 
          alt="Product Name" />
        <div class="product-name">Samsung Galaxy Nexus</div>
        <div class="product-price">Rs. 300</div>
      </a></li>
      <li><a href="#buy" class="product">
        <img src="images/product-image.jpg" 
          alt="Product Name" />
        <div class="product-name">Product name</div>
        <div class="product-price">Rs. 300</div>
      </a></li>
      <li><a href="#buy" class="product">
        <img src="images/product-image.jpg" 
          alt="Product Name" />
        <div class="product-name">Product name</div>
        <div class="product-price">Rs. 300</div>
      </a></li>
    </ul>
  </section>
<?php get_footer(); ?>
