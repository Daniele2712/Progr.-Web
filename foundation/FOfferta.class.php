<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

abstract class FOfferta extends Foundation{

    public static function find(int $id){
        $DB = Singleton::DB();
        $p = $DB->prepare("
            SELECT tipo, data_inizio, data_fine
            FROM offerte
            LEFT JOIN offerte_tipi AS t ON t.id = id_tipo
            WHERE offerte.id = ?");
        if(!$p){
            var_dump($p);
            echo $DB->error();
            die();
        }
        $p->bind_param("i",$id);
        $p->execute();
        $p->bind_result($tipo, $inizio, $fine);
        $r = null;
        if($p->fetch()){
            $p->close();
            $r = self::create(array("id"=>$id, "tipo"=>$tipo, "inizio"=>new DateTime($inizio), "fine"=>new DateTime($fine)));
        }else
            $p->close();
        return $r;
    }

    public static function create($obj){
        $Fname = "FOfferta".$obj["tipo"];
        if(class_exists($Fname) && (new ReflectionClass($Fname))->isSubclassOf("FOfferta"))
            return $Fname::load($obj["id"], $obj["tipo"], $obj["inizio"], $obj["fine"]);
        return null;
    }

    protected abstract static function load(int $id, string $tipo, DateTime $inizio, DateTime $fine);

}
?>
