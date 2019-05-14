<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class F_Turno extends Foundation{
    protected static $table = "turni";

    public static function findByDipendente(int $id): array{
        $DB = \Singleton::DB();
        $sql = "SELECT id FROM ".self::$table." WHERE id_dipendente = ?";
        $p = $DB->prepare($sql);
        $p->bind_param("i",$id);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->bind_result($id_immagine);
        $res = $p->get_result();
        $p->close();
        $tmp = array();
        if($res === FALSE)
            throw new \SQLException("Error Fetching Statement", $sql, $p->error, 4);
        else
            while ($row = $res->fetch_array(MYSQLI_NUM))
                $tmp[] = $row[0];
        return F_Turno::findMany($tmp);
    }

    public static function create(array $obj): Model{
        return new \Models\M_Turno($obj["id"], $obj["giorno_inizio"], $obj["ora_inizio"], $obj["giorno_fine"], $obj["ora_fine"]);
    }

    public static function insert(Model $obj, array $params = array()): int{

    }

    public static function update(Model $obj, array $params = array()){

    }
}
