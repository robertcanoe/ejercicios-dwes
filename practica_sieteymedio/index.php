<?php

require_once __DIR__ . '/lib/function.php';
session_start();
if (!isset($_SESSION['mazo'])) {
    $_SESSION['mazo'] = inicializarMazo();
    $_SESSION['jugador_cartas'] = [];
    $_SESSION['maquina_cartas'] = [];
    $_SESSION['juego_terminado'] = false;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$_SESSION['juego_terminado']) {
    if (isset($_POST['pedir_carta'])) {
        $carta = array_pop($_SESSION['mazo']);
        $_SESSION['jugador_cartas'][] = $carta;
        $puntos_jugador = calcularPuntos($_SESSION['jugador_cartas']);
        if ($puntos_jugador > 7.5) {
            $_SESSION['juego_terminado'] = true;
        }
    } elseif (isset($_POST['plantarse'])) {
        $_SESSION['juego_terminado'] = true;
        while (calcularPuntos($_SESSION['maquina_cartas']) < 5.5) {
            $carta = array_pop($_SESSION['mazo']);
            $_SESSION['maquina_cartas'][] = $carta;
        }
    }
}

$puntos_jugador = calcularPuntos($_SESSION['jugador_cartas']);
$puntos_maquina = calcularPuntos($_SESSION['maquina_cartas']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Juego 7 y Medio</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Juego 7 y Medio</h1>
    <div class="cartas">
        <h2>Jugador (Puntos: <?php echo $puntos_jugador; ?>)</h2>
        <div class="mano">
            <?php foreach ($_SESSION['jugador_cartas'] as $carta): ?>
                <img src="<?php echo $carta['imagen']; ?>" alt="Carta">
            <?php endforeach; ?>
        </div>
    </div>
    <div class="cartas">
        <h2>Máquina (Puntos: <?php echo $_SESSION['juego_terminado'] ? $puntos_maquina : '0'; ?>)</h2>
        <div class="mano">
            <?php if ($_SESSION['juego_terminado']): ?>
                <?php foreach ($_SESSION['maquina_cartas'] as $carta): ?>
                    <img src="<?php echo $carta['imagen']; ?>" alt="Carta">
                <?php endforeach; ?>
            <?php else: ?>
                <img src="img/reverso.jpg" alt="Carta Oculta">
            <?php endif; ?>
        </div>
    </div>
    <?php if (!$_SESSION['juego_terminado']): ?>
        <form method="POST">
            <button type="submit" name="pedir_carta">Pedir Carta</button>
            <button type="submit" name="plantarse">Plantarse</button>
        </form>
    <?php else: ?>
        <h2>
            <?php
            if ($puntos_jugador > 7.5) {
                echo "Has perdido. Te has pasado de 7.5 puntos.";
            } elseif ($puntos_maquina > 7.5 || $puntos_jugador > $puntos_maquina) {
                echo "¡Has ganado!";
            } elseif ($puntos_jugador < $puntos_maquina) {
                echo "Has perdido.";
            } else {
                echo "Empate.";
            }
            ?>
        </h2>
        <a href="cierre_sesion.php">Jugar de nuevo</a>
    <?php endif; ?>
</body>
</html>