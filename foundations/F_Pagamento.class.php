<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class F_Pagamento extends Foundation{
    protected static $table = "pagamenti";

    public static function create(array $obj): Model{
        $DB = \Singleton::DB();
        $Fname = "\\Foundations\\Pagamenti\\F_".$obj["tipo"];
        if(class_exists($Fname) && (new \ReflectionClass($Fname))->isSubclassOf("\\Foundations\\F_Pagamento"))
            return $Fname::create_payment($obj["id"]);
        throw new \Exception("Error Payment Type not found", 2);
    }

    public static function save(Model $pagamento){
        $Fname = "\\Foundations\\Pagamenti\\F_".$pagamento->getType();
        if(!class_exists($Fname))
            throw new \Exception("Error Payment Type not found", 2);
        $id = parent::save($pagamento);
        $Fname::save($pagamento);
        return $id;
    }

    public static function insert(Model $pagamento): int{
        $DB = \Singleton::DB();
        $tipo = $pagamento->getType();

        $sql = "INSERT INTO ".self::$table." VALUES(NULL, ?);";
        $p = $DB->prepare($sql);
        $p->bind_param("s", $tipo);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->close();
        $id = $DB->lastId();
        $pagamento->setId($id);
        return $id;
    }

    public static function update(Model $pagamento){
        $DB = \Singleton::DB();
        $id = $pagamento->getId();
        $tipo = $pagamento->getType();

        $sql = "UPDATE ".self::$table." SET tipo = ? WHERE id = ?;";
        $p = $DB->prepare($sql);
        $p->bind_param("si", $tipo, $id);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->close();
    }

}
