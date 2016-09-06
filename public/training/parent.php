<?php //parent.php

// demonstrates the use of static properties and methods using "parent"

// starting class
class A {
  static $a = 1;

  static function modified_a() {
    return self::$a + 10;
  }

  public function hello() {
    echo "Hello!<br>";
  }
}

// the new class "B" inherits from "A"

class B extends A {

  static function attr_test() {
    echo A::$a;
    // refers to the parent class by using it's name
  }

  static function method_test() {
    echo A::modified_a();
    // refers to the parent class by using it's name
  }

  static function attr_test2() {
    echo parent::$a;
    // refers to the parent class by using "parent"
  }

  static function method_test2() {
    echo parent::modified_a();
    // refers to the parent class by using "parent"
  }

  public function instance_test() {
    echo $this->hello();
  }
}

echo B::$a . "<br>";
echo B::modified_a() . "<br>";
echo B::attr_test() . "<br>";
echo B::method_test() . "<br>";
echo B::attr_test2() . "<br>";
echo B::method_test2() . "<br>";

$object = new B();

$object->instance_test()

?>
