<?php 
  require_once("../../core/init.php");
  check_login();
  
  if(!isset($_GET['id']) || $_GET['id'] == "") redirect_to('/admin/brands');

  $brand = Brand::find_by_id(__($_GET['id']));

  if(!$brand) redirect_to('/admin/brands');

  if($brand->has_products()) {
  	$session->message("Has related Products. Cannot be deleted!");
    redirect_to("show?id={$brand->id}");
  }

  if($brand->delete()) {
  	$session->message("Brand '{$brand->name}' was deleted successfully!");
    redirect_to("/admin/brands");
  } else {
  	$session->message("Deletion failed!");
    redirect_to("show?id={$brand->id}");
  }

?>