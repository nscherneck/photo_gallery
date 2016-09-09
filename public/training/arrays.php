<?php

echo "<p>An array is an integer indexed collection of objects.  An array can contain strings, integers, other arrays, etc.</p>";

echo "<hr>";

$panel1 = ["Manufacturer" => "Fenwal", "Model" => "Net-8000ML", "Addressable Loops" => "2"]; // shortened format as of PHP 5.4
$panel2 = array("Manufacturer" => "Fenwal", "Model" => "Net-6000", "Addressable Loops" => "1");
$panel3 = array("Manufacturer" => "Fenwal", "Model" => "732", "Addressable Loops" => "0");
$panel4 = array("Fenwal", "Net-2000", "1");
$fenwal = array($panel1, $panel2, $panel3, $panel4);

while (list($key, $value) = each($panel1)) {
  echo "$key: $value <br> \n";
}

echo "<hr>";

foreach($fenwal as $panels) {
echo "<br> \n";
  foreach($panels as $key => $value) {
    echo "$key: $value <br> \n";
}
}
echo "<br> \n";

echo "<hr> \n";


$fenwal_assoc = array("Panel One" => $panel1,"Panel Two" => $panel2,"Panel Three" => $panel3,"Panel Four" => $panel4);

echo "Quantity of Panels: " . count($fenwal_assoc);

foreach($fenwal_assoc as $p_key => $panel_group) {
  echo "<ul> \n";
  echo "<li>$p_key</li> \n";
  foreach($panel_group as $c_key => $value) {
    echo "<ul> \n <li> \n $c_key: $value</li> \n </ul> \n";
}
  echo "</ul> \n";
}

echo "<br> \n";

echo "<hr> \n";

print_r(array_values($panel1));

echo "<br> \n";

echo "<hr> \n";

list($man, $model, $slc) = $panel4;
echo "The system is a " . $man . " " . $model . " which has " . $slc . " addressable loops.";

echo "<br> \n";

echo "<hr> \n";

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

echo "<hr>";

echo $panel1['Manufacturer'];

 ?>
