<?php
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// Cargar el archivo .env
$dotenv = Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

// accedo a las variables de entorno
$host = $_ENV['DB_HOST'];
$user = $_ENV['DB_USER'];
$pass = $_ENV['DB_PASSWORD'];
$dbname = $_ENV['DB_NAME'];

function conectaDB($host, $user, $pass, $dbname){
    try {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";
        $db = new PDO($dsn, $user, $pass);

        $db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
        $db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, 'SET NAMES utf8');
        
        return $db;
    } catch (PDOException $e) {
        echo "Error conexión";
        exit();
    }
}

$db = conectaDB($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD'], $_ENV['DB_NAME']);

