<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Indirizzo extends Foundation{
    protected static $table = "indirizzi";

    public static function create(array $obj): Model{
        $comune = Comune::find($obj["id_comune"]);
        return new \Models\Indirizzo($obj["id"], $comune, $obj["via"], $obj["civico"], $obj["note"], $obj["latitudine"], $obj["longitudine"]);
    }

    public static function insert(Model $obj): int{
        $sql = "INSERT INTO indirizzi VALUES (NULL, ?, ?, ?, ?, ?, ?)";
        $p = \Singleton::DB()->prepare($sql);
        $id_comune = $obj->getComune()->getId();
        $via = $obj->getVia();
        $civico = $obj->getCivico();
        $note = $obj->getNote();
        $lat = $obj->getLat();
        $lng =  $obj->getLng();
        $p->bind_param("isssdd", $id_comune, $via, $civico, $note, $lat, $lng);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $id = $p->insert_id;
        $p->close();
        return $id;
    }

    public static function update(Model $obj){

    }

    public static function getIndirizziByUserId(int $id){
        $p = \Singleton::DB()->prepare("
            SELECT indirizzi.id, id_comune, via, civico, note, latitudine, longitudine
            FROM indirizzi
            LEFT JOIN indirizzi_utenti ON indirizzi.id=indirizzi_utenti.id_indirizzo
            WHERE id_utente_r = ?");
        $p->bind_param("i",$id);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $res = $p->get_result();
        $p->close();
        $r = array();
        while($row = $res->fetch_assoc())
            $r[] = self::create($row);
        return $r;
    }
}
