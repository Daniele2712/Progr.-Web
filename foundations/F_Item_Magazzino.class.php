<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class F_Item_Magazzino extends Foundation{
    protected static $table = "items_magazzino";

    public static function getMagazzinoItems(int $id): array{
        $ret = array();
        $DB = \Singleton::DB();
        $sql = "SELECT * FROM ".static::$table." WHERE id_magazzino = ?";
        $p = $DB->prepare($sql);
        $p->bind_param("i", $id);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $res = $p->get_result();
        $p->close();
        while($row = $res->fetch_assoc())
            $ret[] = self::create($row);
        return $ret;
    }

    public static function insert(Model $item, array $params = array()): int{
        $DB = \Singleton::DB();
        $id_magazzino = $params["id_magazzino"];
        $qta = $item->getQuantita();
        $id_prod = $item->getProdotto()->getId();

        $sql = "INSERT INTO ".self::$table." VALUES(NULL, ?, ?, ?);";
        $p = $DB->prepare($sql);
        $p->bind_param("iii", $id_magazzino, $id_prod, $qta);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->close();
        $id = $DB->lastId();
        $item->setId($id);
        return $id;
    }

    public static function update(Model $item, array $params = array()){
        $DB = \Singleton::DB();
        $id = $item->getId();
        $id_magazzino = $params["id_magazzino"];
        $id_prod = $item->getProdotto()->getId();
        $qta = $item->getQuantita();

        $sql = "UPDATE ".self::$table." SET id_magazzino = ?, id_prodotto = ?, quantita = ? WHERE id = ?;";
        $p = $DB->prepare($sql);
        $p->bind_param("iiii", $id_magazzino, $id_prod, $qta, $id);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->close();
    }

    public static function create(array $obj): Model{
        $pro = F_Prodotto::find($obj["id_prodotto"]);
        $pre = $pro->getPrezzo();
        $pre->setPrezzo($pro->getPrezzo()->getPrezzo()*$row["quantita"]);
        return new \Models\M_Item($pro, $pre, $obj["quantita"]);
    }
}
