<?php

class Category extends Base {
  static protected $table_name = "categories";
  static protected $db_fields = array('id', 'name', 'description', 'image',
         'parent_id', 'visible');
  public $id;
  public $name;
  public $description;
  public $image;
  public $parent_id;
  public $visible;
  
  static public function make($c) {
    $category = new Category();
    if(isset($c['id'])) $category->id = $c['id'];
    $category->name = $c['name'];
    $category->description = $c['description'];
    $category->image = @$c['image'];
    $category->parent_id = $c['parent_id'];
    $category->visible = $c['visible'] == '1' ? 1 : 0;
    return $category;
  }
  
  static public function root_category() {
    return self::find_by_id(1);
  }
  
  static public function main_categories() {
    return self::root_category()->children();
  }
  
  public function children() {
    return self::find_where('parent_id='.$this->id);
  }
  
  public function parent() {
    return self::find_by_id($this->parent_id);
  }
  
  public function brands() {
    return Brand::find_where("categories like '%{$this->id}%'");
  }
  
}

?>
