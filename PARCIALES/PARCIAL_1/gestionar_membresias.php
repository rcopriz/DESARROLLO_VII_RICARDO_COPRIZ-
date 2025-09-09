<?php
    include 'funciones_gimnasio.php';

    $membresias = [ 'basica' => 80, 
    'premium' => 120,
    'vip' =>180 ,
    'familiar' => 250,
    'corporativa' => 300];
    $miembros = ['Juan Perez' => ['tipo' => 'premium', 'antiguedad' => 15],
                'Ana García' =>  ['tipo' => 'basica', 'antiguedad' => 2],
                'Carlos López' => ['tipo' => 'vip', 'antiguedad' => 30],
                'Maria Rodriguez' => ['tipo' => 'familiar', 'antiguedad' => 8],
                'Luis Martinez' => ['tipo' => 'corporativa', 'antiguedad' => 18]
    ];
    foreach ($miembros as $miembro)
    {
        print($miembro['tipo']);
        
    }
?>