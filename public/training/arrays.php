<?php

$data = array("Manufacturer" => "Fenwal", "Model" => "Net-8000ML", "Addressable Loops" => "2");

while (list($key, $value) = each($data)) {
  echo "$key: $value <br> \n";
}

echo "<hr>";

$someVar = "Fenwal,Net8000ML,2";
$array = explode(",", $someVar);
var_dump($array);

echo "<hr>";

print_r($array);

echo "<hr>";

list($manufacturer, $model, $slc) = $array;

echo $model;

echo "<hr>";

$new = array("Nathan", "Danielle", "Ava", "Donovan", "Amanda", "Annabelle", "Cooper");
sort($new, SORT_STRING);

foreach ($new as $val) {
    echo $val . "<br>\n";
}

 ?>
