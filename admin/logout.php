<?php
   include_once('../_/init.php');
   if(!$session->isLoggedIn()) { redirect_to('login.php'); }
   $session->logout();
   redirect_to('login.php');
?>
