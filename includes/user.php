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

  public static function find_all() {
    return self::find_by_sql("SELECT * FROM " . self::$table_name);
  }

  public static function find_by_id($id=0) {
    global $database;
    $result_array = self::find_by_sql("SELECT * FROM " . self::$table_name . " WHERE id={$id} LIMIT 1");
    return !empty($result_array) ? array_shift($result_array) : false;
  }

  public static function find_by_sql($sql="") {
      global $database;
      $result_set = $database->query($sql);
      $object_array = array();
      while ($row = $database->fetch_array($result_set)) {
        $object_array[] = self::instantiate($row);
      }
      return $object_array;
    }

  private static function instantiate($record) {
      // this method populates the Object's properties with the associated database values

      // could check if record exists and is an array
      // Simple, long form approach:
      // $class_name = get_called_class();
        $object = new self;
      // $object->id             = $record['id'];
      // $object->username       = $record['username'];
      // $object->password       = $record['password'];
      // $object->first_name     = $record['first_name'];
      // $object->last_name      = $record['last_name'];
      // return $object;


      // the above approach would be tedious if the user table held many columns, so...
      // more dynamic, short form approach
      foreach($record as $attribute=>$value) {
        if($object->has_attribute($attribute)) {
          $object->$attribute = $value;
        }
      }
      return $object;
    }

  private function has_attribute($attribute) {
      // this method will return True or False

      // get_object_vars returns an associative array with all attributes
      // (including private attributes!) as the keys and their current values as the value
      $object_vars = get_object_vars($this);
      // we don't care about the value, we just want to know if the key exists
      // will return True or False
      return array_key_exists($attribute, $object_vars);
    }



// instance methods

  public function save() {
    // a new record won't yet have an id
    return isset($this->id) ? $this->update() : $this->create();
  }

  public function create() {
    global $database;
    // don't forget SQL syntax and good habits
    // - INSERT INTO table (key, key) VALUES ('value', 'value')
    // - single quotes around all values
    // - escape all values to prevent SQL injection

    $sql = "INSERT INTO users (";
    $sql .= "username, password, first_name, last_name";
    $sql .= ") VALUES ('";
    $sql .= $database->escape_value($this->username) . "', '";
    $sql .= $database->escape_value($this->password) . "', '";
    $sql .= $database->escape_value($this->first_name) . "', '";
    $sql .= $database->escape_value($this->last_name) . "')";
    if($database->query($sql)) {
      $this->id = $database->insert_id();
      return true;
    } else {
      return false;
    }

  }

  public function update() {
    global $database;
    // don't forget SQL syntax and good habits
    // - INSERT INTO table (key, key) VALUES ('value', 'value')
    // - single quotes around all values
    // - escape all values to prevent SQL injection

    $sql = "UPDATE users SET ";
    $sql .= "username='" . $database->escape_value($this->username) . "', ";
    $sql .= "password='" . $database->escape_value($this->password) . "', ";
    $sql .= "first_name='" . $database->escape_value($this->first_name) . "', ";
    $sql .= "last_name='" . $database->escape_value($this->last_name) . "'";
    $sql .= " WHERE id=" . $database->escape_value($this->id);
    $database->query($sql);
    return ($database->affected_rows() == 1) ? true : false;

  }

  public function delete() {
    global $database;
    // don't forget SQL syntax and good habits
    // - INSERT INTO table (key, key) VALUES ('value', 'value')
    // - single quotes around all values
    // - escape all values to prevent SQL injection
    // - use LIMIT 1
    $sql = "DELETE FROM users ";
    $sql .= "WHERE id=" . $database->escape_value($this->id);
    $sql .= " LIMIT 1";
    $database->query($sql);
    return ($database->affected_rows() == 1) ? true : false;

  }


// end of User class

}

?>
