<?php
if(!defined("EXEC")){
    header("location: /index.php");
    return;
}

class FCarrello extends Foundation{
    protected static $table = "carrelli";

    public static function all(){
        $ret = array();
        $result = Singleton::DB()->query("SELECT * FROM carrelli");
        if($result){
            while($row = $result->fetch_array(MYSQLI_ASSOC)){
                $carrello = new ECarrello($row["id"]);
                $items = FItem::getCarrelloItems($row["id"]);
                foreach($items as $item){
                    $carrello->addItem($item);
                }
                $ret[] = $carrello;
            }
        }
        return $ret;
    }

    public static function find(int $id){
        $DB = Singleton::DB();
        $p = $DB->prepare("
        SELECT *
        FROM carrelli
        WHERE carrelli.id = ?");
        if(!$p){
            var_dump($p);
            echo $DB->error();
            die();
        }
        $p->bind_param("i",$id);
        $p->execute();
        $p->bind_result($id, $totale, $valuta);
        $r = null;
        if($p->fetch()){
            $p->close();
            $r = new ECarrello($id);
            $items = FItem::getCarrelloItems($id);
            foreach($items as $item)
            $carrello->addItem($item);
        }else
        $p->close();
        return $r;
    }

    public static function store(ECarrello $carrello){
        $DB = Singleton::DB();
        $p = $DB->prepare("
        UPDATE carrelli
        SET totale=?, valuta=?
        WHERE carrelli.id = ?");
        if(!$p){
            var_dump($p);
            echo $DB->error();
            die();
        }
        $money=$carrello->getTotale();
        $p->bind_param("dsi", $money->getPrezzo(), $money->getValuta(), $carrello->getId());
        $r=$p->execute();
        $p->close();
        if(!$r)
            return $r;
        foreach($carrello->getProdotti() as $item){
            $r = FItem::save($item);
            if(!$r)
                return $r;
        }
        return true;
    }
    public static function create(ECarrello $carrello):int{
        $DB = Singleton::DB();
        $p = $DB->prepare("
        INSERTO INTO carrelli
        VALUES(NULL, ?, ?)");
        if(!$p){
            var_dump($p);
            echo $DB->error();
            die();
        }
        $money=$carrello->getTotale();
        $p->bind_param("ds", $money->getPrezzo(), $money->getValuta());
        $r = 0;
        if($p->execute())
        $r = $DB->lastId();
        $p->close();
        return $r;
    }
}
?>
