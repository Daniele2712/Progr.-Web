<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class F_Item_Carrello extends Foundation{
    protected static $table = "items_carrello";

    public static function getCarrelloItems(int $id): array{
        $ret = array();
        $DB = \Singleton::DB();
        $sql = "SELECT * FROM ".static::$table." WHERE id_carrello = ?";
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
        $id_carrello = $params["id_carrello"];
        $id_prod = $item->getProdotto()->getId();
        $prezzo = $item->getTotale()->getPrezzo();
        $id_valuta = $item->getTotale()->getValuta();
        $qta = $item->getQuantita();

        $sql = "INSERT INTO ".self::$table." VALUES(NULL, ?, ?, ?, ?, ?);";
        $p = $DB->prepare($sql);
        $p->bind_param("iidii", $id_carrello, $id_prod, $prezzo, $id_valuta, $qta);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->close();
        $id = $DB->lastId();
        $item->setId($id);
        return $id;
    }

    public static function update(Model $item, array $params = array()): int{
        $DB = \Singleton::DB();
        $id = $item->getId();
        $id_carrello = $params["id_carrello"];
        $id_prod = $item->getProdotto()->getId();
        $prezzo = $item->getTotale()->getPrezzo();
        $id_valuta = $item->getTotale()->getValuta();
        $qta = $item->getQuantita();

        $sql = "UPDATE ".self::$table." SET id_carrello = ?, id_prodotto = ?, totale = ?, id_valuta = ?, quantita = ? WHERE id = ?;";
        $p = $DB->prepare($sql);
        $p->bind_param("iidiii", $id_carrello, $id_prod, $prezzo, $id_valuta, $qta, $id);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->close();
        return $id;
    }

    public static function create(array $obj): Model{
        $pro = F_Prodotto::find($obj["id_prodotto"]);
        $pre = new \Models\M_Money($obj["totale"], $obj["id_valuta"]);
        return new \Models\M_Item($obj["id"], $pro, $pre, $obj["quantita"]);
    }
}
