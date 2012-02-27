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
  <meta charset="UTF-8" />
  <link href="data:image/x-icon;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQEAYAAABPYyMiAAAABmJLR0T///////8JWPfcAAAACXBIWXMAAABIAAAASABGyWs+AAAAF0lEQVRIx2NgGAWjYBSMglEwCkbBSAcACBAAAeaR9cIAAAAASUVORK5CYII=" rel="icon" type="image/x-icon" />
  <title><?php echo ($g_title != "") ? $g_title." | " : ""; ?>Admin Panel | eCom</title>
  <!-- <link href='http://fonts.googleapis.com/css?family=Merienda+One|Asap' rel='stylesheet' type='text/css'> -->
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
  <form method="GET" action="/admin/search">
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
      <a href="/admin/index">Dashboard</a>
    </li>
    <li class="category">
      <a>Catalog</a>
      <table class="sub_nav"><tr><td class="col">
        <a href="/admin/products">Products</a>
        <a href="/admin/categories">Categories</a>
        <a href="/admin/brands">Brands</a>
      </td></tr></table>
    </li>
    <li>
      <a href="/admin/orders">Orders</a>
    </li>
    <li>
      <a href="/admin/customers">Customers</a>
    </li>
    <li class="category">
      <a>Extensions</a>
      <table class="sub_nav"><tr><td class="col">
        <a href="/admin/banners">Banners</a>
      </td></tr></table>
    </li>
    <?php if(is_logged_in()) { ?>
    <li class="right">
      <a href="/admin/logout">Logout</a>
    </li>
    <?php } ?>
  </ul>
</nav>
<div class="content wrapper">

  <?php if($message != "") { ?>
    <p class="message"><?php echo $message; ?></p>
  <?php } ?>
