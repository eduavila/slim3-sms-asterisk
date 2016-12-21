<?php
namespace App\Controllers;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

use Slim\Slim as Slim;

use App\Models\Canal;
use App\Models\Campanha;
use App\Models\Mensagem;

use JasonGrimes\Paginator;


class CampanhaController
{

    protected $app;

    public function __construct($app){
        $this->app = $app;
    }

    public function index(Request $request, Response $response)
    {   
        $campanhas = Campanha::orderBy('id_campanha_id','desc')->get();
        
        return $this->app->view
                    ->render($response, 'campanhas/campanhas.twig',['campanhas'=>$campanhas]);
    }

    public function novo(Request $request, Response $response, $args)
    {   
        return $this->app->view->render($response, 'campanhas/nova_campanha.twig');
    }

    public function salvar(Request $request, Response $response, $args)
    {   
        $files = $request->getUploadedFiles();
    
        if(empty($files['newfile'])) {
            throw new \Exception('Expected a newfile');
        }
        
        if($files->getError() === UPLOAD_ERR_OK) {
            $uploadFileName =  $files->getClientFilename();
        }
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