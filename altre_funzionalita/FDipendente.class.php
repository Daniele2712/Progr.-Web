<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Dipendente extends Foundation{
    protected static $table = "dipendenti";

    public static function insert(Model $obj): int{

    }

    public static function update(Model $obj){

    }

    public static function create(array $obj): Model{
        return new \Models\Dipendente($obj["idUtente"], DatiAnagrafici::find($obj["id_datianagrafici"]), $obj["email"], $obj["username"], $obj["id"], $obj["ruolo"], $obj["tipoContratto"], $obj["oreSettimanali"], new Money($obj["prezzo"], $obj["valuta"]));
    }
}
?>
