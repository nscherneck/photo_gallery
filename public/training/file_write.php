<?php

$file = 'filetest.txt';
if($handle = fopen($file, 'w')) { // overwrite
  $content = "This is line one.\nThis is line two.\nThis is line three.\n"; // double quote matter...with single quotes, the \ will be treated literally
  fwrite($handle, $content); // returns number of bytes or false
fclose($handle);
echo "Content written to file.";
} else {
  echo "Could not open file for writing.";
}








?>
