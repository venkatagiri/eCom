<?php

define('DEBUG', true);
define('STORE_NAME','Red Electronics Depot');
define('SERVER_NAME', $_SERVER['SERVER_NAME']);

if(DEBUG == true) {
  error_reporting(E_ALL);
  ini_set('display_errors', '1');
}

// Log files
define('ADMIN_LOG_FILE', LIB_ROOT.'/logs/admin.log');
define('STORE_LOG_FILE', LIB_ROOT.'/logs/store.log');

// Log levels
define('ECOM_ERROR', 0);
define('ECOM_DEBUG', 1);
define('ECOM_INFO', 2);

// Search Types
define('GENERIC_SEARCH', 0);
define('CATEGORY_SEARCH', 1);
define('FILTERED_SEARCH', 2);

$ASSETS_PATH = STORE_ROOT.'/assets';

// Images path
$IMAGES_PATH = array(
  'PRODUCT'   => $ASSETS_PATH.'/product',
  'CATEGORY'  => $ASSETS_PATH.'/category',
  'BRAND'     => $ASSETS_PATH.'/brand',
  'BANNER'    => $ASSETS_PATH.'/banner'
);

$BANNER_TYPES = array(
  1 => 'Front Page',
  2 => 'Category - Above Content',
  3 => 'Category - Sidebar'
);

?>
