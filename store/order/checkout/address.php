<?php 
  require_once("../../../core/init.php");

  if(!$session->get('order_id')) redirect_to('/'); // Invalid Request

  $order = Order::find_by_id($session->get('order_id'));

  if(!$order) redirect_to('/'); // Invalid Request! LOG HERE

  if(isset($_POST['continue'])) {
    $customer = Customer::make($_POST['customer']);

    if($customer->save()) {
      $order->set_customer($customer);
      if($order->save()) {
        redirect_to("summary");
      } else {
        $message = "Failed! Please try again after sometime!";
      }
    } else {
      $message = "Failed! Please try again after sometime!";
    }
  }

  $customer = $session->get_customer();
?>
<?php get_store_meta('Address | Checkout | Shopping Cart'); ?>

<body>
<header><div class="wrapper">
  <span class="right" style="padding:15px 30px 0 0;">Hi, <?php echo $customer->email; ?></span>
  <h1><?php echo STORE_NAME; ?></h1>
</div></header>

<div class="content wrapper shopping-cart-page">

<?php if($message != "") { ?>
  <p class="message"><?php echo $message; ?></p>
<?php } ?>

<aside>
  <div class="box">
    <h6 class="header">Order Summary</h6>
    <div class="container" style="padding:10px">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" >
      <tbody>
        <tr>
          <td width="50%" valign="top" align="left" class="stronge">Items</td>
          <td valign="top" align="left">: <?php echo $order->no_of_products; ?></td>
        </tr>
        <tr>
          <td width="50%" valign="top" align="left" class="stronge">Grand Total</td>
          <td valign="top" align="left">: Rs. <?php echo $order->total_amount; ?></td>
      </tbody>
    </table>
    </div>
  </div>
</aside>

<section role="main" id="main">
<h1>2. Shipping Address</h1>

<form method="post" name="address_form" class="form">
  <input type="hidden" name="customer[id]" value="<?php echo $customer->id; ?>" />
  <input type="hidden" name="customer[email]" value="<?php echo $customer->email; ?>" />
  <input type="hidden" name="customer[password]" value="<?php echo $customer->password; ?>" />
  <input type="hidden" name="customer[status]" value="1" />

  <div class="entry">
    <label for="customer[first_name]">First Name</label>
    <input type="text" name="customer[first_name]" value="<?php echo $customer->first_name; ?>" />
  </div>
  <div class="entry">
    <label for="customer[last_name]">Last Name</label>
    <input type="text" name="customer[last_name]" value="<?php echo $customer->last_name; ?>" />
  </div>
  <div class="entry">
    <label for="customer[address_1]">Address</label>
    <input type="text" name="customer[address_1]" value="<?php echo $customer->address_1; ?>" />
  </div>
  <div class="entry">
    <label for="customer[address_2]"></label>
    <input type="text" name="customer[address_2]" value="<?php echo $customer->address_2; ?>" />
  </div>
  <div class="entry">
    <label for="customer[city]">City</label>
    <input type="text" name="customer[city]" value="<?php echo $customer->city; ?>" />
  </div>
  <div class="entry">
    <label for="customer[pincode]">Pincode</label>
    <input type="text" name="customer[pincode]" value="<?php echo $customer->pincode; ?>" />
  </div>
  <div class="entry">
    <label for="customer[state]">State</label>
    <input type="text" name="customer[state]" value="<?php echo $customer->state; ?>" />
  </div>
  <div class="entry">
    <label for="customer[country]">Country</label>
    <input type="text" name="customer[country]" value="India" readonly="readonly"/>
  </div>
  <div class="entry">
    <label for="customer[telephone]">Mobile</label>
    <input type="text" name="customer[telephone]" value="<?php echo $customer->telephone; ?>" />
  </div>

  <div clas="entry">
    <label for="submit"> </label>
    <input type="image" name="continue" value="Continue" src="/images/continue.png" />
  </div>
</form>

</section>

<?php get_store_footer(); ?>