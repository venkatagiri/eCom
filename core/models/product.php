<?php

class Product extends Base {
  static protected $table_name = "products";
  static protected $db_fields = array('id', 'name', 'key', 'short_description',
        'description', 'image', 'price',
        'quantity', 'brand_id', 'category_id', 'status',
        'date_created', 'date_modified');
  public $id;
  public $name;
  public $key;
  public $short_description;
  public $description;
  public $image;
  public $price;
  public $quantity;
  public $brand_id;
  public $category_id;
  public $status;
  public $date_created;
  public $date_modified;

  static public function make($p) {
    $product = new Product();
    if(isset($p['id'])) $product->id = $p['id'];
    $product->name = $p['name'];
    $product->key = get_key($p['name']);
    $product->short_description = $p['short_description'];
    $product->description = $p['description'];
    $product->image = @$p['image'];
    $product->price = $p['price'];
    $product->quantity = $p['quantity'];
    $product->brand_id = $p['brand_id'];
    $product->category_id = $p['category_id'];
    $product->status = $p['status'] == '1' ? 1 : 0;
    return $product;
  }

  static public function new_arrivals($category_id, $limit = 4) {
    $where_clause = " category_id = {$category_id} OR category_id IN ( SELECT id FROM categories WHERE parent_id={$category_id} ) ";
    $where_clause .= " ORDER BY date_created DESC ";
    $where_clause .= " LIMIT {$limit} ";
    return self::find_where($where_clause);
  }

  public function add_attributes($attrs) {
    return ProductAttribute::create_attributes($attrs, $this->id);
  }

  public function delete_attributes() {
    return ProductAttribute::delete_where("product_id = {$this->id}");
  }

  public function add_features($features) {
    return ProductFeature::create_features($features, $this->id);
  }

  public function delete_features() {
    return ProductFeature::delete_where("product_id = {$this->id}");
  }

  public function brand() {
    return ($this->brand_id != "") ? Brand::find_by_id($this->brand_id) : new Brand();
  }

  public function category() {
    return ($this->category_id != "") ? Category::find_by_id($this->category_id) : new Category();
  }

  public function attributes($group_id = '') {
    $where_clause = "product_id = {$this->id}";
    if($group_id != "") $where_clause .= " AND group_id = {$group_id}";
    return ProductAttribute::find_where($where_clause);
  }

  public function features() {
    $where_clause = "product_id = {$this->id}";
    return ProductFeature::find_where($where_clause);
  }
}

?>