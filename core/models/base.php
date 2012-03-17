<?php

class Base {

  static public function find_with_pagination($where = '1 = 1', $current_page = 1, $per_page = 12) {
    $total_count = static::count($where);
    $pagination = new Pagination($current_page, $total_count, $per_page);
    
    $where_clause = $where;
    $where_clause .= " LIMIT " . $pagination->per_page;
    $where_clause .= " OFFSET " . $pagination->offset();
    return array($pagination, static::find_where($where_clause));
  }

  static public function find_where($where = '1 = 1') {
    $sql = "SELECT * FROM ".static::$table_name;
    $sql .= " WHERE ".$where;
    return static::find_by_sql($sql);
  }

  static public function delete_where($where = '1 != 1') {
    global $db;
    $sql = "DELETE FROM ".static::$table_name;
    $sql .= " WHERE ".$where;
    $db->query($sql);
    return true;
  }

  static public function find_by_id($id) {
    global $db;
    $sql = "SELECT * FROM ".static::$table_name;
    $sql .= " WHERE id=".$id;
    $sql .= " LIMIT 1";
    $result_array = static::find_by_sql($sql);
    return !empty($result_array) ? $result_array[0] : false;
  }
  
  static public function find_by_sql($sql) {
    global $db;
    $result_set = $db->query($sql);
    $obj_array = array();
    while($row = $db->fetch_array($result_set)) {
     $obj_array[] = static::instantiate($row);
    }
    return $obj_array;
  }
  
  static public function find_all() {
    return static::find_by_sql("SELECT * FROM ".static::$table_name);
  }
  
  static public function count($where_clause="1 = 1") {
    global $db;
    $sql = "SELECT COUNT(*) FROM ".static::$table_name;
    $sql .= " WHERE ".$where_clause;
    $result_set = $db->query($sql);
    $row = $db->fetch_array($result_set);
    return array_shift($row);
  }

  private static function instantiate($record) {
    $class_name = get_called_class();
    $obj = new $class_name;
    foreach($record as $attr => $value) {
     if($obj->has_attr($attr)) {
       $obj->$attr = $value;
     }
    }
    return $obj;
  }
  
  private function has_attr($attr) {
    $object_vars = $this->attrs();
    return array_key_exists($attr, $object_vars);
  }
  
  protected function attrs() {
    $attrs = array();
    foreach(static::$db_fields as $field) {
      if(property_exists($this, $field)) {
        $attrs[$field] = $this->$field;
      }
    }
    return $attrs;
  }
  
  protected function clean_attrs() {
    global $db;
    $clean_attrs = array();
    foreach($this->attrs() as $key => $value) {
      $clean_attrs[$key] = $db->prepare_value($value);
    }
    return $clean_attrs;
  }
  
  public function save() {
    return isset($this->id)? $this->update() : $this->create();
  }
  
  public function create() {
    global $db;
    $attrs = $this->clean_attrs();
    $sql = "INSERT INTO ".static::$table_name."( `";
    $sql .= join("`, `", array_keys($attrs));
    $sql .= "`) VALUES ( '";
    $sql .= join("', '", array_values($attrs));
    $sql .= "')";
    if($db->query($sql)) {
      $this->id = $db->insert_id();
      return true;
    } else {
      return false;
    }
  }

  public function has_changed() {
    global $db;
    if(!$this->id) return;
    
    $db_attrs = static::find_by_id($this->id)->clean_attrs();
    $attrs = $this->clean_attrs();
    foreach($attrs as $key=>$value) {
      if(preg_match("/^date/i", $key)) continue; // Don't consider dates while comparing.
      if($db_attrs[$key] != $value) return true;
    }
    return false;
  }
  
  public function update() {
    global $db;
    $attrs = $this->clean_attrs();
    $attr_pairs = array();
    foreach($attrs as $key=>$value) {
      $attr_pairs[] = "`{$key}`='{$value}'";
    }
    $sql = "UPDATE ".static::$table_name." SET ";
    $sql .= join(", ", $attr_pairs);
    $sql .= " WHERE id=".$db->prepare_value($this->id);
    $db->query($sql);
    return ($db->affected_rows() == 1)? true : false ;
  }
  
  public function delete() {
    global $db;
    $sql = "DELETE FROM ".static::$table_name;
    $sql .= " WHERE id=".$db->prepare_value($this->id);
    $sql .= " LIMIT 1";
    $db->query($sql);
    return ($db->affected_rows() == 1)? true : false ;
  }
  
}

?>