<?php
require_once('database.php');

class Category extends Base {
   static protected $table_ame = "categories";
   protected static $db_fields = array('id', 'name', 'parent_id', 'is_visible');
   public $id;
}
?>
