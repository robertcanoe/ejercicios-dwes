<?php
// Ejemplo simple de CRUD con MySQL
$servername = "localhost";
$username = "root"; 
$password = "";
$dbname = "test_contactos";

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "<h2>Operaciones CRUD - MySQL con PHP</h2>";
    
    // CREATE - Insertar datos
    echo "<h3>1. CREATE (Insertar)</h3>";
    $sql = "INSERT INTO contactos (nombre, email, telefono) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $resultado = $stmt->execute(['Ana Martín', 'ana@test.com', '111222333']);
    
    if ($resultado) {
        echo "<p style='color: green;'>✓ Contacto insertado exitosamente</p>";
    }
    
    // READ - Leer datos
    echo "<h3>2. READ (Leer)</h3>";
    $sql = "SELECT * FROM contactos LIMIT 5";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $contactos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table border='1' style='border-collapse: collapse;'>";
    echo "<tr><th>ID</th><th>Nombre</th><th>Email</th><th>Teléfono</th></tr>";
    foreach($contactos as $contacto) {
        echo "<tr>";
        echo "<td>" . $contacto['id'] . "</td>";
        echo "<td>" . $contacto['nombre'] . "</td>";
        echo "<td>" . $contacto['email'] . "</td>";
        echo "<td>" . $contacto['telefono'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // UPDATE - Actualizar datos
    echo "<h3>3. UPDATE (Actualizar)</h3>";
    $sql = "UPDATE contactos SET telefono = ? WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $resultado = $stmt->execute(['999888777', 'ana@test.com']);
    
    if ($resultado) {
        echo "<p style='color: green;'>✓ Contacto actualizado</p>";
    }
    
    // COUNT - Contar registros
    echo "<h3>4. Estadísticas</h3>";
    $sql = "SELECT COUNT(*) as total FROM contactos";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $total = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<p>Total de contactos: " . $total['total'] . "</p>";
    
    // DELETE (opcional - comentado para no borrar datos)
    /*
    echo "<h3>5. DELETE (Eliminar)</h3>";
    $sql = "DELETE FROM contactos WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $resultado = $stmt->execute(['ana@test.com']);
    
    if ($resultado) {
        echo "<p style='color: green;'>✓ Contacto eliminado</p>";
    }
    */
    
} catch(PDOException $e) {
    echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
}

$pdo = null;
?>

<p><a href="index.php">← Volver al inicio</a></p>