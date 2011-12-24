<?php

class MySQLDatabase {
   private $connection;
   private $lastQuery;
   function __construct() {
      $this->openConnection();
   }
   public function openConnection( ) {
      $this->connection = mysql_connect(DB_SERVER, DB_USER, DB_PASSWD);
      if(!$this->connection) {
         die('Database connection failed : ' . mysql_error());
      } else {
         $selectDatabase = mysql_select_db(DB_NAME, $this->connection);
         if(!$selectDatabase) {
            die('Database connection failed : ' . mysql_error());
         }
      }
   }
   public function closeConnection() {
      if(isset($this->connection)) {
         mysql_close($this->connection);
         unset($this->connection);
      }
   }
   public function query($sql) {
      $this->lastQuery = $sql;
      $resultSet = mysql_query($sql, $this->connection);
      $this->confirmQuery($resultSet);
      return $resultSet;
   }
   public function fetchArray($resultSet) {
      return mysql_fetch_array($resultSet);
   }
   public function numRows() {
      return mysql_num_rows($this->connection);
   }
   public function insertId() {
      return mysql_insert_id($this->connection);
   }
   public function affectedRows() {
      return mysql_affected_rows($this->connection);
   }      
   private function confirmQuery($result) {
      if(!$result) {
         $output = 'Database query failed : ' . mysql_error();
         $output .= "<br />Last Query was :" . $this->lastQuery;
         die($output);
      }
   }
   public function prepareValue($value) {
      return get_magic_quotes_gpc() ? mysql_real_escape_string($value): mysql_real_escape_string(stripslashes($value));
   }
}
$database = new MySQLDatabase();
$db =& $database;

?>
