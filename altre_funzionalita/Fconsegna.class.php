<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Consegna extends Foundation{
    protected static $table = "consegne";

    public static function insert(Model $obj): int{

    }

    public static function update(Model $obj){

    }

    public static function create(array $obj): Model{
        $ordine = Ordine::find($obj["id_ordine"]);
        return new \Models\Consegna($obj["id"], $ordine, $obj["stato"], $obj["coda"]);
    }

    public static function all(int $id): array{}
}
?>
