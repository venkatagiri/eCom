<?php
class Session {
   private $loggedIn = false;
   public $userId;
   public $msg;
   function __construct() {
      session_start();
      $this->checkMsg();
      $this->checkLogin();
   }
   public function checkLogin() {
      if(isset($_SESSION['userId'])) {
         $this->userId = $_SESSION['userId'];
         $this->loggedIn = true;
      } else {
         unset($this->userId);
         $this->loggedIn = false;
      }
   }
   public function login($user) {
      if($user) {
         $this->userId = $_SESSION['userId'] = $user;
         $this->loggedIn = true;
      }
   }
   public function logout() {
      unset($_SESSION['userId']);
      unset($this->userId);
      $this->loggedIn = false;
   }
   public function isLoggedIn() {
      return $this->loggedIn;
   }
   private function checkMsg() {
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
