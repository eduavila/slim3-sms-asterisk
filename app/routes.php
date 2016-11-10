<?php
// Routes

//DashBoar 
$app->get('/','App\Controllers\DashboardController:index')->setName('index');

//$app->get('/','App\Controllers\MensagemController:index')->setName('index');

$app->get('/mensagens','App\Controllers\MensagemController:mensagens')->setName('mensagens');

$app->get('/mensagens/{numero}/list','App\Controllers\MensagemController:buscarMensagens');
$app->get('/mensagens/{numero}','App\Controllers\MensagemController:detalheMensagens')->setName('detalhe_mensagens');



// Contatos
$app->get('/contatos','App\Controllers\ContatoController:index')->setName('contatos');

//$app->get('/contatos/novo','App\Controllers\ContatoController:novo')->setName('contatos_novo');

$app->get('/contatos/{contato}/edit','App\Controllers\ContatoController:editar')->setName('contatos_edit');

$app->post('/contatos/{contato}/update','App\Controllers\ContatoController:update')->setName('contatos_update');


// Mensagens
$app->post('/mensagens/{numero}/enviar','App\Controllers\MensagemController:enviarMensagem')->setName('envio_msg_rapida');