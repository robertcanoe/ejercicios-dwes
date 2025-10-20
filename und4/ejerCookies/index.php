<?php 
    /**
     * Manejo de cookies.
     * @author Roberto Cano Estévez
     * @date 06/10/2025
     */

    include("./lib/functions.php");

    // Declaracion de variables
    $user = "";
    $pass = "";
    $save = "";
    $msgSalida = "Credenciales incorrectas.";
    $procesaFormulario = false;
    session_start();

    if(!isset($_SESSION["contador"])){
        $_SESSION["contador"] = 0;
    }
    
    $contadorLocal = 0;
    $contadorSesion = $_SESSION["contador"];

    if(isset($_COOKIE["ckuser"])) {
        $user = $_COOKIE["ckuser"];
        $pass = $_COOKIE["ckpass"];
    }

    if(isset($_POST["send"])) {
        $procesaFormulario = true;

        $user = clearData($_POST["user"]);
        $pass = clearData($_POST["pass"]);
        $save = clearData($_POST["save"]);

        if($user == "admin" && $pass == "admin") {
            $msgSalida = "Credenciales correctas.";

            if($save == "save"){
                setcookie("ckuser", $user, time() + 24*60*60);
                setcookie("ckpass", $pass, time() + 24*60*60);
            }
        }

    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php
        if($procesaFormulario) {
            echo $msgSalida;
        }
    ?>

    <a href="pagina.php">Pagina</a>
    <p>Contador Local: <?php echo $contadorLocal; ?></p>
    <p>Contador Sesion: <?php echo $contadorSesion; ?></p>
    <form action="" method="post">
        <label for="">Usuario</label>
        <input type="text" name="user" value="<?php echo $user ?>"><br>

        <label for="">Contraseña</label>
        <input type="password" name="pass" value="<?php echo $pass ?>"><br>

        <label for="">Recordar credenciales</label>
        <input type="checkbox" name="save" value="save"><br>

        <button type="submit" name="send">Enviar</button>
    </form>

    
</body>
</html>