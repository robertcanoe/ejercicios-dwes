<?php
function inicializarMazo() {
    $mazo = [];
        for ($i = 1; $i <= 40; $i++) {
                $valor = ($i % 10 == 0) ? 0.5 : ($i % 10 > 7 ? 0.5 : $i % 10);
                $mazo[] = [
                    'imagen' => 'img/' . $i . '.jpg',
                    'valor' => $valor
        ];
    }
    shuffle($mazo);
    return $mazo;
}

function calcularPuntos($cartas) {
    $puntos = 0;
    foreach ($cartas as $carta) {
        $puntos += $carta['valor'];
    }
    return $puntos;
}  