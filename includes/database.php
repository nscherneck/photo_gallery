<?php

require_once (LIB_PATH . DS . "config.php");

//
//
//

class MySQLDatabase {

  // properties

  private $connection;

  // methods

  function __construct() {
    $this->open_connection();
  }

  public function open_connection() {
    $this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    if(mysqli_connect_errno()) {
      die("Database connection failed: " . mysqli_connect_error() . " (" . mysqli_connect_error() . ")");
    }
  }

  public function close_connection() {
    if (isset($this->connection)) {
      mysql_close($this->connection);
      unset($this->connection);
    }
  }

  public function query($sql) {
    // perform database query
    $result = mysqli_query($this->connection, $sql);
    $this->confirm_query($result);
    return $result;
  }

  private function confirm_query($result) {
    // confirm that the query has returned results
    if (!$result) {
      die("Database query failed.");
    }
  }

  public function escape_value($string) {
    $escaped_string = mysqli_real_escape_string($this->connection, $string);
    return $escaped_string;
  }

// "database neutral" methods

  public function fetch_array($result_set) {
    return mysqli_fetch_array($result_set);
  }

  public function num_rows($result_set) {
    return mysqli_num_rows($result_set);
  }

  public function insert_id() {
    // get the last id inserted over the current db connection
    return mysqli_insert_id($this->connection);
  }

  public function affected_rows() {
    return mysqli_affected_rows($this->connection);
  }

// end of MySQLDatabase class

}

//
//
//

$database = new MySQLDatabase();

 ?>
