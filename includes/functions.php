<?php

function strip_zeros_from_date( $marked_string="") {
  // first remove the marked zeros
  $no_zeros = str_replace('*0', '', $marked_String);
  // then remove any remaining marks
  $cleaned_string =  str_replace('*', '', $no_zeros);
  return $cleaned_string;
}

function redirect_to($location = NULL) {
  if($location != NULL) {
    header("Location: {$location}");
    exit;
  }
}

function output_message($message="") {
  if(!empty($message)) {
    return "<p class=\"message\">{$message}</p>";
  } else {
    return "";
  }
}

function __autoload($class_name) {
  $class_name = strtolower($class_name);
  $path = LIB_PATH . DS . "{$class_name}.php";
  if(file_exists($path)) {
    require_once($path);
  } else {
    die("The file {$class_name} could not be found");
  }
}

function include_layout_template($template="") {
  include(SITE_ROOT . DS . 'public' . DS . 'layouts' . DS . $template);
}

function log_action($action, $message="") {

/* ---------------------------------------*/

  $file = SITE_ROOT . DS . 'logs' . DS . 'system_log.txt';

/* ---------------------------------------*/

  if(!(file_exists($file))) {
    if($handle = fopen($file, 'w')) { // overwrite
      $content = "BEGIN LOG FILE\n"; // double quote matter...with single quotes, the \ will be treated literally
      fwrite($handle, $content); // returns number of bytes or false
    fclose($handle);
    }
  }

/* ---------------------------------------*/

if($handle = fopen($file, 'a')) {
  $content = date('Y-m-d H:i:s') . " | " . $action . $message . "\n";
  fwrite($handle, $content);
fclose($handle);
}


}

 ?>
