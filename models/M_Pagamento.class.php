<?php
namespace Models;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

abstract class M_Pagamento extends Model{
    public function __construct(int $id){
        $this->id = $id;
    }

    public function getType(){
        $path = explode('\\',get_class($this));
        $class = array_pop($path);
        return substr($class, strpos($class, '_')+1);
    }

    public static function nuovo(Request $req){
        $type = "\\Models\\Pagamenti\\M_".$req->getString("tipo_pagamento","","POST");
        if(class_exists($type) && (new \ReflectionClass($type))->isSubclassOf("\\Models\\M_Pagamento"))
            return $type::newPayment($req);
    }

    public static abstract function newPayment(Request $req):M_Pagamento;
    public abstract function paga();
}
