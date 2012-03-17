<?php 
  require_once("../../core/init.php");
  check_login();
  
  if(!isset($_GET['id']) || $_GET['id'] == "") redirect_to('/admin/products');

  $product = Product::find_by_id(__($_GET['id']));

  if(!$product) redirect_to('/admin/products');

  if($product->delete()) {
    unlink($IMAGES_PATH['PRODUCT']."/{$product->image}");
    ProductAttribute::delete_where("product_id = {$product->id}");
    $session->message("Product '{$product->name}' was deleted successfully!");
    redirect_to("/admin/products");
  } else {
    $session->message("Deletion failed!");
    redirect_to("show?id={$product->id}");
  }

?>