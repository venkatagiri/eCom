<?php
   require_once('../core/init.php');
   if(!$session->is_logged_in()) { redirect_to('/admin/login'); }
   $session->logout();
   redirect_to('/admin/login');
?>