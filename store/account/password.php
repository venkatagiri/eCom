<?php 
  require_once("../../core/init.php");
  check_customer_login();
  $customer = $session->get_customer();

  if(isset($_POST['save'])) {
    $POST = $_POST;
    sanitize($POST, array('password', 'new_password', 'confirm_password'));

    if($POST['password'] != $customer->password) { // TODO: Hashing
      $message = "Invalid Password!";
    } else if($POST['new_password'] != $POST['confirm_password']) {
      $message = "Passwords don't match!";
    } else {
      $customer->password = $POST['new_password']; // TODO: Hashing
      if($customer->save()) {
        $session->message("Password was updated successfully!");
        redirect_to('change_password');
      } else {
        $message = "Updation failed!";
      }
    }
  }

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

  <h1>Change Password</h1>
  <form method="post" name="address_form" class="form">
    <div class="entry">
      <label for="email">Email Address</label>
      <input type="text" name="email" value="<?=$customer->email?>" readonly="readonly" />
    </div>
    <div class="entry">
      <label for="password">Old Password</label>
      <input type="password" name="password" value="" />
    </div>
    <div class="entry">
      <label for="new_password">New Password</label>
      <input type="password" name="new_password" value="" />
    </div>
    <div class="entry">
      <label for="confirm_password">Confirm Password</label>
      <input type="password" name="confirm_password" value="" />
    </div>
    <div clas="entry">
      <label for="submit"> </label>
      <input type="submit" name="save" value="Save" />
    </div>
  </form>

</section>

<?php get_store_footer(); ?>