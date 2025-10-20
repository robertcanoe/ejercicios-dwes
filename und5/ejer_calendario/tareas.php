<?php
    include("./lib/function.php");
    session_start();

    $fecha = "";

    if (isset($_GET["fecha"])) {
        $fecha = clearData($_GET["fecha"]);
    }

    if (!isset($_SESSION["listaTareas"])) {
        $_SESSION["listaTareas"] = [];
    }

    if (!isset($_SESSION["listaTareas"][$fecha])) {
        $_SESSION["listaTareas"][$fecha] = [];
    }

    if(isset($_POST["añadirTarea"])) {
        if(isset($_POST["tarea"])) {
            $_SESSION["listaTareas"][$fecha][] = clearData($_POST["tarea"]);
        }
    }

    if(isset($_POST["eliminarTareas"])) {
        $_SESSION["listaTareas"][$fecha] = [];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tareas</title>
    <style>
        a {
            text-decoration: none;
            color: black;
        }
    </style>
</head>
<body>
    <h1>Fecha seleccionada: <?php echo $fecha ?> </h1>

    <form action="" method="post">
        <label for="titulo">Título de la tarea:</label>
        <input type="text" name="tarea">
        <button type="submit" name="añadirTarea">Añadir Tareas</button>
        <button type="submit" name="eliminarTareas">Eliminar Tareas</button>
    </form>

    <?php
    
        echo "<h2>Tareas para la fecha $fecha</h2>";
        if(count($_SESSION["listaTareas"][$fecha]) > 0) {
            foreach ($_SESSION["listaTareas"][$fecha] as $key => $tarea) {
                echo "<h3>$key - $tarea</h3>";
            }
        }
    ?>
    
    <a href="index.php">Volver</a>
</body>
</html>