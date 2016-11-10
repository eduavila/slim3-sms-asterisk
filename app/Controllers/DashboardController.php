<?php
namespace App\Controllers;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

use Slim\Slim as Slim;

use App\Models\Canal;
use App\Models\Contato;
use App\Models\Mensagem;


class DashboardController
{
    protected $app;

    public function __construct($app){
        $this->app = $app;
    }

    public function index(Request $request, Response $response, $args)
    {   
        return $this->app->view->render($response, 'dashboard.twig');
    }
}