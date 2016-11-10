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


class ContatoController
{

    protected $app;

    public function __construct($app){
        $this->app = $app;
    }

    public function index(Request $request, Response $response, $args)
    {   
        // $basePath = $request->getUri()->path('');

        // $contatos = Contato::all();

        // $messages = $this->app->flash->getMessages();

        // return $this->app->view->render($response, 'contatos/contatos.twig',
        //                 [
        //                     'contatos'=>$contatos,
        //                     'messages'=>$messages
        //                 ]);
    }

    public function novo(Request $request, Response $response, $args)
    {   
        return $this->app->view->render($response, 'contatos/contatos_novo.twig');
    }

    public function editar(Request $request, Response $response, $args)
    {   
        $id_contato = $request->getAttribute('contato');

        $contato = Contato::find($id_contato);

        return $this->app->view->render($response, 'contatos/contatos_novo.twig',['contato'=>$contato]);
    }

    public function update(Request $request, Response $response)
    {   
        $this->app->flash->addMessage('error', 'This is a message');

        return $response->withStatus(200)->withHeader('Location', '/contatos');
    }
}
