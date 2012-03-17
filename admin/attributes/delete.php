<?php 
  require_once("../../core/init.php");
  check_login();
  
  if(!isset($_GET['id']) || $_GET['id'] == "") redirect_to('/admin/attributes');

  $attribute = Attribute::find_by_id(__($_GET['id']));

  if(!$attribute) redirect_to('/admin/attributes');

  if(count($attribute->attributes()) > 0) {
    $session->message("Attribute group with sub-attributes cannot be deleted!");
    redirect_to("show?id={$attribute->id}");
  }

  if($attribute->delete()) {
  	$session->message("Attribute '{$attribute->name}' was deleted successfully!");
    redirect_to("/admin/attributes");
  } else {
  	$session->message("Deletion failed!");
    redirect_to("show?id={$attribute->id}");
  }

?>