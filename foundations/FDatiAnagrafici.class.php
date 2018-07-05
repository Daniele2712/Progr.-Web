<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class FDatiAnagrafici extends Foundation{
    protected static $table = "dati_anagrafici";

    public static function insert(Entity $object): int{

    }

    public static function update(Entity $object){

    }

    public static function create(array $object): Entity{
        return new EDatiAnagrafici($object["id"], $object["nome"], $object["cognome"], $object["telefono"], new DateTime($object["data_nascita"]));
    }
}
?>
