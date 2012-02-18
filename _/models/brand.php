<?php

class Brand extends Base {
  static protected $table_name = "brands";
  static protected $db_fields = array('id', 'name', 'description', 'image',
        'categories', 'visible');
  public $id;
  public $name;
  public $description;
  public $image;
  public $categories;
  public $visible;
  
  static public function make($b) {
    $brand = new Brand();
    if(isset($b['id'])) $brand->id = $b['id'];
    $brand->name = $b['name'];
    $brand->description = $b['description'];
    $brand->image = @$b['image'];
    $brand->categories = $b['categories'];
    $brand->visible = $b['visible'] == '1' ? 1 : 0;
    return $brand;
  }

  static public function exists($brand_name) {
    return self::count("name='".__($brand_name)."'") > 0 ? true : false;
  }
  
  static public function find_all_sorted() {
    return self::find_by_sql("SELECT * FROM ".self::$table_name." ORDER BY name");
  }
  
  public function categories() {
    return Category::find_by_id($this->categories)->name;
  }
}

?>
