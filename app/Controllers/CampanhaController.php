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

use Illuminate\Support\Facades\DB;

class CampanhaController
{

    protected $app;

    public function __construct($app){
        $this->app = $app;
    }

    public function index(Request $request, Response $response)
    {   
        $campanhas = Campanha::leftJoin('mensagens','mensagens.campanha_id','=','campanhas.id_campanha_id')
                                ->selectRaw('campanhas.*,count(*) as qtd_contato')
                                ->groupBy('mensagens.campanha_id')
                                ->orderBy('id_campanha_id','desc')
                                ->get();
        
        return $this->app->view
                    ->render($response, 'campanhas/campanhas.twig',['campanhas'=>$campanhas]);
    }

    public function novo(Request $request, Response $response, $args)
    {   
        return $this->app->view->render($response, 'campanhas/nova_campanha.twig');
    }

    public function salvar(Request $request, Response $response, $args)
    {   
        $data =  $request->getParsedBody();
        
        $listaNumero = str_getcsv($data['numeros'], "\n");  

        $msg = $data['msg'];

        $campanha = new Campanha();
        $campanha->nome_campanha = $data['nome'];
        $campanha->texto = $data['msg'];
       
        if(!$campanha->save()){
            $this->app->flash->addMessage('error',"Ocorreu erro.");
            $url = $this->app->get('router')->pathFor('campanhas_nova');

            return $response->withStatus(302)->withHeader('Location', $url);
        }


        foreach($listaNumero  as $row)
        {   
            $contato = explode(",",$row);
            $mensagemFinal = str_replace("#NOME#",$contato[1],$msg);
        
            $mensagem = new Mensagem();

            $mensagem->status      = 'e';
            $mensagem->data        = date("y-m-d");
            $mensagem->hora        = date("H:i:s");
            $mensagem->numero      = $this->limpaNumero($contato[0]);
            $mensagem->mensagem    = base64_encode($mensagemFinal);
            $mensagem->tipo_envio  = 'CAMPANHA';
            $mensagem->campanha_id = $campanha->id_campanha_id;
            $mensagem->queue_status = 'PROCESSANDO';
            $mensagem->save();
        }    
    
        $this->app->flash->addMessage('success',"Enviado para fila de sms.");
        
        $url = $this->app->get('router')->pathFor('campanhas_nova');

        return $response->withStatus(302)->withHeader('Location', $url);

    }
    private function limpaNumero($numero)
    {
        return preg_replace("/[^0-9]/", "", $numero);
    }

    public function detalhe(Request $request, Response $response)
    {
        $id_campanha = $request->getAttribute('campanha');

        $campanha = Campanha::find($id_campanha);

        if($campanha){
            
            $mensagens = Mensagem::where('campanha_id',$id_campanha)->get();

            return $this->app->view->render($response, 'campanhas/detalhes_campanha.twig',
                                ['campanha'=>$campanha,'mensagens'=>$mensagens]);

        }

        // Se nao existir campanha
        $this->app->flash->addMessage('error',"Campanha não encontrada!");
        
        $url = $this->app->get('router')->pathFor('campanhas');

        return $response->withStatus(302)->withHeader('Location', $url);
    
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
