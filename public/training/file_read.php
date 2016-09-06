<?php

$file = 'filetest.txt';

if($handle = fopen($file, 'r')) { // read

$content = fread($handle, filesize($file)); // each character is one byte
fclose($handle);
}

echo nl2br($content); // new line to break function
echo "<hr>";

/*-----------------------------------------------*/
// the shortcut for reading files

$content = file_get_contents($file);
echo nl2br($content);
echo "<hr>";

/*-----------------------------------------------*/

// incremental reading

$file = 'filetest.txt';
$content = "";
if($handle = fopen($file, 'r')) { // read
  while(!feof($handle)) {
    $content .= fgets($handle);
  }
  fclose($handle);
}

echo nl2br($content);
echo "<hr>";

 ?>
