<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
    return;
}

class Carrello extends Foundation{
    protected static $table = "carrelli";

    public static function update(Model $carrello){
        $DB = \Singleton::DB();
        $sql = "UPDATE ".self::$table." SET totale=?, id_valuta=? WHERE id = ?";
        $p = $DB->prepare($sql);
        $money = $carrello->getTotale();
        $p->bind_param("dsi", $money->getPrezzo(), $money->getValuta(), $carrello->getId());
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->close();
        foreach($carrello->getProdotti() as $item){
            $r = Item::save($item);
        }
    }

    public static function insert(Model $carrello): int{
        $DB = \Singleton::DB();
        $sql = "INSERTO INTO ".self::$table." VALUES(NULL, ?, ?)";
        $p = $DB->prepare($sql);
        $money = $carrello->getTotale();
        $p->bind_param("ds", $money->getPrezzo(), $money->getValuta());
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->close();
        return $DB->lastId();
    }

    public static function create(array $obj): Model{
        $r = new \Models\Carrello($obj["id"]);
        $items = Item::getCarrelloItems($obj["id"]);
        foreach($items as $item)
            $r->addItem($item);
        return $r;
    }
}
?>
