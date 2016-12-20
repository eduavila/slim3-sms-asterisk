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
        $mensagens = Mensagem::where('tipo_envio','RAPIDA')
                                ->groupBy('numero')
                                ->orderBy('id','desc')->get();

        return $this->app->view->render($response, 'mensagens/mensagens.twig',['mensagens'=>$mensagens]);
    }

    public function enviar(Request $request, Response $response, $args)
    {   

        $dongleCommand = new DongleCommand();

        $channels = [];

        try{
            // busca lista de devices
            $channels = $dongleCommand->getListChannel();  

        }catch(\Exception $ex){
            $this->app->flash->addMessage('error', $ex->getMessage());
        }

        return $this->app->view->render($response, 'envio.twig',['channels'=>$channels]);
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
        $mensagem->numero     = $data['telefone'];
        $mensagem->mensagem   = base64_encode($data['mensagem']);
        $mensagem->tipo_envio = 'RAPIDA';

        if($mensagem->save()){
            
            $dongleCommand->sendSMS($mensagem->numero,$mensagem->mensagem,$mensagem->interface);

            $this->app->flash->addMessage('success',"Enviado para fila de sms.");
        }

        $this->app->flash->addMessage('success',"Enviado para fila de sms.");
        
        //return $response->withStatus(200)->withHeader('Location', '/mensagens/enviar');
    }


    // Rederiza pagina com detalhes da mensagens.
    public function detalheMensagens(Request $request, Response $response, $args)
    { 
        $canais= Canal::all();

        $numero = trim($args['numero']);

        return $this->app->view->render($response,'detalhe_msg.twig',['canais'=>$canais,'numero'=>$numero]);
    }


    // Busca messanges retornando um array json.

    public function buscarMensagens(Request $request,Response $response,$args)
    {
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
    	$numero = $request->getAttribute('ultimamessagem');
    }
}
