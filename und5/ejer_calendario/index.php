<?php 

    include("./lib/function.php");
    session_start();


    if (!isset($_SESSION['tareas'])) {
        $file = "data/tareas.txt";
        if (file_exists($file)) {
            $_SESSION['tareas'] = json_decode(file_get_contents($file), true);
        } else {
            $_SESSION['tareas'] = [];
        }
    }

    // Declaramos las variables
    $anio_form = date("Y");
    $mes_form = date("m");
    $listatareas = [];
    
    // Inicializar la variable de sesión si no existe
    if (!isset($_SESSION["listaTareas"])) {
        $_SESSION["listaTareas"] = [];
    }
    
    // Inicializar variable para la fecha seleccionada
    $fechaSeleccionada = "";
    if (isset($_GET["fecha"])) {
        $fechaSeleccionada = clearData($_GET["fecha"]);
    }

    if (isset($_POST["enviar"])) {
        if($_POST["anio"] != "" && $_POST["mes"] != "") {
            $anio_form = clearData($_POST["anio"]);
            $mes_form = clearData($_POST["mes"]);
            // Resetear la fecha seleccionada al cambiar de mes/año
            $fechaSeleccionada = "";
        }
    }
    
    // Procesar el formulario para añadir tareas
    if (isset($_POST["añadirTarea"])) {
        if(isset($_POST["fecha"]) && isset($_POST["tarea"]) && $_POST["tarea"] != "") {
            $fecha = clearData($_POST["fecha"]);
            $tarea = clearData($_POST["tarea"]);
            
            // Inicializar el array de tareas para esta fecha si no existe
            if (!isset($_SESSION["listaTareas"][$fecha])) {
                $_SESSION["listaTareas"][$fecha] = [];
            }
            
            // Añadir la tarea a la sesión
            $_SESSION["listaTareas"][$fecha][] = $tarea;
            
            // También añadir la tarea directamente al archivo
            $f = fopen("data/tareas.txt", "a");
            fwrite($f, "$fecha,$tarea\n");
            fclose($f);
        }
    }
    
    // Procesar la eliminación de tareas para una fecha específica
    if (isset($_POST["eliminarTareas"]) && isset($_POST["fecha"])) {
        $fecha = clearData($_POST["fecha"]);
        
        // Eliminar de la sesión
        if (isset($_SESSION["listaTareas"][$fecha])) {
            unset($_SESSION["listaTareas"][$fecha]);
        }
        
        // Actualizar el archivo de tareas (eliminar las tareas de esa fecha)
        if (file_exists("data/tareas.txt")) {
            $lineas = file("data/tareas.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $f = fopen("data/tareas.txt", "w");
            foreach ($lineas as $linea) {
                $partes = explode(",", $linea);
                if (count($partes) >= 2 && trim($partes[0]) != $fecha) {
                    fwrite($f, $linea . "\n");
                }
            }
            fclose($f);
        }
    }

    if (isset($_POST["cargarTareas"])) {
        $listatareas = $_SESSION["listaTareas"];

        // Añadir a un fichero
        $f = fopen("data/tareas.txt", "a");
        foreach ($_SESSION["listaTareas"] as $fechaSesion => $tareas) {
            foreach ($tareas as $tarea) {
                fwrite($f, "$fechaSesion,$tarea\n");
            }
        }
        fclose($f);
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
                    $fechaCompleta = $fecha . "/$anio_form";
                    $claseSeleccionada = ($fechaSeleccionada == $fechaCompleta) ? 'style="background-color: #e0e0ff;"' : '';
                    echo '<td ' . $claseSeleccionada . '><a href="index.php?fecha=' . $fechaCompleta . '">' . $j . '</a></td>'; 
                }
            }

            // Cerrar la ultima fila
            echo "</tr>";
        ?>

    </table>

    <h1>Gestión de Tareas</h1>
    
    <?php if ($fechaSeleccionada != ""): ?>
    <!-- Formulario para añadir tareas -->
    <div class="form-container">
        <h3>Añadir Nueva Tarea para <?php echo $fechaSeleccionada; ?></h3>
        <form action="" method="post">
            <div>
                <label for="tarea" >Título de la tarea:</label>
                <input type="text" name="tarea" id="tarea" required>
                <input type="hidden" name="fecha" value="<?php echo $fechaSeleccionada; ?>">
            </div>
            <div>
                <button type="submit" name="añadirTarea" >Añadir Tarea</button>
                <a href="index.php">Cancelar</a>
            </div>
        </form>
    </div>
    <?php else: ?>
    <?php endif; ?>
    
<!-- Formulario para eliminar tareas de una fecha 
    <div class="form-container">
        <h3>Eliminar Tareas por Fecha</h3>
        <form action="" method="post">
            <div class="form-group">
                <label for="fecha-eliminar">Fecha (formato: DD/MM/AAAA):</label>
                <input type="text" name="fecha" id="fecha-eliminar" placeholder="Ejemplo: 15/10/2025" required>
            </div>
            <div class="form-group">
                <button type="submit" name="eliminarTareas">Eliminar Todas las Tareas de esta Fecha</button>
            </div>
        </form>
    </div> -->
    
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