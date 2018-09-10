<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Ordine extends Foundation{
    protected static $table = "ordini";

    public static function insert(Model $user): int{

    }

    public static function update(Model $user){

    }
}
