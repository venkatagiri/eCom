<?php 
  require_once("../../core/init.php");
  check_login();
  
  if(!isset($_GET['id']) || $_GET['id'] == "") redirect_to('/admin/categories');

  $category = Category::find_by_id(__($_GET['id']));

  if(!$category) redirect_to('/admin/categories');

  if(count($category->children()) > 0) {
    $session->message("Main category with sub-categories cannot be deleted!");
    redirect_to("show?id={$category->id}");
  }

  if($category->has_products()) {
  	$session->message("Has related Products. Cannot be deleted!");
    redirect_to("show?id={$category->id}");
  }

  if($category->delete()) {
  	$session->message("Category '{$category->name}' was deleted successfully!");
    redirect_to("/admin/categories");
  } else {
  	$session->message("Deletion failed!");
    redirect_to("show?id={$category->id}");
  }

?>