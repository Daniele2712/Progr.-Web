<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
    return;
}

class F_Carrello extends Foundation{
    protected static $table = "carrelli";

    public static function update(Model $carrello, array $params = array()): int{
        $DB = \Singleton::DB();
        $sql = "UPDATE ".self::$table." SET totale=?, id_valuta=? WHERE id = ?";
        $p = $DB->prepare($sql);
        $money = $carrello->getTotale();
        $prezzo=$money->getPrezzo();
        $valuta=$money->getValuta();
        $id=$carrello->getId();
        $p->bind_param("dsi", $prezzo, $valuta, $id);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->close();
        foreach($carrello->getItems() as $item){
            $r = F_Item_Carrello::save($item, array("id_carrello"=>$id));
        }
        return $id;
    }

    public static function insert(Model $carrello, array $params = array()): int{
        $DB = \Singleton::DB();
        $sql = "INSERTO INTO ".self::$table." VALUES(NULL, ?, ?)";
        $p = $DB->prepare($sql);
        $money = $carrello->getTotale();
        $p->bind_param("ds", $money->getPrezzo(), $money->getValuta());
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->close();
        $id = $DB->lastId();   //ritorna l-id del carrello appena inserito nel db
        foreach($carrello->getItems() as $item){
            $r = F_Item_Carrello::save($item, array("id_carrello"=>$id));
        }
        return $id;
    }

    public static function insertItems_Carrello($id_carrello,$id_prodotto, $totale, $id_valuta, $quantita): int{

        //Vedo se c-e gia presente nel carrello il prodotto che voglio aggiungere
        $DB = \Singleton::DB();
        $sql = 'SELECT totale, id_valuta, quantita FROM items_carrello WHERE id_carrello=? AND id_prodotto=?';
        $p = $DB->prepare($sql);
        $p->bind_param("ii", $id_carrello,$id_prodotto);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        //mi sembra che non c-e bisogno di bind_result xke tanto posso prendere il valore usando p->fetch e poi p[id]
        $p->bind_result($present_totale, $present_id_valuta, $present_quantita);
        $p->fetch();
        $p->free_result();
        if(isset($present_quantita))  // vuol dire che esiste gia questo elemento del database ergo lo devo aggiornare
        {
            $new_totale=$present_totale+$totale;
            $new_quantita=$present_quantita+$quantita;
            $new_id_valuta=$id_valuta;    //beh, qui dovrei fare in modo di fare eventuali conversioni, e riportarli a un unica valuta in caso siano diverse

            $sql = "UPDATE items_carrello SET totale=$new_totale, quantita=$new_quantita, id_valuta='$new_id_valuta' WHERE id_carrello=? AND id_prodotto=?";
            $p = $DB->prepare($sql);
            $p->bind_param("ii", $id_carrello,$id_prodotto);
            if(!$p->execute())
                throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
            $p->close();
        }
        else{
        //inserisce una riga nella tabbella items_carrello
        $sql = 'INSERT INTO '.'items_carrello'.' VALUES (NULL, ?, ?, ?,?,?)';
        $p = $DB->prepare($sql);
        $p->bind_param("iidsi", $id_carrello,$id_prodotto, $totale, $id_valuta, $quantita);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->close();
        }


        // Dopo che hai inserito un nuovo prodotto nel carrello, si fa anche un refresh della tabbella carrelli per aggiornare il nuovo totale del carrello con id $id_carrello dove hai appena inserito il prodotto
        $model_carrello=self::create(array("id"=>"$id_carrello"));
        $totale=$model_carrello->getTotale();
        $pre=$totale->getPrezzo();
        $id_val=$totale->getValuta();
        $DB = \Singleton::DB();
        $sql = "UPDATE ".self::$table." SET totale=?, id_valuta=? WHERE id = ?";
        $p = $DB->prepare($sql);
        $p->bind_param("dsi", $pre, $id_val, $id_carrello);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->close();


        return $DB->lastId();   //ritorna l-id del carrello appena inserito nella tabbella items_prodotti
        //potrebbe essere che restituisce l-id del valore aggionato nel caso in cui si e eseguito il ramo IF
    }

    public static function svuotaCarrello($id){
        $DB = \Singleton::DB();
        //  la prima parte cancella lgi item del carrello
        $sql = 'DELETE FROM items_carrello WHERE id_carrello=?';
        $p = $DB->prepare($sql);
        $p->bind_param("i", $id);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->close();


        //  la seconda parte azzerra il totale del carrello, nella tabbella carrello
        $sql = "UPDATE items_carrello SET totale='0.0' WHERE id=?";
        $p = $DB->prepare($sql);
        $p->bind_param("i", $id);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->close();
    }

    public static function create(array $obj): Model{      // funzione che genera il Model a partire da un array associativo con un solo campo, id
        $r = new \Models\M_Carrello($obj["id"]);
        $items = F_Item_Carrello::getCarrelloItems($obj["id"]);
        foreach($items as $item)
            $r->addItem($item);
        return $r;
    }
}
?>
