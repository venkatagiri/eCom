<?php

class Customer extends Base {
  static protected $table_name = "customers";
  static protected $db_fields = array('id', 'email', 'password', 'first_name'
        , 'last_name', 'address_1', 'address_2', 'city'
        , 'state', 'pincode', 'country', 'telephone'
        , 'status', 'date_created', 'date_modified');

  public $id;
  public $email;
  public $password;
  public $first_name;
  public $last_name;
  public $address_1;
  public $address_2;
  public $city;
  public $state;
  public $pincode;
  public $country;
  public $telephone;
  public $status;
  public $date_created;
  public $date_modified;
  
  static public function make($c) {
    $customer = new Customer();
    if(isset($c['id'])) $customer->id = $c['id'];
    $customer->email = $c['email'];
    $customer->password = $c['password'];// Change this to hashing(bcrypt)
    $customer->first_name = $c['first_name'];
    $customer->last_name = $c['last_name'];
    $customer->address_1 = $c['address_1'];
    $customer->address_2 = $c['address_2'];
    $customer->city = $c['city'];
    $customer->state = $c['state'];
    $customer->pincode = $c['pincode'];
    $customer->country = $c['country'];
    $customer->telephone = $c['telephone'];
    $customer->status = $c['status'];
    return $customer;
  }
}

?>