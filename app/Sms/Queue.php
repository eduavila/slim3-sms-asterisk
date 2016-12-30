<?php 
namespace App\Sms;
use App\Models\Mensagem;
use App\Sms\DongleCommand;
use Monolog\Logger;

class Queue{    

    protected $dongleCommand;
    protected $listChannel;

    // Configuração
    protected $smsSendMaxDay;   
    protected $smsSendInitialTime;
    protected $smsSendEndTime;

    public function __construct(){
        $this->dongleCommand = new DongleCommand();
        //Carrega configuração
        $settings = require __DIR__ . '/../Config/queue.php';

        $this->smsSendMaxDay        = $settings['sms_send_max_day']; 
        $this->smsSendInitialTime   = $settings['sms_send_initial_time']; 
        $this->smsSendEndTime       = $settings['sms_send_end_time']; 
    }

    public function run(){
        
        if(time() < strtotime($this->smsSendInitialTime) || time() > strtotime($this->smsSendEndTime)){

            echo date('H:i:s')." - Não e hora de enviar mensagems. \n";
            exit;
        }
        
        foreach($this->get_tasks() as $task){

            $smsSend = MensagemCampanha::getCountSMSSend($task['interface'])->count();

            if($smsSend >= $this->smsSendMaxDay){
                echo date('H:i:s')." - já foi enviado maximo de sms no dia com interface {$task['interface']} - total enviado:{$smsSend} \n";
                break;
            }
            
            if(empty($task['interface']))
            {
                $this->mark_error($task['id'],'devices not found');

                echo date('H:i:s')." - Sms ID = {$task['id']} não enviado. \n";
            
            }else{

                $result = $this->dongleCommand->sendSms($task['numero'],$task['mensagem'],$task['interface'],true);
                
                if($result['status'] === true){

                    $this->mark_complete($task['id'],$task['interface']);
                
                    echo date('H:i:s')."- Sms ID =  {$task['id']} enviado. \n";
                
                }else{

                    $this->mark_error($task['id'],$task['interface'],$result['msg']['data']);  
            
                    echo date('H:i:s')." - Sms ID = {$task['id']} não enviado. \n";
                }
            }
            sleep(5);
        }
    }

    //Retorna dongle modo randômico.
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
                        ->orderBy('id','asc')
                        ->get();
        return $sms;
    }   
}