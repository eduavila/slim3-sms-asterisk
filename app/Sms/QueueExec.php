<?php

date_default_timezone_set('America/Cuiaba');

echo "Exetando Queue: ".date('H:i:s');
// Carrega class disponivel no projeto.
require __DIR__ . '/../../vendor/autoload.php';

use App\Sms\Queue;


# === Chama base de dados....
# ==================================================
require __DIR__ .'/../../app/Config/database.php';


// Executa fila de sms.
$Tasks = new Queue();
$Tasks->run();

