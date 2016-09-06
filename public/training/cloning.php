<?php

class Beverage {
  public $name;

  function __construct() {
    echo "New beverage was created.<br><br>";
  }

  function __clone() {
    echo "Existing beverage was cloned.<br><br>";
  }

}

$a = new Beverage();
$a->name = 'Coffee';
echo $a->name . "<br>";

$b = $a; // always a reference with Objects
$b->name = 'Tea';
echo $a->name . "<br>";

$c = clone $a;
$c->name = 'Orange Juice';
echo $c->name . "<br>";
 ?>
