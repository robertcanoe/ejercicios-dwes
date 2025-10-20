<?php 

    include("./lib/function.php");
    session_start();

    // Declaramos las variables
    $anio_form = date("Y");
    $mes_form = date("m");
    $listatareas = [];

    if (isset($_POST["enviar"])) {
        if($_POST["anio"] != "" && $_POST["mes"] != "") {
            $anio_form = clearData($_POST["anio"]);
            $mes_form = clearData($_POST["mes"]);
        }
    }

    if (isset($_POST["cargarTareas"])) {
        $listatareas = $_SESSION["listaTareas"];

        // Añadir a un fichero
        $f = fopen("tareas.txt", "a");
        foreach ($_SESSION["listaTareas"] as $fechaSesion => $tareas) {
            foreach ($tareas as $tarea) {
                fwrite($f, "$fechaSesion,$tarea\n");
            }
        }
    }

    // Comprobamos el numero de dias del mes
    $numeroDiasMes = cal_days_in_month(CAL_GREGORIAN, $mes_form, $anio_form);

    // Comprobamos el primer dia del mes
    $primerDiaMesTimestamp = date("w", mktime(0,0,0, $mes_form, 1, $anio_form));

    // Comprobamos el numero de huecos hasta el primer dia del mes
    $n_huecos = ($primerDiaMesTimestamp + 6) % 7;

    $nacionales = array("1/1", "6/1", "1/5", "15/8", "12/10", "1/11", "6/12", "8/12", "25/12"); 
    $locales = array("24/10", "8/9", "28/2", "17/4", "18/4");

?>

<!-- VISTA -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendario - Ficheros - Session</title>
<style>
    table {
        border-collapse: collapse;
        margin: auto;
    }

    th, td {
        border: 1px solid black;
        width: 40px;
        height: 40px;
        text-align: center;
    }

    .domingo { background: pink; }
    .nacionales { background: yellow; }
    .locales { background: lightgreen; }
    
    .tareas-container {
        margin: 20px auto;
        max-width: 800px;
    }
    
    .tareas-container ul {
        padding-left: 20px;
    }
    
    .tareas-container li {
        margin-bottom: 10px;
    }
</style>

</head>
<body>
    <form action="" method="post">
        <label for="">Año</label>
        <input type="number" name="anio"/></br>
        <label for="">Mes</label>
        <input type="number" name="mes"/></br>

        <button type="submit" name="enviar">Enviar</button>
        <button type="submit" name="cargarTareas">Cargar Tareas</button>
    </form>

    <h1>Calendario</h1>
    <h2>Año: <?php echo $anio_form?></h2>
    <h2>Mes: <?php echo $mes_form?></h2>

    <table>
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

            // Declaramos el contador para llevar un recuento de dias
            $contador = 0;

            echo "<tr>";
            // Añadimos los huecos al calendario
            for ($i=1; $i <= $n_huecos; $i++) { 
                echo "<td></td>";
            }

            // Añadimos los huecos a nuestro contador
            $contador += $n_huecos;

            // Añadimos los dias a su correspondiente espacio
            for ($j= 1; $j <= $numeroDiasMes; $j++) { 
                $contador++;

                $fecha = "$j/$mes_form";
                
                if($contador % 7 == 0) { 
                    echo '<td class="domingo">' . $j . '</td></tr><tr>'; 
                } else if(in_array($fecha, $locales)) {
                    echo '<td class="locales">' . $j . '</td>'; 
                } else if(in_array($fecha, $nacionales)) {
                    echo '<td class="nacionales">' . $j . '</td>'; 
                } else {
                    echo '<td><a href="tareas.php?fecha=' . $fecha . "/$anio_form" . '">' . $j . '</a></td>'; 
                }
            }

            // Cerrar la ultima fila
            echo "</tr>";
        ?>

    </table>

    <h1>Listado de Tareas</h1>
    <div class="tareas-container">
        <?php
        // Cargar tareas desde el archivo
        $tareasFichero = [];
        if (file_exists("tareas.txt")) {
            $lineas = file("tareas.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lineas as $linea) {
                $partes = explode(",", $linea);
                if (count($partes) >= 2) {
                    $fecha = trim($partes[0]);
                    $tarea = trim($partes[1]);
                    if (!isset($tareasFichero[$fecha])) {
                        $tareasFichero[$fecha] = [];
                    }
                    $tareasFichero[$fecha][] = $tarea;
                }
            }
        }

        // Combinar tareas del fichero con las de la sesión
        $todasLasTareas = $tareasFichero;
        if (isset($_SESSION["listaTareas"])) {
            foreach ($_SESSION["listaTareas"] as $fecha => $tareas) {
                if (!isset($todasLasTareas[$fecha])) {
                    $todasLasTareas[$fecha] = [];
                }
                foreach ($tareas as $tarea) {
                    if (!in_array($tarea, $todasLasTareas[$fecha])) {
                        $todasLasTareas[$fecha][] = $tarea;
                    }
                }
            }
        }

        // Mostrar tareas organizadas por fecha
        if (count($todasLasTareas) > 0) {
            echo "<ul>";
            ksort($todasLasTareas); // Ordenar por fecha
            foreach ($todasLasTareas as $fecha => $tareas) {
                echo "<li><strong>Fecha: $fecha</strong>";
                echo "<ul>";
                foreach ($tareas as $tarea) {
                    echo "<li>$tarea</li>";
                }
                echo "</ul></li>";
            }
            echo "</ul>";
        } else {
            echo "<p>No hay tareas disponibles</p>";
        }
        ?>
    </div>
</body>
</html>