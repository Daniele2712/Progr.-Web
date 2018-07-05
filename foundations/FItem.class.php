<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class FItem extends Foundation{
    protected static $table = "items";

    public static function getCarrelloItems(int $id){
        $ret=array();
        $result = Singleton::DB()->query("SELECT id_prodotto, totale, valuta, quantita FROM items_carrello WHERE id_carrello=".$id);
        if($result){
            while($row = $result->fetch_array(MYSQLI_ASSOC)){
                $pro = FProdotto::find($row["id_prodotto"]);
                $pre = new EMoney($row["totale"], $row["valuta"]);
                $item = new EItem($pro, $pre, $row["quantita"]);
                $ret[] = $item;
            }
        }
        return $ret;
    }

    public static function getMagazzinoItems(int $id){
        $ret=array();
        $result = Singleton::DB()->query("SELECT id_prodotto, totale, valuta, quantita FROM items_magazzino WHERE id_magazzino=".$id);
        if($result){
            while($row = $result->fetch_array(MYSQLI_ASSOC)){
                $pro = FProdotto::getProdottoByid($row["id_prodotto"]);
                $pre = new EMoney($row["totale"], $row["valuta"]);
                $item = new EItem($pro, $pre, $row["quantita"]);
                $ret[] = $item;
            }
        }
        return $ret;
    }

    public static function getOrdineItems(int $id){
        $ret=array();
        $result = Singleton::DB()->query("SELECT id_prodotto, totale, valuta, quantita FROM items_ordine WHERE id_carrello=".$id);
        if($result){
            while($row = $result->fetch_array(MYSQLI_ASSOC)){
                $pro = FProdotto::getProdottoByid($row["id_prodotto"]);
                $pre = new EMoney($row["totale"], $row["valuta"]);
                $item = new EItem($pro, $pre, $row["quantita"]);
                $ret[] = $item;
            }
        }
        return $ret;
    }

    public static function insert(Entity $item): int{

    }

    public static function update(Entity $item){

    }

    public static function create(array $obj): Entity{
        $pro = FProdotto::getProdottoByid($obj["id_prodotto"]);
        $pre = new EMoney($obj["totale"], $obj["valuta"]);
        return new EItem($pro, $pre, $obj["quantita"]);
    }
}
