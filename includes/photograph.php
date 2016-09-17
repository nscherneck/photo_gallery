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

  public function destroy() {
    // first remove the database entry
    if($this->delete()) {
      // then remove the file
      $target_path = SITE_ROOT . DS . 'public' . DS . $this->image_path();
      return unlink($target_path) ? true : false;
    } else {
      // database delete failed
      return false;
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

  public function comments() {
    return Comment::find_comments_on($this->id);
  }

// common database methods


}

 ?>
