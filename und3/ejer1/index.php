<?php
/* 
    * Ejercicio 5
    * Crear un script para sumar una serie de números. El número de números a sumar
    será introducido en un formulario.
    * @author: Roberto Cano Estévez
*/
include('lib/functions.php');

// Declaración de variable

$cantidad = 0;
$mostrarSuma = false;
$mostrarResultado = false;
$resultado = 0;
$n = [];

// Recuperación de datos

if (isset($_POST["enviar"])){
    $cantidad = clearData($_POST["cantidad"]);
    $mostrarSuma = true;
} 

if (isset($_POST["sumar"])){
    $cantidad = clearData($_POST["cantidad"]);
    $n = $_POST["n"];
    $mostrarSuma = true;
    $mostrarResultado = true;
    foreach ($n as $numero) {
    $resultado += $numero;
}

}

?>



<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario</title>
</head>
<body>
    <form action="" method="post">
        Cantidad de Numeros a sumar:
        <input type="text" name="cantidad" value="2"><br>

        <button type="submit" name="enviar">Enviar</button>
    </form>

    <?php
    if ($mostrarSuma){
        echo'<form action="" method="post">';
        echo'<input type="hidden" name="cantidad" value="' . $cantidad . '"/>';
            for ($i=0; $i < $cantidad; $i++) {
                echo "Numero: " . ($i+1);
                $valor = isset($n[$i]) ? $n[$i] : '';
                echo'<input type="number" name="n[]" value="' . $valor . '"/><br/>'; 
            }
        echo '<button type="submit" name="sumar">Sumar</button>';
        echo'</form>';
       
    }
     if ($mostrarResultado){
            echo "Resultado: " . $resultado;
        }
    ?>
</body>
</html>