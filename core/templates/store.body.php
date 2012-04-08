<?php
  global $session;
  $customer = false;
  if($session->is_logged_in()) $customer = $session->get_customer();
?>
<body id="store">

<header><div class="wrapper">
  <div class="account_controls right" style="margin: 15px 5px 0 0;">
  <?php if(!$customer) { ?>
    <a href="/account/login">Login</a>
    <span style="margin:0 5px;">|</span>
    <a href="/account/register">Register</a>
  <?php } else { ?>
    <a href="/account/"><?=$customer->email?></a>
    <span style="margin:0 5px;">|</span>
    <a href="/account/logout">Logout</a>
  <?php } ?>
  </div>
  <h1><a href="/" title="Home">
    <?php echo STORE_NAME; ?>
  </a></h1>
</div></header>

<?php include_once('store.navigation.php'); ?>

<div class="content wrapper <?php echo $g_class_name; ?>">