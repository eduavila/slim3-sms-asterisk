<?php


namespace App\Sms;


class DongleCommand{

        // $ami = new \PHPAMI\Ami();
        
        // if($ami->connect('192.168.1.107:5038', 'admin', '03496610', 'off') === false)
        // {
        //   throw new \RuntimeException('Could not connect to Asterisk Management Interface.');
        // }

        // // $result contains the output from the command
        // $result = $ami->command('dongle show devices');

        // //var_dump(str_replace("\rC", ',', $result['data']));
            
        // //var_dump($result['data']);
        // var_dump($this->parse($result['data']));

        // $ami->disconnect();

    public function sendSMS(){
        
    }

    public function getListChannel(){

    }

    private function paserListChannel()
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

        return $str;

        //split on LF and parse each line with a callback
        //  array_map(function($register){

        //     var_dump($register);

        //     // preg_match_all('\w*x\w*',$register,$result);

        //     //  //var_dump($result);
        //     // return array_map(function($field){

        //     //     $field = str_replace("\rC", ',', $field);
        //     //     $field = str_replace("\rQ", '"', $field);
        //     //     $field = str_replace("\rN", "\n", $field);
        //     //     $field = str_replace("\rR", "\r", $field);

        //     //     return $field; 

        //     // }, explode(',', $register));

        // }, $str);
    }
}
