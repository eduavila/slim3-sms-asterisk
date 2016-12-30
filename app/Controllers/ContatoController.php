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

use JasonGrimes\Paginator;


class ContatoController
{

    protected $app;

    public function __construct($app){
        $this->app = $app;
    }

    public function index(Request $request, Response $response,$args)
    {   
        $contatos = Contato::orderBy('id_contato_id','desc')->get();
        
        return $this->app->view
                    ->render($response, 'contatos/contatos.twig',['contatos'=>$contatos]);
    }

    public function novo(Request $request, Response $response, $args)
    {   
        return $this->app->view->render($response, 'contatos/contatos_novo.twig');
    }
    
    public function salvar(Request $request, Response $response, $args)
    {
        $data =  $request->getParsedBody();
        if(isset($data['id']))
        {
            $contato = Contato::find($data['id']);

            if(!$contato){
                   
                $this->app->flash->addMessage('error',"Contato não encontrato!");
                    
                $url = $this->app->get('router')->pathFor('contatos');

                return $response->withStatus(200)->withHeader('Location', $url);
            }

        }else{
            $contato = new Contato();
        }
        
        $contato->nome_contato  = $data['nome'];
        $contato->numero        = $data['telefone'];
        $contato->email         = $data['email'];
        $contato->obs           = $data['obs'];

        if($contato->save()){
            $this->app->flash->addMessage('success',"Cadastrado com sucesso.");
        
            $url = $this->app->get('router')->pathFor('contatos');

            return $response->withStatus(200)->withHeader('Location', $url);
        }

        
        $this->app->flash->addMessage('error',"Erro ao cadastrar.");
        
        $url = $this->app->get('router')->pathFor('contatos');
        return $response->withStatus(200)->withHeader('Location', $url);
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
