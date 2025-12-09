<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test MySQL con PHP</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .container { max-width: 800px; }
        .success { color: green; }
        .error { color: red; }
        table { border-collapse: collapse; width: 100%; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .form-section { margin: 20px 0; padding: 20px; border: 1px solid #ccc; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Test de Conexión MySQL con PHP</h1>
        
        <?php
        // Configuración de la base de datos
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "test_contactos";

        try {
            // Crear conexión
            $conn = new PDO("mysql:host=$servername", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "<p class='success'>✓ Conexión exitosa a MySQL</p>";

            // Crear base de datos si no existe
            $conn->exec("CREATE DATABASE IF NOT EXISTS $dbname");
            echo "<p class='success'>✓ Base de datos '$dbname' creada/verificada</p>";

            // Seleccionar la base de datos
            $conn->exec("USE $dbname");

            // Crear tabla si no existe
            $sql = "CREATE TABLE IF NOT EXISTS contactos (
                id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                nombre VARCHAR(50) NOT NULL,
                email VARCHAR(50) NOT NULL,
                telefono VARCHAR(20),
                fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )";
            $conn->exec($sql);
            echo "<p class='success'>✓ Tabla 'contactos' creada/verificada</p>";

            // Insertar datos de ejemplo si la tabla está vacía
            $stmt = $conn->prepare("SELECT COUNT(*) FROM contactos");
            $stmt->execute();
            $count = $stmt->fetchColumn();

            if ($count == 0) {
                $sql = "INSERT INTO contactos (nombre, email, telefono) VALUES 
                        ('Juan Pérez', 'juan@email.com', '123456789'),
                        ('María García', 'maria@email.com', '987654321'),
                        ('Carlos López', 'carlos@email.com', '456789123')";
                $conn->exec($sql);
                echo "<p class='success'>✓ Datos de ejemplo insertados</p>";
            }

        } catch(PDOException $e) {
            echo "<p class='error'>Error: " . $e->getMessage() . "</p>";
            die();
        }
        ?>

        <!-- Formulario para agregar nuevos contactos -->
        <div class="form-section">
            <h3>Agregar Nuevo Contacto</h3>
            <form method="POST" action="">
                <p>
                    <label>Nombre: </label>
                    <input type="text" name="nombre" required>
                </p>
                <p>
                    <label>Email: </label>
                    <input type="email" name="email" required>
                </p>
                <p>
                    <label>Teléfono: </label>
                    <input type="tel" name="telefono">
                </p>
                <p>
                    <input type="submit" name="agregar" value="Agregar Contacto">
                </p>
            </form>
        </div>

        <?php
        // Procesar formulario de agregar contacto
        if (isset($_POST['agregar'])) {
            try {
                $stmt = $conn->prepare("INSERT INTO contactos (nombre, email, telefono) VALUES (?, ?, ?)");
                $stmt->execute([$_POST['nombre'], $_POST['email'], $_POST['telefono']]);
                echo "<p class='success'>✓ Contacto agregado exitosamente</p>";
            } catch(PDOException $e) {
                echo "<p class='error'>Error al agregar contacto: " . $e->getMessage() . "</p>";
            }
        }

        // Mostrar todos los contactos
        try {
            echo "<h3>Lista de Contactos</h3>";
            $stmt = $conn->prepare("SELECT * FROM contactos ORDER BY id DESC");
            $stmt->execute();
            $contactos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (count($contactos) > 0) {
                echo "<table>";
                echo "<tr><th>ID</th><th>Nombre</th><th>Email</th><th>Teléfono</th><th>Fecha Registro</th></tr>";
                
                foreach($contactos as $contacto) {
                    echo "<tr>";
                    echo "<td>" . $contacto['id'] . "</td>";
                    echo "<td>" . htmlspecialchars($contacto['nombre']) . "</td>";
                    echo "<td>" . htmlspecialchars($contacto['email']) . "</td>";
                    echo "<td>" . htmlspecialchars($contacto['telefono']) . "</td>";
                    echo "<td>" . $contacto['fecha_registro'] . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "<p>No hay contactos en la base de datos.</p>";
            }

        } catch(PDOException $e) {
            echo "<p class='error'>Error al consultar contactos: " . $e->getMessage() . "</p>";
        }

        // Cerrar conexión
        $conn = null;
        ?>

        <div class="form-section">
            <h3>Información del Sistema</h3>
            <p><strong>Servidor:</strong> <?php echo $servername; ?></p>
            <p><strong>Base de datos:</strong> <?php echo $dbname; ?></p>
            <p><strong>Versión PHP:</strong> <?php echo phpversion(); ?></p>
        </div>
    </div>
</body>
</html>