<?php
// Routes

//DashBoar 
$app->get('/','App\Controllers\DashboardController:index')->setName('index');

$app->get('/teste2','App\Controllers\DashboardController:teste');

$app->get('/mensagens/enviar','App\Controllers\MensagemController:enviar')->setName('envioMensagem');

$app->post('/mensagens/enviar','App\Controllers\MensagemController:enviarRapido')->setName('enviarMensagemRapida');

$app->get('/mensagens','App\Controllers\MensagemController:index')->setName('mensagens');


$app->get('/mensagens/{numero}/list','App\Controllers\MensagemController:buscarMensagens');

$app->get('/mensagens/{numero}','App\Controllers\MensagemController:detalheMensagens')->setName('detalhe_mensagens');


// Contatos
$app->get('/contatos','App\Controllers\ContatoController:index')->setName('contatos');

$app->get('/contatos/novo','App\Controllers\ContatoController:novo')->setName('contatos_novo');

$app->get('/contatos/{contato}/editar','App\Controllers\ContatoController:editar')->setName('contatos_edit');

$app->post('/contatos/{contato}/atualizar','App\Controllers\ContatoController:update')->setName('contatos_update');

// Mensagens
$app->post('/mensagens/{numero}/enviar','App\Controllers\MensagemController:enviarMensagem')->setName('envio_msg_rapida');

// Campanhas
$app->get('/campanhas','App\Controllers\CampanhaController:index')->setName('campanhas');
$app->get('/campanhas/nova','App\Controllers\CampanhaController:novo')->setName('campanhas_nova');



// Canais / Channel.
$app->get('/canais','App\Controllers\ChannelController:index')->setName('channels');
$app->get('/canais/json','App\Controllers\ChannelController:getListChannel');