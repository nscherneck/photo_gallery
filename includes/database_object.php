<?php

require_once(LIB_PATH . DS . "database.php");

class DatabaseObject {

  // review the details of late static binding to understand the use of
  // static::whatever
  // http://php.net/manual/en/language.oop5.late-static-bindings.php

  // properties

  // common database methods

  public static function find_all() {
    return static::find_by_sql("SELECT * FROM " . static::$table_name);
  }

  public static function find_by_id($id=0) {
    global $database;
    $result_array = static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE id=" . $database->escape_value($id) . " LIMIT 1");
    return !empty($result_array) ? array_shift($result_array) : false;
  }

  public static function find_by_sql($sql="") {
      global $database;
      $result_set = $database->query($sql);
      $object_array = array();
      while ($row = $database->fetch_array($result_set)) {
        $object_array[] = static::instantiate($row);
      }
      return $object_array;
    }

  public static function count_all() {
    global $database;
    $sql = "SELECT COUNT(*) FROM " . static::$table_name;
    $result_set = $database->query($sql);
    $row = $database->fetch_array($result_set);
    return array_shift($row);
  }

  private static function instantiate($record) {
      // this method populates the Object's properties with the associated database values

      // could check if record exists and is an array
      // Simple, long form approach:
      // $class_name = get_called_class();
        $object = new static;
      // $object->id             = $record['id'];
      // $object->username       = $record['username'];
      // $object->password       = $record['password'];
      // $object->first_name     = $record['first_name'];
      // $object->last_name      = $record['last_name'];
      // return $object;


      // the above approach would be tedious if the user table held many columns, so...
      // more dynamic, short form approach
      foreach($record as $attribute => $value) {
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
      // $object_vars = $this->attributes();
      // we don't care about the value, we just want to know if the key exists
      // will return True or False
      return array_key_exists($attribute, $this->attributes());
    }

// instance methods

  protected function attributes() {
    // return an associative array of attribute keys and their values
    $attributes = array();
    foreach(static::$db_fields as $field) {
      if(property_exists($this, $field)) {
        $attributes[$field] = $this->$field;
      }
    }
    return $attributes;
  }

  protected function sanitized_attributes() {
    global $database;
    $clean_attributes = array();
    // sanitize the values before submitting
    // Not: does not alter the actual value of each attribute
    foreach($this->attributes() as $key => $value) {
      $clean_attributes[$key] = $database->escape_value($value);
    }
    return $clean_attributes;
  }

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

    $attributes = $this->sanitized_attributes();
    $sql = "INSERT INTO " . static::$table_name . " (";
    $sql .= join(", ", array_keys($attributes));
    $sql .= ") VALUES ('";
    $sql .= join("', '", array_values($attributes));
    $sql .= "')";

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
    $attributes = $this->sanitized_attributes();
    $attribute_pairs = array();
    foreach($attributes as $key => $value) {
      $attribute_pairs[] = "{$key}='{$value}'";
    }

    $sql = "UPDATE " . static::$table_name . " SET ";
    $sql .= join(", ", $attribute_pairs);
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
    $sql = "DELETE FROM " . static::$table_name;
    $sql .= " WHERE id=" . $database->escape_value($this->id);
    $sql .= " LIMIT 1";
    $database->query($sql);
    return ($database->affected_rows() == 1) ? true : false;

  }

}

?>
