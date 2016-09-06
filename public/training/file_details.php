<?php

$filename = 'filetest.txt';

echo "File size: " . filesize($filename) . " bytes<br>"; // in bytes

// filemtime: last modified (changed content)
// filectime: last changed (changed content or metadata)
// fileatime: last accessed (any read/change)

echo "Last modified: " . strftime('%m/%d/%Y %H:%M', filemtime($filename)) . "<br>";
echo "Last changed: " . strftime('%m/%d/%Y %H:%M', filectime($filename)) . "<br>";
echo "Last accessed: " . strftime('%m/%d/%Y %H:%M', fileatime($filename)) . "<br>";

echo "<hr>";

$path_parts = pathinfo(__FILE__);
echo $path_parts['dirname'] . "<br>";
echo $path_parts['basename'] . "<br>";
echo $path_parts['filename'] . "<br>";
echo $path_parts['extension'] . "<br>";

 ?>
