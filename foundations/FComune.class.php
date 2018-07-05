<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class FComune extends Foundation{
    protected static $table = "comuni";

    public static function insert(Entity $obj): int{

    }

    public static function update(Entity $obj){

    }

    public static function create(array $obj): Entity{
        return new EComune($obj["id"], $obj["nome"], $obj["CAP"], $obj["provincia"]);
    }
}
?>
