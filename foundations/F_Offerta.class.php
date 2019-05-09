<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

abstract class F_Offerta extends Foundation{

    public static function find(int $id): \Models\M_Offerta{
        $DB = \Singleton::DB();
        $sql = "SELECT tipo, data_inizio, data_fine FROM offerte LEFT JOIN offerte_tipi AS t ON t.id = id_tipo WHERE offerte.id = ?";
        $p = $DB->prepare($sql);
        $p->bind_param("i",$id);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->bind_result($tipo, $inizio, $fine);
        $f = $p->fetch();
        $p->close();
        if($f === FALSE)
            throw new \SQLException("Error Fetching Statement", $sql, $p->error, 4);
        elseif($f === NULL)
            throw new \ModelException("Model Not Found", __CLASS__, array("id"=>$id), 0);
        else
            return self::create(array("id"=>$id, "tipo"=>$tipo, "inizio"=>new \DateTime($inizio), "fine"=>new \DateTime($fine)));
    }

    public static function create($obj): \Models\M_Offerta{
        $Fname = "\\Foundations\\F_Offerta_".$obj["tipo"];
        if(class_exists($Fname) && (new \ReflectionClass($Fname))->isSubclassOf("\\Foundations\\F_Offerta"))
            return $Fname::load($obj["id"], $obj["tipo"], $obj["inizio"], $obj["fine"]);
        throw new \Exception("Error Offerta Type not found", 3);
    }

    protected abstract static function load(int $id, string $tipo, \DateTime $inizio, \DateTime $fine): \Models\M_Offerta;

}
