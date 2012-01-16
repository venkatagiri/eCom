<!DOCTYPE html>
<!-- 
         ________         __         _________ 
    ___  _\_____  \  ____ |  | _______\______  \
    \  \/ / _(__  < /    \|  |/ /\__  \   /    /
     \   / /       \   |  \    <  / __ \_/    / 
      \_/ /______  /___|  /__|_ \(____  /____/  
                 \/     \/     \/     \/        

    Developed By Venkata Giri Reddy - http://v3nka7.tk/
-->
<html>
<head>
  <meta charset="UTF8" />
  <title><?php echo ($g_title != "") ? $g_title." | " : ""; ?>Admin Panel | eCom</title>
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
<header><div class="wrapper">
  <form method="GET" action="search">
    <input type="text" name="q" id="search_box"
      value="" size="25" placeholder="Search and you will find it..." />
  </form>
  <h1><a href="/admin" title="Home">
    eCom<span> - admin panel </span>
  </a></h1>
</div></header>
<nav>
  <ul class="wrapper">
    <li>
      <a href="index">Dashboard</a>
    </li>
    <li class="category">
      <a>Catalog</a>
      <table class="sub_nav"><tr><td class="col">
        <a href="products">Products</a>
        <a href="categories">Categories</a>
        <a href="brands">Brands</a>
      </td></tr></table>
    </li>
    <li>
      <a href="orders">Orders</a>
    </li>
    <li>
      <a href="customers">customers</a>
    </li>
    <?php if(is_logged_in()) { ?>
    <li style="float: right;">
      <a href="logout">Logout</a>
    </li>
    <?php } ?>
  </ul>
</nav>
<div class="content wrapper">

  <?php if($message != "") { ?>
    <p class="message"><?php echo $message; ?></p>
  <?php } ?>
