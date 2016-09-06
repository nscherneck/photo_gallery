<?php

require_once(LIB_PATH . DS . "database.php");

class DatabaseObject {

  // review the details of late static binding to understand the use of
  // static::whatever
  // http://php.net/manual/en/language.oop5.late-static-bindings.php

  // properties

    // protected static $table_name = "";

  /* ---------------------------------------------------------*/


  // common database methods

    public static function find_all() {
    return static::find_by_sql("SELECT * FROM " . static::$table_name);
  }

    public static function find_by_id($id=0) {
    global $database;
    $result_array = static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE id={$id} LIMIT 1");
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



}

?>
