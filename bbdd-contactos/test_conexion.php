<?php
// Test simple de conexión MySQL
echo "<h2>Test de Conexión MySQL</h2>";

$servername = "localhost";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "<p style='color: green;'>✓ Conexión exitosa a MySQL</p>";
    
    // Mostrar versión de MySQL
    $stmt = $conn->query('SELECT VERSION()');
    $version = $stmt->fetchColumn();
    echo "<p>Versión de MySQL: $version</p>";
    
    // Mostrar bases de datos disponibles
    echo "<h3>Bases de datos disponibles:</h3>";
    $stmt = $conn->query('SHOW DATABASES');
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "- " . $row['Database'] . "<br>";
    }
    
} catch(PDOException $e) {
    echo "<p style='color: red;'>Error de conexión: " . $e->getMessage() . "</p>";
    echo "<p>Asegúrate de que XAMPP/LAMPP esté ejecutándose y MySQL esté activo.</p>";
}

$conn = null;
?>