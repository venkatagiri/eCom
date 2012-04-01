<?php 
  require_once("../../core/init.php");
  if($session->is_logged_in()) redirect_to('.');

  if(isset($_POST['create'])) {
    $customer = new Customer();
    $customer->email = $_POST['customer']['email'];
    $customer->password = $_POST['customer']['password'];
    $customer->first_name = $_POST['customer']['first_name'];
    $customer->last_name = $_POST['customer']['last_name'];
    $confirm_password = $_POST['confirm_password'];

    if(Customer::email_exists($customer->email)) {
      $message = "Email is already registered!";
    } else if($customer->password != $confirm_password) {
      $message = "Passwords don't match!";
    } else if(!$customer->create()) {
      $message = "Creation failed!";
    } else {  
      $session->login($customer->email);
      $success = true;
    }
  } else {
    $customer = new Customer();
  }
?>
<?php get_store_header('Register | Account'); ?>

<section role="main" id="main" class="only-section">

<?php if($message != "") { ?>
  <p class="message"><?php echo $message; ?></p>
<?php } ?>

<?php if(isset($success)) { ?>
  <h1>Account Registered Successfully!</h1>
  <p class="success">Now, get <a href='/'>back to the store</a> and start shopping!</p>
<?php } else { ?>

<h1>Registering a new Account</h1>

<form method="post" name="customer_form" class="form">
  <div class="entry">
    <label for="customer[email]">Email Address</label>
    <input type="text" name="customer[email]" value="<?php echo $customer->email; ?>" />
  </div>
  <div class="entry">
    <label for="customer[password]">Password</label>
    <input type="password" name="customer[password]" value="<?php echo $customer->password; ?>" />
  </div>
  <div class="entry">
    <label for="confirm_password">Confirm Password</label>
    <input type="password" name="confirm_password" value="<?php echo @$confirm_password; ?>" />
  </div>
  <div class="entry">
    <label for="customer[first_name]">First Name</label>
    <input type="text" name="customer[first_name]" value="<?php echo $customer->first_name; ?>" />
  </div>
  <div class="entry">
    <label for="customer[last_name]">Last Name</label>
    <input type="text" name="customer[last_name]" value="<?php echo $customer->last_name; ?>" />
  </div>

  <div clas="entry">
    <label for="submit"> </label>
    <input type="submit" name="create" value="Create" />
  </div>
</form>

<?php } ?>

</section>

<?php get_store_footer(); ?>