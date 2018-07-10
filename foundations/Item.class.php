<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Item extends Foundation{
    protected static $table = "items";

    public static function getCarrelloItems(int $id){
        $ret=array();
        $result = \Singleton::DB()->query("SELECT id_prodotto, totale, valuta, quantita FROM items_carrello WHERE id_carrello=".$id);
        if($result){
            while($row = $result->fetch_array(MYSQLI_ASSOC)){
                $pro = Prodotto::find($row["id_prodotto"]);
                $pre = new \Models\Money($row["totale"], $row["valuta"]);
                $item = new \Models\Item($pro, $pre, $row["quantita"]);
                $ret[] = $item;
            }
        }
        return $ret;
    }

    public static function getMagazzinoItems(int $id){
        $ret=array();
        $result = \Singleton::DB()->query("SELECT id_prodotto, quantita FROM items_magazzino WHERE id_magazzino=".$id);
        if($result){
            while($row = $result->fetch_array(MYSQLI_ASSOC)){
                $pro = Prodotto::getProdottoByid($row["id_prodotto"]);
                $pre = $pro->getPrezzo();
                $pre->setPrezzo($pre->getPrezzo() * $row["quantita"]);
                $item = new \Models\Item($pro, $pre, $row["quantita"]);
                $ret[] = $item;
            }
        }
        return $ret;
    }

    public static function getOrdineItems(int $id){
        $ret=array();
        $result = \Singleton::DB()->query("SELECT id_prodotto, totale, valuta, quantita FROM items_ordine WHERE id_carrello=".$id);
        if($result){
            while($row = $result->fetch_array(MYSQLI_ASSOC)){
                $pro = FProdotto::getProdottoByid($row["id_prodotto"]);
                $pre = new \Models\Money($row["totale"], $row["valuta"]);
                $item = new \Models\Item($pro, $pre, $row["quantita"]);
                $ret[] = $item;
            }
        }
        return $ret;
    }

    public static function insert(Model $item): int{

    }

    public static function update(Model $item){

    }

    public static function create(array $obj): Model{
        $pro = Prodotto::getProdottoByid($obj["id_prodotto"]);
        $pre = new \Models\Money($obj["totale"], $obj["valuta"]);
        return new \Mdels\Item($pro, $pre, $obj["quantita"]);
    }
}