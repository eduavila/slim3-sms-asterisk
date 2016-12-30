<?php
namespace App\Controllers;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

use Slim\Slim as Slim;

use App\Models\Canal;
use App\Models\Campanha;
use App\Models\MensagemCampanha;
use App\Sms\DongleCommand;

class CampanhaController
{

    protected $app;

    public function __construct($app){
        $this->app = $app;
    }

    public function index(Request $request, Response $response)
    {   
        $campanhas = Campanha::leftJoin('mensagens_campanha','mensagens_campanha.campanha_id','=','campanhas.id_campanha_id')
                                ->selectRaw('campanhas.*,count(*) as qtd_contato')
                                ->groupBy('mensagens_campanha.campanha_id')
                                ->orderBy('id_campanha_id','desc')
                                ->get();
        
        return $this->app->view
                    ->render($response, 'campanhas/campanhas.twig',['campanhas'=>$campanhas]);
    }

    public function novo(Request $request, Response $response, $args)
    {   

       // $dongleCommand = new DongleCommand();

        $channels = [['ID'=>'dongle1'],['ID'=>'dongle2']];

        try{
            // busca lista de devices
            //$channels = $dongleCommand->getListChannel('',true);      
        }catch(\Exception $ex){
            $this->app->flash->addMessage('error', $ex->getMessage());
        }

        return $this->app->view->render($response, 'campanhas/nova_campanha.twig',['channels'=>$channels]);
    }

    public function salvar(Request $request, Response $response, $args)
    {   
        $data =  $request->getParsedBody();
        
        $listaNumero = str_getcsv($data['numeros'], "\n");  

        $msg = $data['msg'];

        $campanha = new Campanha();
        $campanha->nome_campanha = $data['nome'];
        $campanha->texto         = $data['msg'];
        $campanha->interface     = $data['interface'];

        if(!$campanha->save()){

            $this->app->flash->addMessage('error',"Ocorreu erro.");
            
            $url = $this->app->get('router')->pathFor('campanhas');
            return $response->withStatus(302)->withHeader('Location', $url);
        }
        
        foreach($listaNumero  as $row)
        {   
            $contato = explode(",",$row);
            $mensagemFinal = str_replace("#NOME#",$contato[1],$msg);
        
            $mensagem = new MensagemCampanha();

            $mensagem->status       = 'e';
            $mensagem->data         = date("y-m-d");
            $mensagem->hora         = date("H:i:s");
            $mensagem->numero       = $this->limpaNumero($contato[0]);
            $mensagem->mensagem     = base64_encode($mensagemFinal);
            $mensagem->tipo_envio   = 'CAMPANHA';
            $mensagem->campanha_id  = $campanha->id_campanha_id;
            $mensagem->interface    = $data['interface'];
            $mensagem->queue_status = 'PROCESSANDO';
            $mensagem->save();
        }    
    
        $this->app->flash->addMessage('success',"Enviado para fila de sms.");
        
        $url = $this->app->get('router')->pathFor('campanhas');

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
            
            $mensagens = MensagemCampanha::where('campanha_id',$id_campanha)->get();

            return $this->app->view->render($response, 'campanhas/detalhes_campanha.twig',
                                ['campanha'=>$campanha,'mensagens'=>$mensagens]);

        }

        // Se nao existir campanha
        $this->app->flash->addMessage('error',"Campanha não encontrada!");
        

        $url = $this->app->get('router')->pathFor('campanhas');
        return $response->withStatus(302)->withHeader('Location', $url);
    }

    public function cancelar(Request $request,Response $response)
    {
        $campanha_id = $request->getAttribute('campanha');

        $campanha = Campanha::find($campanha_id);

        if(!$campanha){
            $url = $this->app->get('router')->pathFor('campanhas_detalhe',['campanha'=>$campanha_id]);
            return $response->withStatus(302)->withHeader('Location', $url);
        }
        
        Campanha::where('id_campanha_id',$campanha_id)->update(['status'=>'CANCELADA']);
        
        MensagemCampanha::where('campanha_id',$campanha_id)
                    ->where('queue_status','PROCESSANDO')
                    ->update(['queue_status'=>'CANCELADO']);

        $this->app->flash->addMessage('success',"Cancelado campanha. ID:".$campanha_id);
        
        $url = $this->app->get('router')->pathFor('campanhas_detalhe',['campanha'=>$campanha_id]);

        return $response->withStatus(302)->withHeader('Location', $url);
    }
}
