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

class Contato extends Model{
    
    protected $table = 'contatos';
    
    protected $primaryKey='id_contato_id';

    public $timestamps = false;
}