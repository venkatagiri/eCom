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
/* .helpers */

function check_login() {
  global $session;
  if(!$session->isLoggedIn()) { redirect_to("login.php?url={$_SERVER['REQUEST_URI']}"); }
}

function redirect_to($location = NULL) {
   if($location != NULL) {
      header("Location: {$location}");
      exit;
   }
}

function __autoload($className) {
   $className = strtolower($className);
   $path = LIB_ROOT.DS."models".DS."{$className}.php";
   if(file_exists($path)) {
      require_once($path);
   } else {
      die("The file {$className}.php doesn't exist.");
   }
}

function log_action($action, $message="") {
   $logFile = SITE_ROOT.DS.'logs'.DS.'log.txt';
   if($handle = fopen($logFile, 'a')) {
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
   $invitationCode = array();
   $i = 0;
   while($i<$length) {
      $invitationCode[] = $string[rand(0, strlen($string))];
      $i++;
   }
   return join('', $invitationCode);
}
function include_layout($file) {
   include_once(SITE_ROOT.DS.'public'.DS.'layouts'.DS.$file);
}
?>
