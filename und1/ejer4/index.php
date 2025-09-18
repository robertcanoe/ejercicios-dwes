<?php

/**
 * @author: Roberto Cano Estévez
 * @date 18/06/2025
 */

# variable
$mes = "Febrero";

// añado el año bisiesto 


switch ($mes) {

# Agrupé los meses de 31 días

    case "Enero":
    case "Marzo":
    case "Mayo":
    case "Julio":
    case "Agosto":
    case "Octubre":
    case "Diciembre":
        echo "$mes tiene: 31 días";
        break;

# Agrupé los meses de 30 días
    case "Abril":
    case "Junio":
    case "Septiembre":
    case "Noviembre":
        echo "$mes tiene: 30 días";
        break;
    case "Febrero":
        echo "$mes tiene: 28 días";
        break;

    default:
        echo "No es un mes válido";
        break;
}
