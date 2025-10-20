<?php

/**
 * @author: Roberto Cano Estévez
 * @date 18/06/2025
 */

 /*Ejercicio: Crear una tabla de multiplicar del 1 al 10*/


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tabla de Multiplicar</title>
</head>
<body>
    <h1>Tabla de Multiplicar del 1 al 10</h1>
    
    <table border="1">
        <tr>
            <th>x</th>
            <?php
            // Generar encabezados de columnas (1 al 10)
            for ($col = 1; $col <= 10; $col++) {
                echo "<th>$col</th>";
            }
            ?>
        </tr>
        
        <?php
        // Generar filas de la tabla
        for ($row = 1; $row <= 10; $row++) {
            echo "<tr>";
            // Primera celda de la fila
            echo "<th>$row</th>";
            
            // celdas con los resultados de la multiplicación
            for ($col = 1; $col <= 10; $col++) {
                $resultado = $row * $col;
                echo "<td>$resultado</td>";
            }
            echo "</tr>";
        }
        ?>
    </table>
</body>
<style>
    table {
        border: 2px solid black;
        border-collapse: collapse;
        width: 50%;
        text-align: center;
    }
</style>
</html>


