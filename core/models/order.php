<?php

class Order extends Base {
  static protected $table_name = "orders";
  static protected $db_fields = array('id', 'customer_id', 'customer_name', 'customer_address'
        , 'customer_email', 'customer_telephone', 'no_of_products'
        , 'total_amount', 'status', 'date_created', 'date_modified');

  public $id;
  public $customer_id;
  public $customer_name;
  public $customer_address;
  public $customer_email;
  public $customer_telephone;
  public $no_of_products;
  public $total_amount;
  public $status;
  public $date_created;
  public $date_modified;
  
  static public function make($o) {
    $order = new Order();
    if(isset($o['id'])) $order->id = $o['id'];
    $order->customer_id = $o['customer_id'];
    $order->customer_name = $o['customer_name'];
    $order->customer_address = $o['customer_address'];
    $order->customer_email = $o['customer_email'];
    $order->customer_telephone = $o['customer_telephone'];
    $order->no_of_products = $o['no_of_products'];
    $order->total_amount = $o['total_amount'];
    $order->status = $o['status'];
    return $order;
  }

  public function set_customer($customer) {
    $this->customer_name = $customer->first_name . " " . $customer->last_name;
    $this->customer_address = join("\n", array(
      $customer->address_1,
      $customer->address_2,
      $customer->city . " - " . $customer->pincode,
      $customer->state
    ));
    $this->customer_email = $customer->email;
    $this->customer_telephone = $customer->telephone;
  }
  public function products() {
    return OrderProduct::find_where("order_id = {$this->id}");
  }
}

?>