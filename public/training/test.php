<?php

function sum_strings($a, $b) {
  // $int_a = intval($a);
  // $int_b = intval($b);
  $sum = gmp_add($a, $b);
	return gmp_strval(number_format($sum, 0, '.', ''));
}

$val1 = "91912391239123912391239123";
$val2 = "91912391239123912391239123";

echo sum_strings($val1, $val2);


 ?>
