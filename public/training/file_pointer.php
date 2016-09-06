<?php

$file = 'filetest.txt';
if($handle = fopen($file, 'w')) { // overwrite
  $content = "123\n456\n789"; // double quote matter...with single quotes, the \ will be treated literally
  fwrite($handle, $content); // returns number of bytes or false

  $pos = ftell($handle);
  fseek($handle, $pos-6);
  fwrite($handle, "abcdef");

  rewind($handle);
  fwrite($handle, "xyz");

  fclose($handle);
  echo "Content written to file.";
} else {
  echo "Could not open file for writing.";
}

// BEWARE!!! it will overtype
// Note: a and a+ modes will not let you move the pointer






?>
