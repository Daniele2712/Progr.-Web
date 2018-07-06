<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Comune extends Foundation{
    protected static $table = "comuni";

    public static function insert(Model $obj): int{

    }

    public static function update(Model $obj){

    }

    public static function create(array $obj): Model{
        return new \Models\Comune($obj["id"], $obj["nome"], $obj["CAP"], $obj["provincia"]);
    }
}
?>
