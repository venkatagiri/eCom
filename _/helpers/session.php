<?php
class Session {
   private $logged_in = false;
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
         $this->logged_in = true;
      } else {
         unset($this->user_id);
         $this->logged_in = false;
      }
   }
   public function login($user) {
      if($user) {
         $this->user_id = $_SESSION['user_id'] = $user;
         $this->logged_in = true;
      }
   }
   public function logout() {
      unset($_SESSION['user_id']);
      unset($this->user_id);
      $this->logged_in = false;
   }
   public function is_logged_in() {
      return $this->logged_in;
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
}

$session = new Session();
$message = $session->message();

?>
