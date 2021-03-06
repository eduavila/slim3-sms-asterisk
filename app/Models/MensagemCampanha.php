<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
* Mensagem envio sms .
* 
* 
* @package    App
* @subpackage Models
* @author     Eduardo Avila Malheiro  <edu.avila2@gmail.com>
*/

class MensagemCampanha extends Model{

    protected $table = 'mensagens_campanha';
    
    public $timestamps = false;

    public function getMensagemAttribute($value)
    {
    	return base64_decode($value);
    }

    public function dateHora(){
        $date = new DateTime($this->data.''.$this->hora);
        return $date->format("d-m-Y H:i:s");
    }


    public function scopeGetCountSMSSend($query,$dongle){

        return $query->whereRaw('CAST(enviada_em as DATE) = CAST(now() as DATE)')
            ->where('queue_status','ENVIADA')->where('interface',$dongle);
    }
}