<?php
	include_once('../_/init.php');
	if($session->isLoggedIn()) { redirect_to('.'); }
	if(isset($_POST['submit'])) {
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);

		if($username == "ecom" && $password == "z") {
			$session->login("ecom");
			if(isset($_GET['url'])) redirect_to($_GET['url']);
			else redirect_to('.');
		} else {
			$message = "Username/Password combination incorrect";
		}
	} else {
		$username = "";
		$password = "";
	}
?>
<?php get_admin_header('Login'); ?>

<h1>Login</h1>

<form method="post" name="login_form" class="login-form">
  <label for="username">Username</label>
  <input type="text" name="username" size="25" value="<?php echo htmlentities($username); ?>"/>
  <br />
  <label for="password">Password</label>
  <input type="password" name="password" size="25" value="<?php echo htmlentities($password); ?>"/>
  <br />
  <label for="submit"> </label>
  <input type="submit" name="submit" value="Log In" />
</form>

<script>
  document.login_form.username.focus();
</script>
<?php get_admin_footer(); ?>
