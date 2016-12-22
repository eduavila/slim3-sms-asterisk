<?php

use App\Models\Contato;
use App\Models\Mensagem;
use App\Models\Campanha;
// DIC configuration
// 

setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Cuiaba');

$container = $app->getContainer();

// -----------------------------------------------------------------------------
// Service providers
// -----------------------------------------------------------------------------

// Flash messages
$container['flash'] = function(){
    return new Slim\Flash\Messages();
};

// Twig
$container['view'] = function($c){

    $settings = $c->get('settings');
    $view = new Slim\Views\Twig($settings['view']['template_path'], $settings['view']['twig']);

    // Add extensions
    $view->addExtension(new Slim\Views\TwigExtension($c->get('router'), $c->get('request')->getUri()));
    $view->addExtension(new Twig_Extension_Debug());
    // Extençao data 
    $view->addExtension(new Teraone\Twig\Extension\StrftimeExtension());
    //$view->getExtension('core')->setTimezone('America/Cuiaba');


    $env = $view->getEnvironment();
    $env->addGlobal('messages', $c->get('flash')->getMessages());
    $env->addGlobal('session', $_SESSION);

    //PATH BASE
    $env->addGlobal('path',$c->get('request')->getUri()->getPath());
    
    $env->addGlobal('tot_contatos',Contato::count());
    $env->addGlobal('tot_msg',Mensagem::count());
    $env->addGlobal('tot_campanhas',Campanha::count());

    $env->addFunction('replace', new Twig_Function_Function('replace'));

    return $view;
};



// Database 

$container['database'] = function($c){
    return new App\Database;
};

// -----------------------------------------------------------------------------
// Service factories
// -----------------------------------------------------------------------------

// monolog
$container['logger'] = function ($c) {

    $settings = $c->get('settings');
    $logger = new Monolog\Logger($settings['logger']['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['logger']['path'], Monolog\Logger::DEBUG));
    return $logger;

};

// -----------------------------------------------------------------------------
// Action factories
// -----------------------------------------------------------------------------

$container[App\Action\HomeAction::class] = function ($c) {
    return new App\Action\HomeAction($c->get('view'), $c->get('logger'));
};