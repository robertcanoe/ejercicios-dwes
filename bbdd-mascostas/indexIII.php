<?php
    require_once("lib/functions.php");
    require_once("lib/function.php"); 

    // variables de control del formulario
    $procesaFormulario = false;
    $errores = null;

    // conexion a la bbdd
    $db = conectaDB($host, $user, $pass, $dbname);

    // verificamos si el formulario fue enviado
    if (isset($_POST["submit"])) {
        $procesaFormulario = true;
        
        // verificamos campos obligatorios
        if (empty($_POST["name"])) {
            $procesaFormulario = false;
            $errores = "El nombre es obligatorio";
        } elseif (empty($_POST["fecha_nacimiento"])) {
            $procesaFormulario = false;
            $errores = "La fecha de nacimiento es obligatoria";
        }

        // solo procesamos si no hay errores
        if ($procesaFormulario) {
            // limpiamos los valores
            $nombre = clearData($_POST["name"]);
            $fecha_nacimiento = clearData($_POST["fecha_nacimiento"]);
            $raza = !empty($_POST["raza"]) ? clearData($_POST["raza"]) : null;

            // SQL con parámetros
            $sql = "INSERT INTO mascotas (nombre, fecha_nacimiento, raza) VALUES (?, ?, ?)";
            $consulta = $db->prepare($sql);
            $consulta->execute(array($nombre, $fecha_nacimiento, $raza));

            if ($consulta->rowCount() > 0) {
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }
        }
    }

    // Consulta para obtener todas las mascotas ordenadas por nombre
    $sql = "SELECT * FROM mascotas";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $mascotas = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Mascota</title>
</head>
<body>
    <form action="" method="post">
        <div style="margin-bottom: 10px;">
            <label for="name">Nombre mascota:</label>
            <input type="text" name="name" id="name" 
                   value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
        </div>
        
        <div style="margin-bottom: 10px;">
            <label for="fecha_nacimiento">Fecha de nacimiento:</label>
            <input type="date" name="fecha_nacimiento" id="fecha_nacimiento"
                   value="<?php echo isset($_POST['fecha_nacimiento']) ? htmlspecialchars($_POST['fecha_nacimiento']) : ''; ?>">
        </div>
        
        <div style="margin-bottom: 10px;">
            <label for="raza">Raza (opcional):</label>
            <input type="text" name="raza" id="raza"
                   value="<?php echo isset($_POST['raza']) ? htmlspecialchars($_POST['raza']) : ''; ?>">
        </div>

        <input type="submit" name="submit" value="Enviar">
        <?php if (isset($_POST["submit"]) && !empty($errores)): ?>
            <span style="color: red; margin-left: 10px;"><?php echo $errores; ?></span>
        <?php endif; ?>
    </form>
    
    <div style="margin-top: 20px;">
        <h2>Listado de Mascotas</h2>
        <ul>
            <?php foreach ($mascotas as $mascota): ?>
                <li>
                    <?php 
                        echo htmlspecialchars($mascota['nombre']) . 
                             " - Nacimiento: " . htmlspecialchars($mascota['fecha_nacimiento']) .
                             ($mascota['raza'] ? " - Raza: " . htmlspecialchars($mascota['raza']) : "");
                    ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
