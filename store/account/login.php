<?php
	require_once('../../core/init.php');
	if($session->is_logged_in()) { redirect_to('/'); }
	if(isset($_POST['submit'])) {
    $POST = $_POST;
    sanitize($POST, array('email', 'password'));

		$email = trim($POST['email']);
		$password = trim($POST['password']);

    $customer = Customer::find_by_email($email);

		if($customer && $customer->password == $password) { // TODO: Hash before comparing
      $session->login($customer->email);
      log_store(ECOM_INFO, "Login", "{$customer->email} logged in.");
      redirect_to('/');
		} else {
      $message = "Email/Password combination incorrect";
		}
	} else {
		$email = "";
		$password = "";
	}
?>
<?php get_store_header('Login | Account'); ?>

<section role="main" id="main" class="only-section">

<?php if($message != "") { ?>
  <p class="message"><?php echo $message; ?></p>
<?php } ?>

<h1>Login</h1>

<form method="post" name="login_form" class="form">
  <div class="entry">
    <label for="email">Email Address</label>
    <input type="text" name="email" size="25" value="<?php echo htmlentities($email); ?>"/>
  </div>
  
  <div class="entry">
    <label for="password">Password</label>
    <input type="password" name="password" size="25" value="<?php echo htmlentities($password); ?>"/>
    <a href="/account/forgot_password">Forgot Password?</a>
  </div>
  
  <div class="entry">
    <label for="submit"> </label>
    <input type="submit" name="submit" value="Log In" />
  </div>
</form>

<script>
  document.login_form.email.focus();
</script>

</section>

<?php get_store_footer(); ?>