<?php
require_once('database.php');

class Product {
   static protected $tableName = "products";
   protected static $dbFields = array('id', 'name', 'parent_id', 'is_visible');
   public $id;
   public $username;
   public $password;
   public $firstName;
   public $lastName;
   
   
   
   //Commom DB Methods
   static public function findById($id) {
      global $db;   
      $sql = "SELECT * FROM ".self::$tableName;
      $sql .= " WHERE id=".$id;
      $sql .= " LIMIT 1";
      $resultArray = self::findBySQL($sql);
      return !empty($resultArray) ? $resultArray[0] : false;
   }
   static public function findBySQL($sql) {
      global $db;
      $resultSet = $db->query($sql);
      $objArray = array();
      while($row = $db->fetchArray($resultSet)) {
         $objArray[] = self::instantiate($row);
      }
      return $objArray;
   }
   static public function findAll() {
      return self::findBySQL("SELECT * FROM ".self::$tableName);
   }
   static public function count() {
      global $db;
      $sql = "SELECT COUNT(*) FROM ".self::$tableName;
      $resultSet = $db->query($sql);
      $row = $db->fetchArray($resultSet);
      return array_shift($row);
   }
   
   private static function instantiate($record) {
      $obj = new self;
      foreach($record as $attr => $value) {
         if($obj->hasAttr($attr)) {
            $obj->$attr = $value;
         }
      }
      return $obj;
   }
   private function hasAttr($attr) {
      $objectVars = $this->attrs();
      return array_key_exists($attr, $objectVars);
   }
   protected function attrs() {
      $attrs = array();
      foreach(self::$dbFields as $field) {
         if(property_exists($this, $field)) {
            $attrs[$field] = $this->$field;
         }
      }
      return $attrs;
   }
   protected function cleanAttrs() {
      global $db;
      $cleanAttrs = array();
      foreach($this->attrs() as $key => $value) {
         $cleanAttrs[$key] = $db->prepareValue($value);
      }
      return $cleanAttrs;
   }
   public function save() {
      return isset($this->id)? $this->update() : $this->create();
   }
   public function create() {
      global $db;
      $attrs = $this->cleanAttrs();
      $sql = "INSERT INTO ".self::$tableName."( ";
      $sql .= join(", ", array_keys($attrs));
      $sql .= ") VALUES ( '";
      $sql .= join("', '", array_values($attrs));
      $sql .= "')";
      if($db->query($sql)) {
         $this->id = $db->insertId();
         return true;
      } else {
         return false;
      }
   }
   public function update() {
      global $db;
      $attrs = $this->cleanAttrs();
      $attrPairs = array();
      foreach($attrs as $key=>$value) {
         $attrPairs[] = "{$key}='{$value}'";
      }
      $sql = "UPDATE ".self::$tableName." SET ";
      $sql .= join(", ", $attrPairs);
      $sql .= " WHERE id=".$db->prepareValue($this->id);
      $db->query($sql);
      return ($db->affectedRows() == 1)? true : false ;
   }
   public function delete() {
      global $db;
      $sql = "DELETE FROM ".self::$tableName;
      $sql .= " WHERE id=".$db->prepareValue($this->id);
      $sql .= " LIMIT 1";
      $db->query($sql);
      return ($db->affectedRows() == 1)? true : false ;      
   }
}
?>
