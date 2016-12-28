<?php

date_default_timezone_set('America/Cuiaba');

echo "Executando Queue: ".date('H:i:s')."\n";

// Carrega class disponivel no projeto.
require __DIR__ . '/../../vendor/autoload.php';

use App\Sms\Queue;


# === Chama base de dados....
# ==================================================
require __DIR__ .'/../../app/Config/database.php';


// Executa fila de sms.
$Tasks = new Queue();
$Tasks->run();

