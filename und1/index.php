<?php
/**
 * @author Roberto Cano Estévez
 * @date 16/06/2025
 */

$number = 23;


if ($number > 0 || $number = 0) {
  $mensaje = "<h1>El número: $number es positivo/cero</h1>";
} else {
  $mensaje = "<h1>El número: $number es negativo</h1>";
}

?>

<!-- vista -->
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Número positivo o negativo</title>
</head>
<body>
  <?php echo $mensaje; ?>
</body>
</html>