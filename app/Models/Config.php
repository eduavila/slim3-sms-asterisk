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

class Config extends Model{
    
    protected $table = 'config';
    
    protected $primaryKey='id_config_id';

    public $timestamps = false;
}
