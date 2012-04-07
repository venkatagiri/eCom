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

// Order Status
define('ORDER_PENDING',     1);
define('ORDER_PROCESSING',  2);
define('ORDER_SHIPPED',     3);
define('ORDER_COMPLETED',   4);
define('ORDER_CANCELLED',   5);
define('ORDER_FAILED',      6);
define('ORDER_REFUNDED',    7);
define('ORDER_EXPIRED',     8);

$ORDER_STATUS = array(
  ORDER_PENDING => 'Pending',
  ORDER_PROCESSING => 'Processing',
  ORDER_SHIPPED => 'Shipped',
  ORDER_COMPLETED => 'Completed',
  ORDER_CANCELLED => 'Cancelled',
  ORDER_FAILED => 'Failed',
  ORDER_REFUNDED => 'Refunded',
  ORDER_EXPIRED => 'Expired'
);

// Search Types
define('GENERIC_SEARCH', 0);
define('CATEGORY_SEARCH', 1);
define('FILTERED_SEARCH', 2);

$PRICE_RANGE = array(
  '1' => array(
    'start_price' => 0,
    'end_price' => 2000,
    'text' => "Rs. 0 - Rs. 2000"
  ),
  '2' => array(
    'start_price' => 2000,
    'end_price' => 5000,
    'text' => "Rs. 2000 - Rs. 5000"
  ),
  '3' => array(
    'start_price' => 5000,
    'end_price' => 10000,
    'text' => "Rs. 5000 - Rs. 10000"
  ),
  '4' => array(
    'start_price' => 10000,
    'end_price' => 9999999,
    'text' => "Above Rs. 10000"
  )
);

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
