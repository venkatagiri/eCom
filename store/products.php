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
<?php get_store_header('Products', $product->short_description); ?>

<aside>
  <ul>
    <li class="box">
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
    <input type="image" src="/images/buy-now.png" id="buy-now" onclick="$('#cart').show();" />
    <div class="product-price">
      Price:<strong>Rs. <?php echo $product->price; ?></strong>
    </div>
  </div>
  <div class="product-details clear">
    <h2 class="sub-heading">Details of <?php echo $product->name; ?></h2>
    <p class="product-description"><?php echo nl2br($product->description); ?></p>
    <h2 class="sub-heading">Specifications</h2>
    <div class="specifications">
    <?php 
      foreach(Attribute::all_groups() as $group) { //TODO: Instead of all groups, get the ones for this category.
        $attrs = $product->attributes($group->id);
        if(count($attrs) == 0) continue;
    ?>
      <table>
        <tr><td class="header" colspan="2"><h3><?php echo $group->name; ?></h3></td></tr>
      <?php foreach($attrs as $attr) { ?>
        <tr>
          <th><?php echo $attr->name; ?></th>
          <td><?php echo $attr->value; ?></td>
        </tr>
      <?php } ?>
      </table>
    <?php } ?>
    </div>
  </div>
</section>

<div id="cart">
  <div class="dimmer" onclick="$('#cart').hide();"></div>

  <form action="/order/checkout/index" method="post" name="order_form">
    <input type="hidden" name="order[product][0][product_id]" value="<?php echo $product->id; ?>" />
    <input type="hidden" name="order[product][0][name]" value="<?php echo $product->name; ?>" />
    <input type="hidden" name="order[product][0][price]" value="<?php echo $product->price; ?>" />
    <input type="hidden" name="order[product][0][quantity]" value="1" id="product-quantity" />
  </form>

  <div class="popup">
    <div class="header">
      <img src="/images/icon-cart.png" class="right"/>
      <h1>Order Details</h1>
    </div>
    <table class="cart-description table">
      <tr class="header">
        <th>Product</th>
        <th style="width:15%;text-align:center;">Unit Price</th>
        <th style="width:15%;text-align:center;">Quantity</th>
        <th style="width:15%;text-align:center;">Total</th>
      </tr>
      <tr>
        <td><?php echo $product->name; ?></td>
        <td style="text-align:center;">Rs. <span id="product-amount"><?php echo $product->price; ?></span></td>
        <td style="text-align:center;">
          <select name="quantity" id="order-quantity">
            <option value="1" selected="selected">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
        </td>
        <td style="text-align:center;">Rs. <span id="order-amount"><?php echo $product->price; ?></span></td>
      </tr>
    </table>
    <div class="footer">
      <p style="border-bottom: 1px solid #EEE;margin: 20px 0;font-size:150%;">
        Grand Total <span class="right">Rs. <span style="color:#FF7200;" id="grand-total"><?php echo $product->price; ?></span></span>
      </p>
      <input type="image" src="/images/place-your-order.jpg" style="float:right" onclick="document.order_form.submit();" />
    </div>
  </div>
</div>

<script>
$('#order-quantity').change(function() {
  $('#order-amount').text($('#product-amount').text()*$('#order-quantity').val());
  $('#grand-total').text($('#product-amount').text()*$('#order-quantity').val());
  $('#product-quantity').attr('value', $('#order-quantity').val());
});
</script>

<?php get_store_footer(); ?>