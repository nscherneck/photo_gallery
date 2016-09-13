<?php

require_once(LIB_PATH . DS . "database.php");

class Photograph extends DatabaseObject {

  protected static $table_name = "photographs";
  protected static $db_fields = array('id', 'filename', 'type', 'size', 'caption');
  public $id;
  public $filename;
  public $type;
  public $size;
  public $caption;

  private $tmp_path;
  protected $upload_dir = "images";
  public $errors = array();
  protected $upload_errors = array(
  	// http://www.php.net/manual/en/features.file-upload.errors.php
  	UPLOAD_ERR_OK 				=> "No errors.",
  	UPLOAD_ERR_INI_SIZE  	=> "Larger than upload_max_filesize.",
    UPLOAD_ERR_FORM_SIZE 	=> "Larger than form MAX_FILE_SIZE.",
    UPLOAD_ERR_PARTIAL 		=> "Partial upload.",
    UPLOAD_ERR_NO_FILE 		=> "No file.",
    UPLOAD_ERR_NO_TMP_DIR => "No temporary directory.",
    UPLOAD_ERR_CANT_WRITE => "Can't write to disk.",
    UPLOAD_ERR_EXTENSION 	=> "File upload stopped by extension."
  );

// pass in $_FILE(['uploaded_file']) as an argument
  public function attach_file($file) {
    // perform error checking on the form parameters
    if(!$file || empty($file) || !is_array($file)) {

      // error: nothing uploaded or wrong argument usage
      $this->errors[] = "No file was uploaded";
      return false;

      } elseif($file['error'] != 0) {

        $this->errors[] = $this->upload_errors[$file['error']];
        return false;

        } else {

          // set object attributes to the form parameters
          $this->tmp_path = $file['tmp_name'];
          $this->filename = basename($file['name']);
          $this->type = $file['type'];
          $this->size = $file['size'];
          return true;

        }
}

  public function save() {
    // a new record won't have an id yet
    if(isset($this->id) && ($this->id > 0)) {
      // really only used to update the caption
      $this->update();
    } else {
      // make sure there are no errors
      // can't save if there are pre-existing errors
      if(!empty($this->errors)) { return false; }

      // verify the caption isn't too long for the database
      if(strlen($this->caption) > 255) {
        $this->errors[] = "Caption must be fewer than 255 characters.";
        return false;
      }

      // can't save without filename and temp location
      if(empty($this->filename) || empty($this->tmp_path)) {
        $this->errors[] = "The file location was not available.";
        return false;
      }

      // determine the target_path
      $target_path = SITE_ROOT . DS . 'public' . DS . $this->upload_dir . DS . $this->filename;

      // verify the file doesn't already exist
      if(file_exists($target_path)) {
        $this->errors[] = "The file {$this->filename} already exists.";
        return false;
      }

      // attempt to move the file
      if(move_uploaded_file($this->tmp_path, $target_path)) {
        // save a corresponding entry to the database
        if($this->create()) {
          // we're done with $tmp_path.  the file isn't there anymore
          unset($this->tmp_path);
          return true;
        }
      } else {
        $this->errors[] = "The file upload failed, possibly due to incorrect permissions on the upload folder.";
        return false;
      }
    }
  }

  public function image_path() {
    return $this->upload_dir . DS . $this->filename;
  }

  public function size_as_text() {
    if($this->size < 1024) {
      return "{$this->size} bytes";
    } elseif($this->size < 1048576) {
      $size_kb = round($this->size / 1024);
      return "{$size_kb} KB";
    } else {
      $size_mb = round($this->size / 1048576, 2);
      return "{$size_mb} MB";
    }
  }

// common database methods

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

  protected function attributes() {
    // return an associative array of attribute keys and their values
    $attributes = array();
    foreach(self::$db_fields as $field) {
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
    // Note: does not alter the actual value of each attribute
    foreach($this->attributes() as $key => $value) {
      $clean_attributes[$key] = $database->escape_value($value);
    }
    return $clean_attributes;
  }

  // public function save() {
  //   // a new record won't yet have an id
  //   return isset($this->id) ? $this->update() : $this->create();
  // }

  public function create() {
    global $database;
    // don't forget SQL syntax and good habits
    // - INSERT INTO table (key, key) VALUES ('value', 'value')
    // - single quotes around all values
    // - escape all values to prevent SQL injection

    $attributes = $this->sanitized_attributes();
    $sql = "INSERT INTO " . self::$table_name . " (";
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

    $sql = "UPDATE " . self::$table_name . " SET ";
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
    $sql = "DELETE FROM " . self::$table_name;
    $sql .= " WHERE id=" . $database->escape_value($this->id);
    $sql .= " LIMIT 1";
    $database->query($sql);
    return ($database->affected_rows() == 1) ? true : false;

  }

}

 ?>
