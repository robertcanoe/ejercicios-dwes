<?php
// session_start();
// if (isset($_GET["fecha"])) {
//     $fecha = $_GET["fecha"];
//     if (isset($_SESSION["listaTareas"][$fecha])) {
//         unset($_SESSION["listaTareas"][$fecha]);
//     }
// }
// header("location: index.php");
// exit();


session_start();


$id = $_GET['id'];
unset($_SESSION['listaTareas'][$id]['fecha']);