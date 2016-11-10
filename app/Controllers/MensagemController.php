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


class MensagemController
{

    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }


    public function index(Request $request, Response $response, $args)
    {   
        $canais= Canal::all();
        return $this->app->view->render($response, 'envio.twig',['canais'=>$canais]);
    }

    public function mensagens(Request $request, Response $response, $args)
    {   
        $mensagens = Mensagem::groupBy('numero')->get();

        return $this->app->view->render($response, 'lista_msg.twig',['mensagens'=>$mensagens]);
    }


    // Rederiza pagina com detalhes da mensagens.
    public function detalheMensagens(Request $request, Response $response, $args)
    { 
        $canais= Canal::all();

        $numero = trim($args['numero']);

        return $this->app
        			->view
        			->render($response, 
        				'detalhe_msg.twig',
        					[
        						'canais'=>$canais,
        						'numero'=>$numero
        						]);
    }


    // Busca messanges retornando um array json.

    public function buscarMensagens(Request $request,Response $response,$args)
    {
        $limit = 10;
        $offset = $request->getQueryParam('offset');

        $numero = $args['numero'];

        $mensagens = Mensagem::where('numero','=',$numero)->get();

        return json_encode($mensagens);
    }

    public function enviarMensagem(Request $request, Response $response, $args)
    {
        $numero = $request->getAttribute('numero');

        $allPostVars =  $request->getParsedBody();

        
        return  $response->withJson($allPostVars);
    }


    public function verificaNovasMessagem(Request $request,Response $response, $args)
    {
    	$numero = $request->getAttribute('utimamessagem');
    }
}
