<?php 
  require_once("../../core/init.php");
  check_customer_login();

  if(isset($_POST['save'])) {
    $customer = Customer::make($_POST['customer']);

    if($customer->save()) {
      $session->message("Address updated successfully!");
      redirect_to('address');
    } else {
      $message = "Updation failed!";
    }
  }
  $customer = $session->get_customer();

?>
<?php get_store_header('Account'); ?>

<aside>
  <ul>
    <li class="box">
      <h6 class="header">Controls</h6>
      <ul class="list">
        <li><a href="orders">My Orders</a></li>
        <li><a href="address">Shipping Address</a></li>
        <li><a href="password">Change Password</a></li>
      </ul>
    </li>
  </ul>
</aside>

<section role="main" id="main">

<h1>Shipping Address</h1>

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
    <input type="submit" name="save" value="Save" />
  </div>
</form>

</section>

<?php get_store_footer(); ?>