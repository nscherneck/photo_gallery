<?php

class Table {

  public $legs;
  public $leg_count = 0;
  static public $total_tables = 0;

  function __construct($leg_count=4) {
    $this->legs = $leg_count;
    Table::$total_tables++;
    // increments each time the Class is instantiated as an Object
  }

  function __destruct() {
    Table::$total_tables--;
    // decrements
    // destructors are not used often
  }
}

$table = new Table(4);
echo $table->legs . "<br>";
echo $table::$total_tables . "<br><br>";
//echo $table->leg_count . "<br><br>";

$table2 = new Table(8);
echo $table2->legs . "<br>";
echo $table2::$total_tables . "<br><br>";
//echo $table2->leg_count . "<br><br>";

$table3 = new Table(6);
echo $table3->legs . "<br>";
echo $table3::$total_tables . "<br><br>";
//echo $table3->leg_count . "<br><br>";









?>
