<?php

namespace App\Database;

class Database {
        // Construtor
    private function _construct(){}

    // Evita clona objeto
    private function _clone(){}

    // Destroy todas variavel da memoria
    public function _destruct(){
        foreach($this as $key => $value){
            unset($this->$key);
        }
    }

    //private $conexao = null; 
    private static $dbtype   = "mysql";
    private static $host     = "127.0.0.1";
    private static $port     = "8889";
    private static $user     = "root";
    private static $password = "root";
    private static $db       = "sms_aste";


    // metodos Get
    private function getDBType(){return self::$dbtype;}
    private function getHost(){return self::$host;}
    private function getPort(){return self::$port;}
    private function getUser(){return self::$user;}
    private function getPassword(){return self::$password;}
    private function getDB(){return self::$db;}

    private function connect(){

        try{
            
            // Instancia conecao 
            $config = $this->getDBType().":host=".$this->getHost().";port=".$this->getPort().";dbname=".$this->getDB();
        
            $this->conexao = new \PDO($config,$this->getUser(),$this->getPassword());

        }catch(\PDOException $e){
            
            var_dump($e->getMessage());
            print_r($e->getMessage(),true);
            $this->logger->err("Erro ao conectar banco MSG:".$e->getMessage());
        }

        return ($this->conexao);
    }

    private function disconnect(){
        $this->conexao = null;
    }


    // Metodos publico

    // Método select que restona um VO ou array de objetos 
    public function selectDB($sql,$params=null,$class=null){
       
        $query = $this->connect()->prepare($sql);
        $query->execute($params);

        if(isset($class)){
            $rs = $query->fetchAll(\PDO::FETCH_CLASS,$class) or die(print_r($query->errorInfo(),true));
        }else{
            $rs = $query->fetchAll(\PDO::FETCH_OBJ,$class) or die(print_r($query->errorInfo(),true));
        }

        self::__destruct();
        return $rs;
    }

    // Método insert que insere valores no banco
    public function insertDB($sql,$params=null){
        $conexao = $this->connect();
        $query=$conexao->prepare($sql);
        $query->execute($params);

        $rs = $conexao->lastInsertId() or die(print_r($query->errorInfo(),true));
        self::__destruct();

        return $rs;
    }


    // Método update que altear valores no banco
    public function updateDB($sql,$params =null){
        $query=$this->connect()->prepare($sql);
        $query->execute($params);

        $rs = $query->rowCount() or die(print_r($query->errorInfo(),true));
        
        self::__destruct();
        return $rs;
    }

    // Método delete
    public function deleteDB($sql,$params=null){
        $query = $this->connect()->prepare($sql);
        $query->execute($params);

        $rs = $query->rowCount() or die(print_r($query->erroInfo(),true));
        self::__destruct();

        return $rs;
    }
}