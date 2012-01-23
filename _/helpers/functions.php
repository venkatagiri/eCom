<?php
/* helpers */

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
function build_categories_tree($parent) {
  $tree = "";
  $children = $parent->get_children();
  
  if(count($children) == 0) $tree .= "<li class=\"node leaf\">";
  else if($parent->id == 1) $tree .= "<li class=\"node opened\">";
  else $tree .= "<li class=\"node closed\">";
  
  $tree .= <<<EOF
    <span class="toggle"></span>
    <a href="show?id={$parent->id}" class="header">{$parent->name}</a>
    <a href="new?parent_id={$parent->id}" title="Add a sub Category" class="add_category">+</a>
    <ul class="list">
EOF;
  
  foreach($children as $child) $tree .= build_categories_tree($child);
  
  $tree .= <<<EOF
    </ul>
  </li>
EOF;
  
  return $tree;
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
function generate() {
   $length = 32;
   $string ="0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
   $invitation_code = array();
   $i = 0;
   while($i<$length) {
      $invitation_code[] = $string[rand(0, strlen($string))];
      $i++;
   }
   return join('', $invitation_code);
}
function include_layout($file) {
   include_once(SITE_ROOT.DS.'public'.DS.'layouts'.DS.$file);
}
?>
