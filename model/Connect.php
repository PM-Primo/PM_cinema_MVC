<?php

namespace Model;

abstract class Connect {

    const HOST = "localhost";
    const DB = "cinema_primo";
    const USER = "root";
    const PASS = "";

    public static function seConnecter() {
        try{
            return new \PDO("mysql:host=".self::HOST.";dbname=".self::DB.";charset=utf8", self::USER, self::PASS); //le script de connection au PDO
        }
        catch(\PDOException $ex){
            return $ex->getMessage(); //pour avoir les messages d'erreur en cas d'échec de connection au PDO
        }
    }
}





?>