<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class F_Item extends Foundation{
    protected static $table = "items";

    public static function getCarrelloItems(int $id){
        $ret=array();
        $result = \Singleton::DB()->query("SELECT id_prodotto, totale, id_valuta, quantita FROM items_carrello WHERE id_carrello=".$id);
        if($result){
            while($row = $result->fetch_array(MYSQLI_ASSOC)){
                $pro = F_Prodotto::find($row["id_prodotto"]);
                $pre = new \Models\M_Money($row["totale"], $row["id_valuta"]);
                $item = new \Models\M_Item($pro, $pre, $row["quantita"]);
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
                $pro = F_Prodotto::find($row["id_prodotto"]);
                $pre = $pro->getPrezzo();
                $pre->setPrezzo($pro->getPrezzo()->getPrezzo()*$row["quantita"]);
                $item = new \Models\M_Item($pro, $pre, $row["quantita"]);
                $ret[] = $item;
            }
        }
        return $ret;
    }

    public static function getOrdineItems(int $id){
        $ret=array();
        $result = \Singleton::DB()->query("SELECT id_prodotto, totale, id_valuta, quantita FROM items_ordine WHERE id_carrello=".$id);
        if($result){
            while($row = $result->fetch_array(MYSQLI_ASSOC)){
                $pro = F_Prodotto::getProdottoByid($row["id_prodotto"]);
                $pre = new \Models\M_Money($row["totale"], $row["id_valuta"]);
                $item = new \Models\M_Item($pro, $pre, $row["quantita"]);
                $ret[] = $item;
            }
        }
        return $ret;
    }

    public static function insert(Model $item): int{    //unzione per inserire un Model nel DB...ma dove nel db dato che ci sono 3 tabbelle per gli item?

    }

    public static function update(Model $item){ //funzione pre aggiornare un Model nel DB ...ma dove nel db dato che ci sono 3 tabbelle per gli item?

    }

    public static function create(array $obj): Model{ //funzione che genera il Model a partire da un array associativo
        $pro = F_Prodotto::getProdottoByid($obj["id_prodotto"]);
        $pre = new \Models\M_Money($obj["totale"], $obj["id_valuta"]);
        return new \Mdels\M_Item($pro, $pre, $obj["quantita"]);
    }
}
