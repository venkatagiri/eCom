<?php

class Product extends Base {
  static protected $table_name = "products";
  static protected $db_fields = array('id', 'name', 'description',
        'price', 'quantity', 'brand_id', 'category_id', 'visible');
  public $id;
  public $name;
  public $description;
  public $price;
  public $quantity;
  public $brand_id;
  public $category_id;
  public $visible;
   
  static public function make($p) {
    $product = new Product();
    $product->name = $p['name'];
    $product->description = $p['description'];
    $product->price = $p['price'];
    $product->quantity = $p['quantity'];
    $product->brand_id = $p['brand_id'];
    $product->category_id = $p['category_id'];
    $product->visible = $p['visible'] == '1' ? 1 : 0;
    return $product;
  }

  public function brand() {
    return ($this->brand_id != "") ? Brand::find_by_id($this->brand_id) : new Brand();
  }

  public function category() {
    return ($this->category_id != "") ? Category::find_by_id($this->category_id) : new Category();
  }

}

?>
