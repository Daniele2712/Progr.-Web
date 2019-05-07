<?php
namespace Models;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

//  chi e' che crea l-ordine, e chi se se lo ricorda??? il cestino?? il cliente??


abstract class Pagamento extends Model{
    public function __construct(int $id){
        $this->id = $id;
    }

    public function getType(){
        $path = explode('\\',get_class($this));
        return array_pop($path);
    }

    public static function nuovo(Request $req){
        $type = "\\Models\\".$req->getString("tipo_pagamento","","POST");
        if(class_exists($type) && (new \ReflectionClass($type))->isSubclassOf("\\Models\\Pagamento"))
            return $type::newPayment($req);
    }

    public static abstract function newPayment(Request $req):Pagamento;
    public abstract function paga();

}
