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
    return self::count("name='$brand_name'") > 0 ? true : false;
  }
}
?>
