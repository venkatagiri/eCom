<?php

define('DEBUG', true);
define('STORE_NAME','Red Electronics Depot');

if(DEBUG == true) {
  error_reporting(E_ALL);
  ini_set('display_errors', '1');
}

// Search Types
define('GENERIC_SEARCH', 0);
define('CATEGORY_SEARCH', 1);
define('FILTERED_SEARCH', 2);

// Images path
define('PRODUCT_PATH', SITE_ROOT.'/assets/p');
define('CATEGORY_PATH', SITE_ROOT.'/assets/c');
define('BRAND_PATH', SITE_ROOT.'/assets/b');

?>
