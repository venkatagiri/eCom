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

$ASSETS_PATH = SITE_ROOT.'/public/assets';

// Images path
$IMAGES_PATH = array(
  'PRODUCT'   => $ASSETS_PATH.'/product',
  'CATEGORY'  => $ASSETS_PATH.'/category',
  'BRAND'     => $ASSETS_PATH.'/brand'
);

?>
