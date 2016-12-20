<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
* Mensagem envio de sms.
* 
* 
* @package    App
* @subpackage Controller
* @author     Eduardo Avila Malheiro  <edu.avila2@gmail.com>
*/

class Mensagem extends Model{

    protected $table = 'mensagens';
    
    public $timestamps = false;

    public function getMensagemAttribute($value)
    {
    	return base64_decode($value);
    }


    public function dateHora(){
        $date = new DateTime($this->data.''.$this->hora);
        var_dump($date);
        return $date->format("d-m-Y H:i:s");
    }
}