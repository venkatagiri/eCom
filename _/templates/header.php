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
  <link href="data:image/x-icon;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQEAYAAABPYyMiAAAABmJLR0T///////8JWPfcAAAACXBIWXMAAABIAAAASABGyWs+AAAAF0lEQVRIx2NgGAWjYBSMglEwCkbBSAcACBAAAeaR9cIAAAAASUVORK5CYII=" rel="icon" type="image/x-icon" />
  <title><?php echo ($g_title != "") ? $g_title." | " : ""; ?><?php echo STORE_NAME; ?></title>
  <!-- <link href='http://fonts.googleapis.com/css?family=Merienda+One' rel='stylesheet' type='text/css'> -->
  <link rel="stylesheet" href="/css/fonts.css" type="text/css" />
  <link rel="stylesheet" href="/css/reset.css" type="text/css" />
  <link rel="stylesheet" href="/css/base.css" type="text/css" />
  <link rel="stylesheet" href="/css/style.css" type="text/css" />
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
  <h1><a href="/" title="Home">
    <?php echo STORE_NAME; ?>
  </a></h1>
</div></header>

<?php include_once('navigation.php'); ?>

<div class="content wrapper">
