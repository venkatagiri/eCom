<?php 
	require_once("../_/init.php");
  if(!$session->isLoggedIn()) { redirect_to('login.php'); }
?>
<?php get_admin_header('Admin'); ?>

<h1>Admin Page</h1>
<?php get_admin_footer(); ?>
