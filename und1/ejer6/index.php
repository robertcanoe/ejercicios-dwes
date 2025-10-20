<?php

/**
 * @author: Roberto Cano Estévez
 * @date 18/06/2025
 */

 /*Ejercicio: Crear un calendario*/

$year = 2024;
$month = 2;

$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
$firstDay = date('w', mktime(0, 0, 0, $month, 1, $year));
// Ajustar para que la semana empiece en lunes (domingo pasa de 0 a 6)
$firstDay = ($firstDay + 6) % 7;

?>

<!-- Vista-->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Calendario</title>
    <style>
        table {
            width: 30%;
            border-collapse: collapse;
            text-align: center;
        }
        td:nth-child(7) {
            background-color: red;
            color: white;
        }
    </style>
</head>
<body>
    <h1>Calendario de <?php echo $month . '/' . $year; ?></h1>
    <table border="1">
        <tr>
            <th>L</th>
            <th>M</th>
            <th>X</th>
            <th>J</th>
            <th>V</th>
            <th>S</th>
            <th>D</th>
        </tr>
        <?php
        // crear las filas del calendario
        $day = 1;
        
        // primera fila
        echo "<tr>";
        // rellenar las celdas vacías antes del primer día
        for ($i = 0; $i < $firstDay; $i++) {
            echo "<td></td>";
        }
        
        // rellenar los días del mes
        while ($day <= $daysInMonth) {
            // pasar a la siguiente fila cada 7 días
            if (($day + $firstDay - 1) % 7 == 0 && $day != 1) {
                echo "</tr><tr>";
            }

            echo "<td>$day</td>";
            $day++;
        }
        
        // Completar última fila
        $cellsUsed = ($daysInMonth + $firstDay) % 7;
        if ($cellsUsed > 0) {
            for ($i = $cellsUsed; $i < 7; $i++) {
                echo "<td></td>";
            }
        }
        // cerrar la última fila
        echo "</tr>";
        ?>
    </table>
</body>
</html>