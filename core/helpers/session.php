<?php

class Session {
  private $is_logged_in = false;
  private $is_admin = false;
  public $user_id;
  public $msg;

  function __construct() {
    session_start();
    $this->check_msg();
    $this->check_login();
  }
  public function check_login() {
    if(isset($_SESSION['user_id'])) {
      $this->user_id = $_SESSION['user_id'];
      if($this->user_id == "admin") $this->is_admin = true;
      else $this->is_admin = false;
      $this->is_logged_in = true;
    } else {
      unset($this->user_id);
      $this->is_logged_in = false;
      $this->is_admin = false;
    }
  }
  public function login($user) {
    if($user) {
      $this->user_id = $_SESSION['user_id'] = $user;
      if($this->user_id == "admin") $this->is_admin = true;
      else $this->is_admin = false;
      $this->is_logged_in = true;
    }
  }
  public function logout() {
    unset($_SESSION['user_id']);
    unset($this->user_id);
    $this->is_logged_in = false;
    $this->is_admin = false;
  }
  public function is_logged_in() {
    return $this->is_logged_in;
  }
  public function is_admin() {
    return $this->is_admin;
  }
  private function check_msg() {
    if(isset($_SESSION['msg'])) {
      $this->msg = $_SESSION['msg'];
      unset($_SESSION['msg']);
    }
  }
  public function message($msg='') {
    if(empty($msg)) {
      return $this->msg;
    } else {
      $_SESSION['msg'] = $msg;
    }
  }

  public function set($key, $value) {
    $_SESSION[$key] = $value;
  }
  public function get($key) {
    if(isset($_SESSION[$key])) return $_SESSION[$key];
    return false;
  }
}

$session = new Session();
$message = $session->message();

?>