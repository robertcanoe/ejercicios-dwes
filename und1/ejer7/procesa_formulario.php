<?php
/**
* Ejercicio Practicas
* Procesa nuestro formulario
* @author Roberto Cano
*/

/* comprobamos que se dan las condiciones para ejecutar el script

 
    1. A traves del botón de envio.
    2. Permisos de usuario.
    3. Control de seguridad

Recojo la ip de quien ejecuta: yyy
Recojo la ip del formulario: xxx
    

*/

// incluimos libreria

include("lib/functions.php");

$error = "";

if (!isset($_POST["enviar"])) {
    header("Location: muestra_formulario.php");
    exit();
}; 


// cargamos en variables los datos que llegan del formulario

$nombre = clearData($_POST["nombre"]);
$curso = clearData($_POST["curso"]);
$email = clearData($_POST["email"]);




if (empty($nombre)){
    $message = "El nombre no puede estar vacido";
    $error = true;
};

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $message = "Formato de email incorrecto";
    $error = true;
}

if ($error){
    header("Location: muestra_formulario.php?error=$message");
}else{
    echo $nombre;
    echo '<br/>';
    echo $email;
    echo '<br/>';
    echo $curso;
}
