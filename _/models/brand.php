<?php
require_once('database.php');
require_once('base.php');

class Brand extends Base {
  protected static $table_name = "brands";
  protected static $db_fields = array('id', 'name', 'categories', 'is_visible');
  public $id;
  public $name;
  public $categories;
  public $is_visible;

  static public function exists($brand_name) {
    $sql = "SELECT count(1) FROM ".self::$table_name;
    $sql .= " WHERE name='$brand_name'";
    $result = self::find_by_sql($sql);
    
    return count($result) > 0 ? true : false;
  }
}
?>
