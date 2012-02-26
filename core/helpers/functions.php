<?php
/* helpers */

// Used to sanitize the input provided, before using in a query.
function __($text) {
  global $db;
  return $db->prepare_value($text);
}
function sanitize(&$query_string, $keys) {
  foreach($query_string as $key => $value) {
    if(in_array($key, $keys)) $query_string[$key] = __($value);
  }
}
function get_key($str) {
  return str_replace(' ', '-', trim(strtolower($str)));
}
function get_header($_t = '') {
  global $message;
	$g_title = $_t;
	include(LIB_ROOT.DS."templates/header.php");
}
function get_footer() {
	include(LIB_ROOT.DS."templates/footer.php");
}
function get_admin_header($_t = '') {
  global $message;
	$g_title = $_t;
	include(LIB_ROOT.DS."templates/admin.header.php");
}
function get_admin_footer() {
	include(LIB_ROOT.DS."templates/admin.footer.php");
}
function list_brands($selected="-1") {
  $brands = Brand::find_all_sorted();
  $output = "";
  if(count($brands) == 0) {
    $output .= "<option value=\"0\">No Brands Available</option>";
  } else {
    $output .= "<option value=\"0\">Select a Brand</option>";
    foreach($brands as $brand) {
      $output .= "<option value=\"{$brand->id}\"";
      if($selected == $brand->id) $output .= " selected=selected ";
      $output .= ">{$brand->name}</option>";
    }
  }
  
  return $output;
}
function list_categories($selected="-1") {
  $main_categories = Category::root_category()->children();
  $output = "<option value=\"0\">Select a Category</option>";
  foreach($main_categories as $main_category) {
    $output .= "<optgroup label=\"{$main_category->name}\">";
    foreach($main_category->children() as $sub_category) {
      $output .= "<option value=\"{$sub_category->id}\"";
      if($selected == $sub_category->id) $output .= " selected=selected ";
      $output .= ">{$sub_category->name}</option>";
    }
    $output .= "</optgroup>";
  }
  
  return $output;
}
function list_main_categories($selected="-1") {
  $main_categories = Category::root_category()->children();
  $output = "<option value=\"0\">Select a Category</option>";
  foreach($main_categories as $main_category) {
    $output .= "<option value=\"{$main_category->id}\"";
    if($selected == $main_category->id) $output .= " selected=selected ";
    $output .= ">{$main_category->name}</option>";
  }
  
  return $output;
}

/* .helpers */

function check_login() {
  global $session;
  if(!$session->is_logged_in()) { redirect_to("/admin/login?url={$_SERVER['REQUEST_URI']}"); }
}

function is_logged_in() {
  global $session;
  return $session->is_logged_in();
}

function redirect_to($location = NULL) {
   if($location != NULL) {
      header("Location: {$location}");
      exit;
   }
}

function __autoload($class_name) {
   $class_name = strtolower($class_name);
   $path = LIB_ROOT.DS."models".DS."{$class_name}.php";
   if(file_exists($path)) {
      require_once($path);
   } else {
      die("The file {$class_name}.php doesn't exist.");
   }
}

function log_action($action, $message="") {
   $log_file = SITE_ROOT.DS.'logs'.DS.'log.txt';
   if($handle = fopen($log_file, 'a')) {
      $timestamp = strftime("%d-%m-%Y %H:%M:%S", time());
      $content = "{$timestamp} | {$action} - {$message}\n";
      fwrite($handle, $content);
      fclose($handle);
   } else {
      echo "Could not open the file";
   }
}
function random_string($length = 6) {
   $string ="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
   $random_string = array();
   $i = 0;
   while($i < $length) {
      $random_string[] = $string[rand(0, strlen($string))];
      $i++;
   }
   return join('', $random_string);
}
function include_layout($file) {
   include_once(SITE_ROOT.DS.'public'.DS.'layouts'.DS.$file);
}
?>
