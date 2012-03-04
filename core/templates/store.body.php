<body>
<div id="extras"></div>
<header><div class="wrapper">
  <form method="GET" action="/search">
    <input type="text" name="q" id="search_box"
      value="" size="25" placeholder="Search and you will find it..." />
  </form>
  <h1><a href="/" title="Home">
    <?php echo STORE_NAME; ?>
  </a></h1>
</div></header>

<?php include_once('store.navigation.php'); ?>

<div class="content wrapper <?php echo strtolower(array_pop(explode('|', $g_title))).'-page'; ?>">
