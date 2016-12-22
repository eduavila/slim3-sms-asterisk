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

use App\Sms\DongleCommand;
use App\Sms\Queue;

class DashboardController
{
    protected $app;

    public function __construct($app){
        $this->app = $app;
    }

    public function index(Request $request, Response $response, $args)
    {   
    	$totEnviadas = Mensagem::where('status','e')->count();
    	$totRecebidas = Mensagem::where('status','r')->count();
    	$totContatos = Contato::count();

        $messagens = Mensagem::where('tipo_envio','RAPIDA')->orderBy('data','desc')->orderBy('hora','desc')->limit(5)->get();

        return $this->app->view->render($response, 'dashboard.twig',[
        										'totEnviadas'=>$totEnviadas,
        										'totRecebidas'=>$totRecebidas,
        										'totContatos'=>$totContatos,
        										'messagens'=>$messagens]);
    }
}