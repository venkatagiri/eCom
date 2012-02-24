<?php 
	require_once("../core/init.php");
  check_login();
?>
<?php get_admin_header('Dashboard'); ?>

<h1>Dashboard</h1>

<p>
  This page will contain stats about the list of products sold last week, 
  list of orders set, pending orders, graphs, list of top customers, search queries, etc.
</p>

<?php get_admin_footer(); ?>
