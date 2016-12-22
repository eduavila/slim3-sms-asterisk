<?php 
namespace App\Sms;
use App\Models\Mensagem;
use App\Sms\DongleCommand;
use Monolog\Logger;

class Queue{    

    protected $dongleCommand;
    protected $listChannel;

    public function __construct(){
        $this->dongleCommand = new DongleCommand();

        $this->listChannel = $this->dongleCommand->getListChannel('',true);
    }

    public function run(){
        
        foreach($this->get_tasks() as $task){
            $channel = $this->get_channel();
            
            if(empty($channel))
            {
                $this->mark_error($task['id'],'devices not found');

                echo date('H:i:s')." - Sms send id {$task['id']} not complete.<br>";
            
            }else{

                $result = $this->dongleCommand->sendSms($task['numero'],$task['mensagem'],$channel,true);
              
                
                if($result['status'] === true){

                    $this->mark_complete($task['id'],$channel);
                
                    echo date('H:i:s')."- Sms send id {$task['id']} complete.<br>";
                
                }else{
                    $this->mark_error($task['id'],$channel,$result['msg']['data']);  
            
                    echo date('H:i:s')." - Sms send id {$task['id']} not complete.<br>";
                }
            }
    
            sleep(1);
        }
    }

    //Retorna dongle modo radomico.
    private function get_channel(){

        if(count($this->listChannel) > 1)
        {
            $channelSelected = (int)rand(0,count($this->listChannel)) - 1;
            return $this->listChannel[$channelSelected]['ID'];
       
        }if(count($this->listChannel) ==1){ 
            
            return $this->listChannel[0]['ID'];
        } 

        return '';
    }

    private function mark_complete($task_id,$dongle){
        $msg = Mensagem::find($task_id);
        $msg->enviada_em = date('y-m-d H:i:s');
        $msg->interface= $dongle;
        $msg->queue_status = 'ENVIADA';
        $msg->save();
    }   
    
    private function mark_error($task_id,$inteface,$queue_error){

        $msg = Mensagem::find($task_id);
        $msg->enviada_em = date('y-m-d H:i:s');
        $msg->queue_status = 'ERRO';
        $msg->queue_error = $queue_error;
        $msg->interface = $inteface;
        $msg->save();
    }    
    private function get_tasks(){

        $sms = Mensagem::where('tipo_envio','CAMPANHA')
                        ->where('queue_status','PROCESSANDO')
                        ->limit(50)
                        ->orderBy('id','asc')
                        ->get();
        return $sms;
    }
    
}