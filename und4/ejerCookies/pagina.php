<?php

    session_start();


    echo "Pagina Web<br>";
    echo "Contador Sesion: " . $_SESSION["contador"];
    $_SESSION["contador"]++;

?>

<a href="eje_20.php">Volver</a>