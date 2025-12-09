<?php
    /**
     * 
     */


    require_once("lib/functions.php");
    require_once("lib/function.php"); // clearData()

    // Variables de control del formulario
    $procesaFormulario = false;
    $errores = null;

    // Conexión a la base de datos mediante una función definida en functions.php
    $db = conectaDB();

    // Verificamos si el formulario fue enviado
    if (isset($_POST["submit"])) {
        $procesaFormulario = true;
        
        // Verificamos que el nombre no esté vacío
        if (empty($_POST["name"])) {
            $procesaFormulario = false;
            $errores = "El nombre es obligatorio";
        }

        // Solo procesamos si no hay errores
        if ($procesaFormulario) {
            // Limpiamos el valor recibido desde el formulario para evitar inyecciones o caracteres no deseados
            $nombre = clearData($_POST["name"]);

        // Sentencia SQL para insertar el nombre de la mascota en la tabla "mascotas"
        // El signo de interrogación (?) se utiliza como marcador de posición para parámetros
        $sql = "INSERT INTO mascotas (nombre) VALUES (?)";

        // Preparamos la consulta para su ejecución segura
        $consulta = $db->prepare($sql);

        // Ejecutamos la consulta enviando el valor del nombre como parámetro
        $consulta->execute(array($nombre));

        // rowCount() devuelve el número de filas afectadas por la última sentencia SQL ejecutada
        $numeroRegistros = $consulta->rowCount();

        // Si se insertó al menos un registro (es decir, la mascota fue agregada correctamente)
        if ($numeroRegistros > 0) {
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        }
    }}

    // Consulta para obtener todas las mascotas
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
        <label for="name">Nombre mascota:</label>
        <input type="text" name="name" id="name">
        <input type="submit" name="submit" value="Enviar">
        <?php if (isset($_POST["submit"]) && !empty($errores)): ?>
            <span style="color: red; margin-left: 10px;"><?php echo $errores; ?></span>
        <?php endif; ?>
    </form>
    
    <div style="margin-top: 20px;">
        <h2>Listado de Mascotas</h2>
        <ul>
            <?php foreach ($mascotas as $mascota): ?>
                <li><?php echo htmlspecialchars($mascota['nombre']); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</body>
</html>
