<?php
define("MIN", 0);
define("MAX", 100);
define("TAM", 10);

$array_pares = array();

$array_cuadrados = array();

while (count($array_pares) < TAM) {
    $num = rand(MIN, MAX);
    if ($num % 2 == 0 && !in_array($num, $array_pares)) {
        $array_pares[] = $num;
    }
}

$array_cuadrados = array_map(function($n) {
    return $n ** 2;
},$array_pares);


print_r($array_cuadrados);