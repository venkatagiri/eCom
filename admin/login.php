<?php
	require_once('../core/init.php');
	if($session->is_logged_in() && $session->is_admin()) redirect_to('.');
  if($session->is_logged_in() && !$session->is_admin()) $message = "You are not authorised to view this page!";
  
	if(isset($_POST['submit'])) {
		$username = trim($_POST['username']);
		$password = trim($_POST['password']);

		if($username == "admin" && $password == "z") {
			$session->login("admin");
			log_admin(ECOM_INFO, "Login", "{$username} logged in.");
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
<?php get_admin_meta('Login'); ?>

<body class="login-page">
<header class="wrapper">
  <h1>eCom<span> - admin panel </span></h1>
</header>
<div class="content wrapper">

<?php if($message != "") { ?>
  <p class="message"><?php echo $message; ?></p>
<?php } ?>

<h1>Login</h1>

<form method="post" name="login_form" class="form">
  <div class="entry">
    <label for="username">Username</label>
    <input type="text" name="username" size="25" value="<?php echo htmlentities($username); ?>"/>
  </div>
  
  <div class="entry">
    <label for="password">Password</label>
    <input type="password" name="password" size="25" value="<?php echo htmlentities($password); ?>"/>
  </div>
  
  <div class="entry">
    <label for="submit"> </label>
    <input type="submit" name="submit" value="Log In" />
  </div>
</form>

<script>
  document.login_form.username.focus();
</script>

</div>
</body>
</html>