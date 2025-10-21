<?php
namespace App\Models;

class Persona
{
    private $_nombre;
    private $_apellido1;
    private $_apellido2;

    public function __construct($nombre, $apellido1, $apellido2) {
        $this->_nombre = $nombre;
        $this->_apellido1 = $apellido1;
        $this->_apellido2 = $apellido2;
    }

    public function __destruct() {
        echo $this->_nombre . " destruido";
    }

    public function saluda() {
        echo "Hola Mundo<br>";
    }

    public function nombre() {
        return $this->_nombre . " " . $this->_apellido1 . " " . $this->_apellido2;
    }
}