<?php

class Order extends Base {
  static protected $table_name = "orders";
  static protected $db_fields = array('id', 'customer_id', 'shipping_email', 'shipping_name'
        , 'shipping_address', 'shipping_city', 'shipping_pincode', 'shipping_state'
        , 'shipping_country', 'shipping_telephone', 'no_of_products', 'total_amount'
        , 'status', 'date_created', 'date_modified');

  public $id;
  public $customer_id;
  public $shipping_email;
  public $shipping_name;
  public $shipping_address;
  public $shipping_city;
  public $shipping_pincode;
  public $shipping_state;
  public $shipping_country;
  public $shipping_telephone;
  public $no_of_products;
  public $total_amount;
  public $status;
  public $date_created;
  public $date_modified;
  
  static public function make($o) {
    $order = new Order();
    if(isset($o['id'])) $order->id = $o['id'];
    $order->customer_id = $o['customer_id'];
    $order->shipping_email = $o['shipping_email'];
    $order->shipping_name = $o['shipping_name'];
    $order->shipping_address = $o['shipping_address'];
    $order->shipping_city = $o['shipping_city'];
    $order->shipping_pincode = $o['shipping_pincode'];
    $order->shipping_state = $o['shipping_state'];
    $order->shipping_country = $o['shipping_country'];
    $order->shipping_telephone = $o['shipping_telephone'];
    $order->no_of_products = $o['no_of_products'];
    $order->total_amount = $o['total_amount'];
    $order->status = $o['status'];
    return $order;
  }
  public function set_customer($customer) {
    $this->shipping_email = $customer->email;
    $this->shipping_name = $customer->first_name ." ". $customer->last_name;
    $this->shipping_address = $customer->address_1 ." , ". $customer->address_2;
    $this->shipping_city = $customer->city;
    $this->shipping_pincode = $customer->pincode;
    $this->shipping_state = $customer->state;
    $this->shipping_country = $customer->country;
    $this->shipping_telephone = $customer->telephone;
  }
  public function products() {
    return OrderProduct::find_where("order_id = {$this->id}");
  }
  public function address() {
    return join("\n", array(
      $this->shipping_address,
      $this->shipping_city ." - ". $this->shipping_pincode,
      $this->shipping_state,
      $this->shipping_country
    ));
  }
}

?>