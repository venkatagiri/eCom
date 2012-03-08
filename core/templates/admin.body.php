<body>

<header><div class="wrapper">
  <form method="GET" action="/admin/search">
    <input type="text" name="q" id="search_box"
      value="" size="25" placeholder="Search and you will find it..." />
  </form>
  <h1><a href="/admin" title="Home">
    eCom<span> - admin panel </span>
  </a></h1>
</div></header>

<?php include_once('admin.navigation.php'); ?>

<div class="content wrapper">

<?php if($message != "") { ?>
  <p class="message"><?php echo $message; ?></p>
<?php } ?>
