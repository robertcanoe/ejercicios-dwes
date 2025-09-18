<?php
    /**
     * El programa mostrará una imágen y el nombre de la estación del año según la fecha actual
     * @author: Robert
     * Fecha: 18/09/2025
     */

    $month = date("n");
    $day = date("j");
    $message = "";
    $image = "";

    if (($month == 3 && $day >= 21) || ($month > 3 && $month < 6) || ($month == 6 && $day <= 20)) {
        $image = "./img/primavera.png";
        $message = "PRIMAVERA";
    } elseif (($month == 6 && $day >= 21) || ($month > 6 && $month < 9) || ($month == 9 && $day <= 22)) {
        $image = "./img/verano.png";
        $message = "VERANO";
    } elseif (($month == 9 && $day >= 23) || ($month > 9 && $month < 12) || ($month == 12 && $day <= 21)) {
        $image = "./img/otono.png";
        $message = "OTOÑO";
    } else {
        $image = "./img/invierno.png";
        $message = "INVIERNO";
    }

    echo "<img src='$image' alt='$message'>";
    echo "<h1>$message</h1>";
    ?>
