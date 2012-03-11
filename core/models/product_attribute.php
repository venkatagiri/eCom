<?php

class ProductAttribute extends Base {
  static protected $table_name = "product_attributes";
  static protected $db_fields = array('id', 'product_id', 'attribute_id', 'name', 'value');
  
  public $id;
  public $product_id;
  public $attribute_id;
  public $name;
  public $value;
  
  static public function make($pa) {
    $product_attribute = new ProductAttribute();
    if(isset($pa['id'])) $product_attribute->id = $pa['id'];
    $product_attribute->product_id = @$pa['product_id'];
    $product_attribute->attribute_id = $pa['attribute_id'];
    $product_attribute->name = $pa['name'];
    $product_attribute->value = $pa['value'];
    return $product_attribute;
  }

  static public function make_array($pa_array) {
    $pas = array();
    foreach($pa_array as $pa ) {
      $pas[] = self::make($pa);
    }
    return $pas;
  }

  static public function get_ids($product_id) {
    $pas = self::find_where("product_id = {$product_id}");
    $ids = array();
    foreach ($pas as $pa) {
      $ids[] = $pa->id;
    }
    return $ids;
  }

  static public function create_attributes($pa_array, $product_id) {
    $new_ids = array();
    $failed = false;
    foreach($pa_array as $pa) {
      $pa->product_id = $product_id;
      if(!$pa->save()) {
        $failed = true;
        break;
      } else {
        $new_ids[] = $pa->id;
      }
    }
    if($failed) {
      foreach($new_ids as $id) self::find_by_id($id)->delete();
      return false;
    } else {
      return true;
    }
  }
  
  static public function delete_attributes($ids) {
    foreach($ids as $id) {
      if(!self::make($id)->delete()) return false;
    }
    return true;
  }

}

?>
