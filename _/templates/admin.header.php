<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF8" />
  <title><?php echo ($g_title != "") ? $g_title." | " : ""; ?>eCom</title>
  <link href='http://fonts.googleapis.com/css?family=Merienda+One' rel='stylesheet' type='text/css'>
  <link rel="stylesheet" href="/css/fonts.css" type="text/css" />
  <link rel="stylesheet" href="/css/reset.css" type="text/css" />
  <link rel="stylesheet" href="/css/base.css" type="text/css" />
  <link rel="stylesheet" href="/css/admin.css" type="text/css" />
  <!--[if lt IE 9]>
    <link rel="stylesheet" href="css/ie.css" type="text/css" />
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
</head>
<body>
<div id="extras"></div>
<header>
  <form method="GET" action="search">
    <input type="text" name="q" id="search_box"
      value="" size="25" placeholder="Search and you will find it..." />
  </form>
  <h1><a href="/admin" title="Home">
    eCom<span> - admin panel </span>
  </a></h1>
</header>
<nav>
  <ul>
    <li>
      <a href="brands">Brands</a>
    </li>
    <li>
      <a href="categories">Categories</a>
    </li>
    <li>
      <a href="products">Products</a>
    </li>
  </ul>
</nav>
<div class="content">

  <?php if($message != "") { ?>
    <p class="message"><?php echo $message; ?></p>
  <?php } ?>
