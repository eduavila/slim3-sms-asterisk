<?php
namespace App\Controllers;

use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Sms\DongleCommand;

class ChannelController
{

    protected $app;
    protected $dongleCommand;

    public function __construct($app){
        $this->app = $app;  
        $this->dongleCommand = new DongleCommand();
    }

    public function index(Request $request, Response $response)
    {   
        $channels = [];

        try{
            // busca lista de devices
            $channels = $this->dongleCommand->getListChannel();
        }catch(\Exception $ex){
             $this->app->flash->addMessage('error', $ex->getMessage());
        }
        
        return $this->app->view->render($response, 'channels/channels.twig',['channels'=>$channels]);
    }


    public function getListChannel(Request $request,Response $response){
         
        $channels = [];

        try{
            // busca lista de devices
            $channels = $this->dongleCommand->getListChannel();

        }catch(\Exception $ex){
            
        }
        
        return $response->withJson($channels);
    }
}
