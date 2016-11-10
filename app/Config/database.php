<?php

//Configuração banco de dados

$settings = array(
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'port'      => '8889',
    'database'  => 'sms_aste',
    'username'  => 'root',
    'password'  => 'root',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => ''
);

// Instancia configuranção
use Illuminate\Database\Capsule\Manager as Capsule;
$capsule = new Capsule;
$capsule->addConnection($settings);
$capsule->bootEloquent();