<?php 
  require_once("../../core/init.php");
  check_login();
  
  if(!isset($_GET['id']) || $_GET['id'] == "") redirect_to('/admin/banners');

  $banner = Banner::find_by_id(__($_GET['id']));

  if($banner->delete()) {
    unlink($IMAGES_PATH['BANNER']."/{$banner->image}");
  	$session->message("Banner '{$banner->name}' was deleted successfully!");
    redirect_to("/admin/banners");
  } else {
  	$session->message("Deletion failed!");
    redirect_to("show?id={$banner->id}");
  }

?>