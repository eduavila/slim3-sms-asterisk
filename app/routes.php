<?php
// Routes

//DashBoar 
$app->get('/','App\Controllers\DashboardController:index')->setName('index');

$app->get('/mensagens/enviar','App\Controllers\MensagemController:enviar')->setName('envioMensagem');

$app->post('/mensagens/enviar','App\Controllers\MensagemController:enviarRapido')->setName('enviarMensagemRapida');

$app->get('/mensagens','App\Controllers\MensagemController:index')->setName('mensagens');

//Busca sms json.
$app->get('/mensagens/{numero}/json','App\Controllers\MensagemController:buscarMensagens');

//Enviar sms.
$app->post('/mensagens/{numero}/json','App\Controllers\MensagemController:enviarMensagem');

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
$app->post('/campanhas/nova','App\Controllers\CampanhaController:salvar')->setName('campanhas_salvar');
$app->get('/campanhas/{campanha}/detalhe','App\Controllers\CampanhaController:detalhe')->setName('campanhas_detalhe');

// Canais / Channel.
$app->get('/canais','App\Controllers\ChannelController:index')->setName('channels');
$app->get('/canais/json','App\Controllers\ChannelController:getListChannel');