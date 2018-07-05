<?php
if(!defined("EXEC")){
    header("location: /index.php");
    return;
}

class FCarrello extends Foundation{
    protected static $table = "carrelli";

    public static function update(Entity $carrello){
        $DB = Singleton::DB();
        $sql = "UPDATE ".self::$table." SET totale=?, valuta=? WHERE id = ?";
        $p = $DB->prepare($sql);
        $money = $carrello->getTotale();
        $p->bind_param("dsi", $money->getPrezzo(), $money->getValuta(), $carrello->getId());
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 1);
        $p->close();
        foreach($carrello->getProdotti() as $item){
            $r = FItem::save($item);
        }
    }

    public static function insert(Entity $carrello): int{
        $DB = Singleton::DB();
        $sql = "INSERTO INTO ".self::$table." VALUES(NULL, ?, ?)";
        $p = $DB->prepare($sql);
        $money=$carrello->getTotale();
        $p->bind_param("ds", $money->getPrezzo(), $money->getValuta());
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 1);
        $p->close();
        return $DB->lastId();
    }

    public static function create(array $obj): Entity{
        $r = new ECarrello($obj["id"]);
        $items = FItem::getCarrelloItems($obj["id"]);
        foreach($items as $item)
            $r->addItem($item);
        return $r;
    }
}
?>
