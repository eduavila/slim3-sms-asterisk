<?php

namespace App\Sms;

use Psr\Log\LoggerInterface;

class DongleCommand{

    protected $ami;

    protected $server;
    protected $port;
    protected $username;
    protected $password;

    public function __construct(){

        $settings = require __DIR__ . '/../config/dongle.php';
        
        // Inicia class interface com AMI.
        $this->ami = new \PHPAMI\Ami();

        $this->server   = $settings['host'];
        $this->port     = $settings['port'];
        $this->username = $settings['username'];
        $this->password = $settings['password'];
    }

    //Enviar SMS
    // UIID vai codigo unico de 3 caracteres em cada mensagem . utilizado para msg em massa.
    public function sendSMS($numero,$mensagem,$dongle,$uiid = false){

        if(strlen($mensagem) > 180 && $uiid == false){
            throw new \Exception('Messagem com texto maior que 180 caracteres');
        }if(strlen($mensagem) > 176 && $uiid == true) {
           throw new \Exception('Messagem com texto maior que 176 caracteres');
        } 
    
        if($this->ami->connect($this->server.':'.$this->port, $this->username,$this->password, 'off') === false)
        {   
            throw new \Exception('Não foi possível conectar à interface de gerenciamento do Asterisk.');
        }
        
        if($uiid){
            $cod = (string) md5(uniqid(rand(), true));
            $mensagem .= "-".substr($cod,0,3);
        }
        // Executa comando !!   "dongle sms $interf $numer $mensag"
        $result = $this->ami->command("dongle sms ".$dongle." ".$numero." ".$mensagem);
        
        // Disconecta do asterisk.
        $this->ami->disconnect();

        return ['status'=>strpos($result['data'],"SMS queued for send") > 0,'msg'=>$result];
    }   

    //Busca por dados do channel especificos.
    public function isStateChannelActive($name){

        $listaChannel =  $this->getListChannel();
    
        return count(array_filter($listaChannel,function($var) use($name){
            return($var['State'] == 'Free' && $var['ID'] == $name);
        })) == 1;
    }

    //busca lista de devices disponivel no asterisk. opicional por filtro do nome do devices.
    public function getListChannel($name = '',$onlyActive=false){

        if($this->ami->connect($this->server.':'.$this->port, $this->username,$this->password, 'off') === false)
        {   
            throw new \Exception('Não foi possível conectar à interface de gerenciamento do Asterisk.');
        }

        // Executa comando !!
        $result = $this->ami->command('dongle show devices');        

        // Disconecta do asterisk.
        $this->ami->disconnect();   

        if($name !==  '')
        {
            // Faz filtro por nome
            return array_filter($this->parserListChannel($result['data']),function($var) use($name,$onlyActive){
                //Filtra somente canais que estiverem ativo.
                if($onlyActive)
                {   
                    ($var['ID'] == $name && $var['State']=='Free');
                }

                return ($var['ID'] == $name);
            }); 
        }

        if($onlyActive){

            // Faz filtro por nome
            return array_filter($this->parserListChannel($result['data']),function($var) use($name,$onlyActive){
                
                //Filtra somente canais que estiverem ativo.
                return ($var['State']=='Free');
            });
        }

        return $this->parserListChannel($result['data']);
    }

    // Faz o parse da resultado da lista de dongle que asterisk possui.
    private function parserListChannel($str)
    {
        $str = preg_replace_callback('/[^"]*/s', function($matches){

            $str = str_replace("\r", "\rR", $matches[0]);
            $str = str_replace("\n", "\rN", $str);
            $str = str_replace('""', "\rQ", $str);
            $str = str_replace(',', "\rC", $str);
    
            return preg_replace('/\r\n?/', "\n", $matches[0]);

        }, $str);

        $str = explode("\n", $str);
        array_shift($str);
        array_shift($str);
        array_pop($str);
    
        //split on LF and parse each line with a callback
        $result =  array_map(function($register){
           
            $result = array();

            preg_match_all('([^\s]+)',$register,$result);
        
           return [
                    'ID'      => isset($result[0][0])?$result[0][0]:'',
                    'Group'   => isset($result[0][1])?$result[0][1]:'',
                    'State'   => isset($result[0][2])?$result[0][2]:'',
                    'RSSI'    => isset($result[0][3])?$result[0][3]:'',
                    'Mode'    => isset($result[0][4])?$result[0][4]:'',
                    'Submode' => isset($result[0][5])?$result[0][5]:'',
                    'Provider'=> isset($result[0][6])?$result[0][6]:'',
                    'Model'   => isset($result[0][7])?$result[0][7]:'',
                    'Firmware'=> isset($result[0][8])?$result[0][8]:'',
                    'IMEI'    => isset($result[0][9])?$result[0][9]:'',
                    'IMSI'    => isset($result[0][10])?$result[0][10]:'',   
                    'Number'  => isset($result[0][11])?$result[0][11]:''];    
        }, $str);

        return $result;
    }
}
