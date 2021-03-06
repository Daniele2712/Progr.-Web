<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class F_Indirizzo extends Foundation{
    protected static $table = "indirizzi";

    public static function create(array $obj): Model{
        $comune = F_Comune::find($obj["id_comune"]);
        return new \Models\M_Indirizzo($obj["id"], $comune, $obj["via"], $obj["civico"], $obj["note"], $obj["latitudine"], $obj["longitudine"]);
    }

    public static function insert(Model $obj, array $params = array()): int{
        $sql = "INSERT INTO indirizzi VALUES (NULL, ?, ?, ?, ?, ?, ?)";
        $p = \Singleton::DB()->prepare($sql);
        $id_comune = $obj->getComune()->getId();
        $via = $obj->getVia();
        $civico = $obj->getCivico();
        $note = $obj->getNote();
        $lat = $obj->getLat();
        $lng =  $obj->getLng();
        $p->bind_param("isssdd", $id_comune, $via, $civico, $note, $lat, $lng);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $id = $p->insert_id;
        $p->close();
        return $id;
    }

    public static function update(Model $obj, array $params = array()): int{
        return $obj->getId();
    }
    
    public static function search(int $id_comune, string $via, int $civico){
        $DB = \Singleton::DB();
        $sql = "SELECT * FROM ".self::$table." WHERE id_comune = ? AND via = ? AND civico = ?";
        $p = $DB->prepare($sql);
        $p->bind_param("isi", $id_comune, $via, $civico);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $res = $p->get_result();
        $fetchedResul=$res->fetch_assoc();
        $p->close();
        $r = null;
        if($fetchedResul)
            $r = self::create($fetchedResul);
        return $r;
    }

    public static function getIndirizziByUserId(int $id){       //r=ti dice anche gli indirizzi preferiti   restituisce un array di indirizzi
        $p = \Singleton::DB()->prepare("
            SELECT indirizzi.id, id_comune, via, civico, note, latitudine, longitudine
            FROM indirizzi
            LEFT JOIN indirizzi_utenti ON indirizzi.id=indirizzi_utenti.id_indirizzo
            WHERE id_utente_r = ?");
        $p->bind_param("i",$id);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $res = $p->get_result();
        $p->close();
        $r = array();
        while($row = $res->fetch_assoc())
            $r[] = self::create($row);
        return $r;
    }

    public static function getIndirizzoPreferitoOfUserId(int $id){
        $p = \Singleton::DB()->prepare("
            SELECT indirizzi.id, id_comune, via, civico, note, latitudine, longitudine
            FROM indirizzi
            LEFT JOIN indirizzi_utenti ON indirizzi.id=indirizzi_utenti.id_indirizzo
            WHERE id_utente_r = ? AND preferito=1");
        $p->bind_param("i",$id);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $res = $p->get_result();
        $p->close();
        $row = $res->fetch_assoc();
        return self::create($row);  // dovrebbe essere un solo elemento...cmq, nel caso siano piu indirizzi preferiti, qui prendo il primo
    }

    public static function calcolaSpeseSpedizione(\Models\M_Indirizzo $indirizzo1, \Models\M_Indirizzo $indirizzo2 , $idValuta){
        //Mettiamo che facciamo pagare 1 euro al km.
       $EuroAlKm=1;
       $distance=$indirizzo1->distance($indirizzo2);
       $costo=$distance*$EuroAlKm;
       $monEur=new \Models\M_Money($costo,1);     //variabile di appoggio in euro che mi aiuta a calcolare il prezzo con la valuta idValuta
       return new \Models\M_Money($monEur->getPrezzo($idValuta),$idValuta);
    }
}
