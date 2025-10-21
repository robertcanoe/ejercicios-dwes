<?php

if (!isset($_SESSION['tareas'])) {
    header('location: index.php');
    exit;
}

session_start();
$tareas = $_SESSION['tareas'];
$file = 'data/tareas.txt';
file_put_contents($file, json_encode($tareas));
session_unset();
session_destroy();
header('location: index.php');
exit;