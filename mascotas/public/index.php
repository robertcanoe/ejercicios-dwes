<?php

// require_once '../app/Models/Persona.php';
// require_once '../app/Models/Perro.php';

require_once __DIR__ . '/../vendor/autoload.php';

use App\Models\Persona;
use App\Models\Perro;

$perro = new Perro("tana", "negro");
echo "Dame la pata";
$perro->darPata();
$perro->entrenar();
$perro->entrenar();
$perro->entrenar();
$perro->entrenar();
$perro->entrenar();
$perro->entrenar();
$perro->darPata();
$perro->darPata();

