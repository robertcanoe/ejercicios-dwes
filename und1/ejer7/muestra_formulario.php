<?php
/**
* Ejercicio Practicas
* Muestra nuestro formulario
* @author Roberto Cano
*/

include("config/config.php");
?>

<?php

$procesaFormulario = false;
$message = "";

// Declaramos variables de error

$nameError = $emailError = $grupoError = "";

// Declaramos variables iniciales
$name = "";
$email = "";
$grupo = "";
$intereses = array();



// Determinamos si se pulso "SUBMIT en el formulario"
if (isset($_POST["enviar"])) {
    $procesaFormulario = true;
    $name = $_POST["nombre"];
    $email = $_POST["email"];
    $grupo = $_POST["grupo"];
    
    // validamos los datos del formulario
    if (empty($name)) { 
        $procesaFormulario = false;
        $nameError = "El nombre no puede estar vacido";

    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $procesaFormulario = false;
        $emailError = "Formato de email incorrecto";
    }
    if (empty($grupo)) {
        $procesaFormulario = false;
        $grupoError = "Debe seleccionar un grupo";
    }
}


if (isset($_GET["error"])) {
    $message = $_GET["error"];
}
?>



<!-- vista -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ejemplo 16</title>
</head>
<body>
 
    <?php
    if (!$procesaFormulario) {
    }
    else {

    }

    
    ?>
    <form action="" method="post">

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="<?php echo $name; ?>"><span class="error"><?php echo $nameError; ?></span>

        <label for="nombre">Email:</label>
        <input type="text" name="email" value="<?php echo $email; ?>"><span class="error"><?php echo $emailError; ?></span>

        <br>
        Selecciona curso:
        <br>
       <?php foreach ($aData as $key => $value) {
        echo "<input type='radio' name='grupo' value='$key' checked> $value<br>";
    } 
    ?>
        <br>
        <input type="submit" name= "enviar" value="Enviar">
        </form>

    <br> <?php echo $message?> 
</body>
</html>