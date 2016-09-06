<?php

// like fopen/fread/fclose:
// opendir()
// readdir()
// closedir()

$dir = ".";
if(is_dir($dir)) {
  if($dir_handle = opendir($dir)) {
    while($filename = readdir($dir_handle)) { //readdir() gets each item in the directory
      if(!($filename == '.') && !($filename == '..')) {
        echo "filename: {$filename}<br>";
      }
    }
    // use rewinddir($dir_handle) to start over
    closedir($dir_handle);
  }
}

echo "<hr>";

// use scandir() to put all file name into an array
if(is_dir($dir)) {
  $dir_array = scandir($dir);
  foreach($dir_array as $file) {
    if(stripos($file, '.') > 0) {
      echo "filename: {$file}<br>";
    }
  }
}
// not much shorter but may be less complicated
// makes things like reverse order much easier

?>
