<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
* Mensagem envio de sms.
* 
* 
* @package    App
* @subpackage Models
* @author     Eduardo Avila Malheiro  <edu.avila2@gmail.com>
*/

class Campanha extends Model{
    
    protected $table = 'campanhas';
    
    protected $primaryKey='id_campanha_id';

    public $timestamps = false;

}