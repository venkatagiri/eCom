<?php

class OrderProduct extends Base {
  static protected $table_name = "order_products";
  static protected $db_fields = array('id', 'order_id', 'product_id', 'name',
        'price', 'quantity');
  
  public $id;
  public $order_id;
  public $product_id;
  public $name;
  public $price;
  public $quantity;
  
  static public function make($op) {
    $order_product = new OrderProduct();
    if(isset($op['id'])) $order_product->id = $op['id'];
    $order_product->order_id = @$op['order_id'];
    $order_product->product_id = @$op['product_id'];
    $order_product->name = $op['name'];
    $order_product->price = $op['price'];
    $order_product->quantity = $op['quantity'];
    return $order_product;
  }
}

?>