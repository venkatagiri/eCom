<?php

class Category extends Base {
  static protected $table_name = "categories";
  static protected $db_fields = array('id', 'name', 'description', 'parent_id', 'visible');
  public $id;
  public $name;
  public $description;
  public $parent_id;
  public $visible;
  
  static public function make($cat) {
    $category = new Category();
    $category->name = $cat['name'];
    $category->description = $cat['description'];
    $category->parent_id = $cat['parent_id'];
    $category->visible = $cat['visible'] == '1' ? 1 : 0;
    return $category;
  }
  
  static public function root_category() {
    return self::find_by_id(1);
  }
  
  public function children() {
    return self::find_by_where('parent_id='.$this->id);
  }
  
  public function parent() {
    return self::find_by_id($this->parent_id);
  }
  
  public function brands() {
    return Brand::find_by_where("categories like '%{$this->id}%'");
  }
  
}

?>
