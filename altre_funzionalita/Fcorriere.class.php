<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Corriere extends Foundation{
    protected static $table = "corrieri";

    public static function insert(Model $obj): int{

    }

    public static function update(Model $obj){

    }

    public static function create(array $obj): Model{
        return new \Models\Corriere($obj["idUtente"], DatiAnagrafici::find($obj["id_datianagrafici"]), $obj["email"], $obj["username"], $obj["id"], Consegna::all($obj["id"]), Magazzino::find($obj["id_magazzino"]));
    }
}
?>
