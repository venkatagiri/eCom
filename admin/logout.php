<?php
   include_once('../_/init.php');
   if(!$session->is_logged_in()) { redirect_to('login.php'); }
   $session->logout();
   redirect_to('login.php');
?>
