<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Amministratore extends Foundation{
    protected static $table = "amministratori";
    public static function insert(Model $obj): int{

    }

    public static function update(Model $obj){

    }

    public static function create(array $obj): Model{
        return new \Models\Amministratore($obj["idUtente"], DatiAnagrafici::find($obj["id_datianagrafici"]), $obj["email"], $obj["username"], $obj["id"], Magazzino::find($obj["id_magazzino"]));
    }
}
?>
