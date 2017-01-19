<?php
namespace App\Controllers;

use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

use App\Models\Canal;
use App\Models\Contato;
use App\Models\Mensagem;

use App\Sms\DongleCommand;

class MensagemController
{

    protected $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function index(Request $request, Response $response, $args)
    {   
        $mensagens = Mensagem::leftJoin('contatos','contatos.numero','=','mensagens.numero')
                                ->where('tipo_envio','RAPIDA')
                                ->groupBy('mensagens.numero')
                                ->select('mensagens.numero','mensagens.data','mensagens.hora','contatos.nome_contato')
                                ->orderBy('id','desc')->get();

        return $this->app->view->render($response, 'mensagens/mensagens.twig',['mensagens'=>$mensagens]);
    }

    public function enviar(Request $request, Response $response, $args)
    {   

        $dongleCommand = new DongleCommand();

        $channels = [];

        try{
            // busca lista de devices
            $channels = $dongleCommand->getListChannel('',true);  

        }catch(\Exception $ex){
            $this->app->flash->addMessage('error', $ex->getMessage());
        }
        
        return $this->app->view->render($response, 'mensagens/nova_mensagem.twig',['channels'=>$channels]);
    }

    public function enviarRapido(Request $request, Response $response)
    {
        $data =  $request->getParsedBody();

        $dongleCommand = new DongleCommand();

        $mensagem = new Mensagem();

        $mensagem->status     = 'e';
        $mensagem->data       = date("y-m-d");
        $mensagem->hora       = date("H:i:s");
        $mensagem->interface  = $data['interface']; 
        $mensagem->numero     = $this->limpaNumero($data['telefone']);
        $mensagem->mensagem   = base64_encode($data['mensagem']);
        $mensagem->tipo_envio = 'RAPIDA';

        if($mensagem->save()){
            
            $dongleCommand->sendSMS($mensagem->numero,$mensagem->mensagem,$mensagem->interface);

            $this->app->flash->addMessage('success',"Enviado para fila de sms.");
        }

        $this->app->flash->addMessage('success',"Enviado para fila de sms.");
        
        $url = $this->app->get('router')->pathFor('detalhe_mensagens', ['numero' => $mensagem->numero]);
    
        return $response->withStatus(302)->withHeader('Location', $url);
    }

    private function limpaNumero($numero)
    {
        return preg_replace("/[^0-9]/", "", $numero);
    }
    // Rederiza pagina com detalhes da mensagens.
    public function detalheMensagens(Request $request, Response $response, $args)
    { 
        $dongleCommand = new DongleCommand();

        $channels = [];

        try{
           // busca lista de devices
           $channels = $dongleCommand->getListChannel('',true);  

        }catch(\Exception $ex){
            $this->app->flash->addMessage('error', $ex->getMessage());
        }
        
        $numero = trim($args['numero']);

        return $this->app->view->render($response,'mensagens/detalhe_mensagem.twig',['channels'=> $channels,'numero'=>$numero]);
    }

    // Busca messanges retornando um array json.
    public function buscarMensagens(Request $request,Response $response,$args)
    {
        $allGetVars = $request->getQueryParams();

        $numero = $args['numero'];

        $mensagens = Mensagem::where('tipo_envio','RAPIDA')
                            ->where('numero','=',$numero);
        
        if(isset($allGetVars['ultimamsg']))
        {
            $mensagens->where('id','>',$allGetVars['ultimamsg']);
        }

        if(isset($allGetVars['status']))
        {
            $mensagens->where('status','=',$allGetVars['status']);
        }

        $result = $mensagens->get();

        return json_encode($result);
    }

    public function enviarMensagem(Request $request, Response $response, $args)
    {
        $numero = $request->getAttribute('numero');

        $data =  $request->getParsedBody();

        $dongleCommand = new DongleCommand();

        $mensagem = new Mensagem();

        $mensagem->status     = 'e';
        $mensagem->data       = date("y-m-d");
        $mensagem->hora       = date("H:i:s");
        $mensagem->interface  = $data['interface']; 
        $mensagem->numero     = $numero;
        $mensagem->mensagem   = base64_encode($data['mensagem']);
        $mensagem->tipo_envio = 'RAPIDA';

        if($mensagem->save()){
            
            $result = $dongleCommand->sendSMS($mensagem->numero,$mensagem->mensagem,$mensagem->interface);

            if($result['status'] === true){
                return $response->withJson(['status'=>'success','msg'=>'Enviado para fila de sms.']);
            }else{
                return $response->withJson(['status'=>'error','msg'=>$result['msg']['data']]);
            }
        }
        return  $response->withJson($allPostVars);
    }

    public function getTotMensageRecebida(Request $request,Response $response)
    {   
        $mensagens_recebida = Mensagem::where('tipo_envio','RAPIDA')->where('status','r')->count();
        $mensagens_enviada  = Mensagem::where('tipo_envio','RAPIDA')->where('status','e')->count();
        $mensagens_tot      = Mensagem::where('tipo_envio','RAPIDA')->count();

        return json_encode(['tot'=>$mensagens_tot,
                    'tot_recebida'=>$mensagens_recebida,
                    'tot_envida'=> $mensagens_enviada]);
    }
}
