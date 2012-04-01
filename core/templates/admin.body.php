<body>

<header><div class="wrapper">
  <div class="account_controls right" style="margin: 15px 5px 0 0;">
    <a href="/">Store Front</a>
    <span style="margin:0 5px;">|</span>
    <a href="/admin/logout">Logout</a>
  </div>
  <h1><a href="/admin" title="Home">
    eCom<span> - admin panel </span>
  </a></h1>
</div></header>

<?php include_once('admin.navigation.php'); ?>

<div class="content wrapper">

<?php if($message != "") { ?>
  <p class="message"><?php echo $message; ?></p>
<?php } ?>