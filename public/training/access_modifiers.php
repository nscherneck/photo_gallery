<?php

class Example {
  public $a = 1;
  private $b = 2;
  protected $c = 3;

  public function show_abc() {
    echo $this->a . "<br>";
    echo $this->b . "<br>";
    echo $this->c . "<br>";
    echo "<br>";
  }
}

class AnotherExample extends Example {

}

$ex = new Example();

$ex->show_abc();
echo "<br>";

echo "Public Property: {$ex->a} <br>";
// echo "Private Property: {$ex->b} <br>";
// echo "Protected Property: {$ex->c} <br>";
echo "<br>";

$ex2 = new AnotherExample();

$ex2->show_abc();
echo "<br>";

echo "Public Property: {$ex2->a} <br>";
// echo "Private Property: {$ex2->b} <br>";
//echo "Protected Property: {$ex2->c} <br>";
echo "<br>";

?>
