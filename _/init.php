<?php

define('DS', '/');
define('LIB_ROOT', dirname(__FILE__));
define('SITE_ROOT', dirname(LIB_ROOT));

// Configuration Entries
require_once(LIB_ROOT.DS.'config/db.php');
require_once(LIB_ROOT.DS.'config/main.php');

// Helpers
require_once(LIB_ROOT.DS.'helpers/functions.php');
require_once(LIB_ROOT.DS.'helpers/pagination.php');
require_once(LIB_ROOT.DS.'helpers/session.php');

// Models
require_once(LIB_ROOT.DS.'models/database.php');
require_once(LIB_ROOT.DS.'models/base.php');
require_once(LIB_ROOT.DS.'models/product.php');
require_once(LIB_ROOT.DS.'models/category.php');
require_once(LIB_ROOT.DS.'models/brand.php');

?>
