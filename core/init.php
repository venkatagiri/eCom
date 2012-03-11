<?php

define('DS', '/');
define('LIB_ROOT', dirname(__FILE__));
define('SITE_ROOT', dirname(LIB_ROOT));
define('STORE_ROOT', SITE_ROOT.'/store');
define('ADMIN_ROOT', SITE_ROOT.'/admin');

// Configuration Entries
require_once(LIB_ROOT.DS.'config/db.php');
require_once(LIB_ROOT.DS.'config/main.php');

// Helpers
require_once(LIB_ROOT.DS.'helpers/functions.php');
require_once(LIB_ROOT.DS.'helpers/pagination.php');
require_once(LIB_ROOT.DS.'helpers/session.php');
require_once(LIB_ROOT.DS.'helpers/uploader.php');

// Models
require_once(LIB_ROOT.DS.'models/database.php');
require_once(LIB_ROOT.DS.'models/base.php');
require_once(LIB_ROOT.DS.'models/product.php');
require_once(LIB_ROOT.DS.'models/category.php');
require_once(LIB_ROOT.DS.'models/brand.php');
require_once(LIB_ROOT.DS.'models/banner.php');
require_once(LIB_ROOT.DS.'models/attribute.php');
require_once(LIB_ROOT.DS.'models/product_attribute.php');

?>
