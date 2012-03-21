<?php

class ProductFeature extends Base {
  static protected $table_name = "product_features";
  static protected $db_fields = array('id', 'product_id', 'value');
  
  public $id;
  public $product_id;
  public $value;
  
  static public function make($pf) {
    $product_feature = new ProductFeature();
    if(isset($pf['id'])) $product_feature->id = $pf['id'];
    $product_feature->product_id = @$pf['product_id'];
    $product_feature->value = $pf['value'];
    return $product_feature;
  }

  static public function make_array($pf_array) {
    $pfs = array();
    foreach($pf_array as $pf ) {
      $pfs[] = self::make($pf);
    }
    return $pfs;
  }

  static public function get_ids($product_id) {
    $pfs = self::find_where("product_id = {$product_id}");
    $ids = array();
    foreach ($pfs as $pf) {
      $ids[] = $pf->id;
    }
    return $ids;
  }

  static public function create_features($pf_array, $product_id) {
    $new_ids = array();
    $failed = false;
    foreach($pf_array as $pf) {
      $pf->product_id = $product_id;
      if(!$pf->save()) {
        $failed = true;
        break;
      } else {
        $new_ids[] = $pf->id;
      }
    }
    if($failed) {
      foreach($new_ids as $id) self::find_by_id($id)->delete();
      return false;
    } else {
      return true;
    }
  }
  
  static public function delete_features($ids) {
    foreach($ids as $id) {
      if(!self::find_by_id($id)->delete()) return false;
    }
    return true;
  }
}

?>