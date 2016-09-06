<?php

class Box {
  public $name = "Box";
}

$box = new Box();
$box_reference = $box;
$box_clone = clone $box;

$box_changed = clone $box;
$box_changed->name = "Changed Box";

$another_box = new Box();

// == is casual and just checks to see if the attributes are the same

echo $box == $box_reference ? 'true' : 'false';  // true
echo "<br>";
echo $box == $box_clone ? 'true' : 'false';  // true
echo "<br>";
echo $box == $box_changed ? 'true' : 'false';  // false
echo "<br>";
echo $box == $another_box ? 'true' : 'false';  // true
echo "<br><br>";

echo $box === $box_reference ? 'true' : 'false';  // true
echo "<br>";
echo $box === $box_clone ? 'true' : 'false';  // false
echo "<br>";
echo $box === $box_changed ? 'true' : 'false';  // false
echo "<br>";
echo $box === $another_box ? 'true' : 'false';  // false
echo "<br><br>";

/*
COMPARING OBJECTS                     ==    ===
References                            yes   yes
Instances with matching attributes    yes   no
Instances with different attributes   no    no
*/

?>
