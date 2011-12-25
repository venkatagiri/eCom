<?php

class MySQLDatabase {
   private $connection;
   private $last_query;
   function __construct() {
      $this->open_connection();
   }
   public function open_connection( ) {
      $this->connection = mysql_connect(DB_SERVER, DB_USER, DB_PASSWD);
      if(!$this->connection) {
         die('Database connection failed : ' . mysql_error());
      } else {
         $select_database = mysql_select_db(DB_NAME, $this->connection);
         if(!$select_database) {
            die('Database connection failed : ' . mysql_error());
         }
      }
   }
   public function close_connection() {
      if(isset($this->connection)) {
         mysql_close($this->connection);
         unset($this->connection);
      }
   }
   public function query($sql) {
      $this->last_query = $sql;
      $result_set = mysql_query($sql, $this->connection);
      $this->confirm_query($result_set);
      return $result_set;
   }
   public function fetch_array($result_set) {
      return mysql_fetch_array($result_set);
   }
   public function num_rows() {
      return mysql_num_rows($this->connection);
   }
   public function insert_id() {
      return mysql_insert_id($this->connection);
   }
   public function affected_rows() {
      return mysql_affected_rows($this->connection);
   }      
   private function confirm_query($result) {
      if(!$result) {
         $output = 'Database query failed : ' . mysql_error();
         $output .= "<br />Last Query was :" . $this->last_query;
         die($output);
      }
   }
   public function prepare_value($value) {
      return get_magic_quotes_gpc() ? mysql_real_escape_string($value): mysql_real_escape_string(stripslashes($value));
   }
}
$database = new MySQLDatabase();
$db =& $database;

?>
