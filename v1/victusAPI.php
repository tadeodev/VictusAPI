<?php

class Conectar{

    protected $dbh;

    protected function connect(){
        try{

            $conectar=$this->dbh=new PDO("mysql:host=localhost;dbname=victus","root","password");
            return $conectar;
        }catch(Exception $error){
            print "!error DB:" .$error->getMessage();
            die();
        }
    }

    public function set_name(){

        return $this->dbh->query("SET NAMES 'utf8'");
    }

}


?>
