<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Pagamento{
    protected static $table = "pagamenti";

    public static function create(array $obj): Model{
        $DB = \Singleton::DB();
        $Fname = "Foundations\\".$obj["tipo"];
        if(class_exists($Fname) && (new \ReflectionClass($Fname))->isSubclassOf("\\Foundations\\Pagamento"))
            return $Fname::create_payment($obj["id"]);
        throw new \Exception("Error User Type not found", 2);
    }

    public abstract static function create_payment(int $id_pagamento);
}
