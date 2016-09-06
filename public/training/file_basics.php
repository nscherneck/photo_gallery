<?php

echo __FILE__ . "<br>";
echo __DIR__ . "<br>";
echo file_exists(__DIR__) ? "yes<br>" : "no<br>";
echo is_file(__DIR__) ? "yes<br>" : "no<br>";
echo is_file(__DIR__ . "/file_basics.php") ? "yes<br>" : "no<br>";
echo is_file(__FILE__) ? "yes<br>" : "no<br>";
echo is_dir(__DIR__) ? "yes<br>" : "no<br>";
echo is_dir(__DIR__ . "/file_basics.php") ? "yes<br>" : "no<br>";
echo is_dir(__FILE__) ? "yes<br>" : "no<br>";
echo is_dir('..') ? "yes<br>" : "no<br>";

?>
