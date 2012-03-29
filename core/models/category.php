<?php

class Category extends Base {
  static protected $table_name = "categories";
  static protected $db_fields = array('id', 'name', 'key', 'description', 'image',
         'parent_id', 'visible');
  public $id;
  public $name;
  public $key;
  public $description;
  public $image;
  public $parent_id;
  public $visible;
  
  static public function make($c) {
    $category = new Category();
    if(isset($c['id'])) $category->id = $c['id'];
    $category->name = $c['name'];
    $category->key = get_key($c['name']);
    $category->description = $c['description'];
    $category->image = @$c['image'];
    $category->parent_id = $c['parent_id'];
    $category->visible = $c['visible'] == '1' ? 1 : 0;
    return $category;
  }

  static public function find_by_key($key = '') {
    $result_array = Category::find_where("`key` = '{$key}' LIMIT 1");
    return !empty($result_array) ? $result_array[0] : false;
  }
    
  static public function root_category() {
    return self::find_by_id(1);
  }
  
  static public function main_categories() {
    return self::root_category()->children();
  }
  
  public function children() {
    return self::find_where("parent_id={$this->id}");
  }

  public function visible_children() {
    return self::find_where("parent_id={$this->id} AND visible=1");
  }
  
  public function parent() {
    return self::find_by_id($this->parent_id);
  }
  
  public function brands() {
    return Brand::find_where("categories like '%{$this->id}%'");
  }

  public function has_products() {
    return (Product::count("category_id = {$this->id}") > 0) ? true : false;
  }

}

?>