<?php

require_once(LIB_PATH . DS . "database.php");

class User extends DatabaseObject {

// remember to review the inherited methods from the DatabaseObject class


// properties

  protected static $table_name = "users";
  public $id;
  public $username;
  public $password;
  public $first_name;
  public $last_name;


/* ---------------------------------------------------------*/


// methods

  public function full_name() {
      if (isset($this->first_name) && (isset($this->last_name))) {
        return $this->first_name . " " . $this->last_name;
      } else {
        return "";
      }
    }

  public static function authenticate($username="", $password="") {
      global $database;
      $username = $database->escape_value($username);
      $password = $database->escape_value($password);

      $sql = "SELECT * FROM users WHERE username = '{$username}' AND password = '{$password}' LIMIT 1";
      $result_array = self::find_by_sql($sql);
      return !empty($result_array) ? array_shift($result_array) : false;

    }


// end of User class

}

?>