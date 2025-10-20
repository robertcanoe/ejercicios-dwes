<?php
/* 
    * Ejercicio 5
    * Crear un script para sumar una serie de números. El número de números a sumar
    será introducido en un formulario.
    * @author: Roberto Cano Estévez
*/
?>



<!DOCTYPE html>
<html>
<head>
    <title>Sumador de Números</title>
</head>
<body>
    <h1>Sumador de Números</h1>
    
    <?php
    if (isset($_POST['sumar']) && isset($_POST['numeros'])) {
        // Calcular la suma
        $numeros = $_POST['numeros'];
        $suma = 0;
        
        echo "<h2>Resultado:</h2>";
        echo "Números: ";
        foreach ($numeros as $numero) {
            echo $numero . " ";
            $suma += $numero;
        }
        echo "<br><br>";
        echo "<strong>Suma total: $suma</strong>";
        echo "<br><br>";
        echo '<a href="index.php">Nueva suma</a>';
        
    } elseif (isset($_POST['cantidad'])) {
        // Mostrar formulario para introducir números
        $cantidad = (int)$_POST['cantidad'];
        echo "<h2>Introduce $cantidad números:</h2>";
        echo '<form method="post">';
        echo '<input type="hidden" name="sumar" value="1">';
        
        for ($i = 1; $i <= $cantidad; $i++) {
            echo "Número $i: <input type='number' name='numeros[]' required><br><br>";
        }
        
        echo '<input type="submit" value="Calcular Suma">';
        echo '</form>';
        
    } else {
        // Formulario inicial
        echo '<form method="post">';
        echo '¿Cuántos números quieres sumar? ';
        echo '<input type="number" name="cantidad" min="1" required><br><br>';
        echo '<input type="submit" value="Continuar">';
        echo '</form>';
    }
    ?>
</body>
</html>