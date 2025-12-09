<?php
    require_once("lib/functions.php");

    $db = conectaDB();

    echo "Listado mascotas<br>";
    $sql = "SELECT * FROM mascotas";
    $resultado = $db->query($sql);

    foreach($resultado as $row) {
        echo $row['nombre'] . "<br>";
    }

    echo "Insertando nuevas mascota<br>";

    $sql = "INSERT INTO MASCOTAS (nombre) VALUES ('Luna')";
    $db->query($sql);
    $sql = "INSERT INTO MASCOTAS (nombre) VALUES ('Ringo')";
    $db->query($sql);

    echo "Listado mascotas actualizado<br>";
    $sql = "SELECT * FROM mascotas";
    $resultado = $db->query($sql);

    foreach($resultado as $row) {
        echo $row['nombre'] . "<br>";
    }

    echo "Eliminando mascotas<br>";
    $sql = "DELETE FROM mascotas WHERE nombre = 'Ringo'";
    $db->query($sql);

    echo "Listado mascotas actualizado<br>";
    $sql = "SELECT * FROM mascotas";
    $resultado = $db->query($sql);

    foreach($resultado as $row) {
        echo $row['nombre'] . "<br>";
    }






