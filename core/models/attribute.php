<?php

class Attribute extends Base {
  static protected $table_name = "attributes";
  static protected $db_fields = array('id', 'name', 'group_id');
  
  public $id;
  public $name;
  public $group_id;
  
  static public function make($a) {
    $attribute = new Attribute();
    if(isset($a['id'])) $attribute->id = $a['id'];
    $attribute->name = $a['name'];
    $attribute->group_id = $a['group_id'];
    return $attribute;
  }
  
  static public function root_group() {
    return self::find_by_id(1);
  }
  
  static public function all_groups() {
    return self::root_group()->attributes();
  }
  
  static public function all_attributes() {
    return self::find_where("id != 1 AND group_id !=1"); // Don't select Root Group and Groups.
  }
  
  public function attributes() {
    return self::find_where("group_id={$this->id}");
  }

  public function group() {
    return self::find_by_id($this->group_id);
  }
  
}

?>
