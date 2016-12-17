<?php

use App\Models\Contato;
use App\Models\Mensagem;
// DIC configuration
// 

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

    $env = $view->getEnvironment();
    $env->addGlobal('messages', $c->get('flash')->getMessages());
    $env->addGlobal('session', $_SESSION);

    //PATH BASE
    $env->addGlobal('path',$c->get('request')->getUri()->getPath());
    
    $env->addGlobal('tot_contatos',Contato::count());
    $env->addGlobal('tot_msg',Mensagem::count());
    
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




//
date_default_timezone_set('America/Cuiaba');