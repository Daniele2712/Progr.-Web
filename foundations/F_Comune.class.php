<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class F_Comune extends Foundation{
    protected static $table = "comuni";

    public static function insert(Model $obj, array $params = array()): int{

    }

    public static function update(Model $obj, array $params = array()){

    }

    public static function create(array $obj): Model{
        return new \Models\M_Comune($obj["id"], $obj["nome"], $obj["CAP"], $obj["provincia"]);
    }

    public static function search(string $comune, int $CAP, string $provincia):\Models\M_Comune{
        $DB = \Singleton::DB();
        $sql = "SELECT * FROM ".self::$table." WHERE nome = ? AND CAP = ? AND provincia = ?";
        $p = $DB->prepare($sql);
        $p->bind_param("sis", $comune, $CAP, $provincia);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $res = $p->get_result();
        $p->close();
        $r = null;
        if($res)
            $r = self::create($res->fetch_assoc());
        return $r;
    }

    public static function searchByName(string $comune):array{
        $DB = \Singleton::DB();
        $sql = "SELECT * FROM ".self::$table." WHERE nome LIKE ? ";
        $p = $DB->prepare($sql);
        $comune = "%".$comune."%";
        $p->bind_param("s", $comune);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $res = $p->get_result();
        $p->close();
        $rows = array();
        while($r = mysqli_fetch_assoc($res)){
            $rows[] = self::create($r);
        }
        return $rows;
    }
}
