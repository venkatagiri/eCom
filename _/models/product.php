<?php
require_once('database.php');

class Product extends Base {
   static protected $table_name = "products";
   protected static $db_fields = array('id', 'name', 'parent_id', 'is_visible');
   public $id;
   
}
?>
