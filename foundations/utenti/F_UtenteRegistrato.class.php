<?php
namespace Foundations\Utenti;
use \Foundations\Foundation as Foundation;
use \Foundations\F_Utente as F_Utente;
use \Foundations\F_Indirizzo as F_Indirizzo;
use \Foundations\F_Carrello as F_Carrello;
use \Models\Model as Model;
use \Models\Utenti\M_UtenteRegistrato as M_UtenteRegistrato;
use \Models\M_DatiAnagrafici as M_DatiAnagrafici;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class F_UtenteRegistrato extends Foundation{
    protected static $table = "utenti_registrati";

    public static function insert(\Models\Model $obj, array $params = array()): int{
        $DB = \Singleton::DB();
        $id = $obj->getId();
        $punti = $obj->getPunti();
        $idCarrello = \Foundations\F_Carrello::save($obj->getCarrello());
        $sql = "INSERT INTO ".self::$table." VALUES(NULL, ?, ?, ?);";
        $p = $DB->prepare($sql);
        $p->bind_param("iii", $id, $punti, $idCarrello);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->close();
        $idRegistrato = $DB->lastId();
        $indPreferito = $obj->getIndirizzoPreferito();
        $sql = "INSERT INTO indirizzi_utenti VALUES(NULL, ?, ?, ?);";
        $p = $DB->prepare($sql);
        foreach($obj->getIndirizzi() as $indirizzo){
            $idInd = \Foundations\F_Indirizzo::save($indirizzo);
            $pref = $indPreferito->equals($indirizzo);
            $p->bind_param("iii", $id, $idInd, $pref);
            if(!$p->execute())
                throw new \SQLException("Error Executing Statement", $sql, $p->error, 4);
            $p->close();
        }
        return $idRegistrato;
    }

    public static function update(\Models\Model $obj, array $params = array()): int{
        $DB = \Singleton::DB();
        $id = $obj->getId();
        $punti = $obj->getPunti();
        $carrello = $obj->getCarrello();
        $idCarrello = \Foundations\F_Carrello::save($carrello);

        $idRegistrato = $obj->getIdRegistrato();

        $sql = "UPDATE ".self::$table." SET id_utente = ?, punti = ?, id_carrello = ? WHERE id = ?;";
        $p = $DB->prepare($sql);
        $p->bind_param("iiii", $id, $punti, $idCarrello, $idRegistrato);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->close();
        return $idRegistrato;
    }

    public static function create(array $obj): Model{
        $id_utente = $obj["id"];
        $dati_anagrafici = $obj["dati"];
        $email = $obj["email"];
        $username = $obj["username"];
        $password = $obj["password"];
        $idValuta = $obj["valuta"];
        $sql = "SELECT id, punti, id_carrello FROM ".self::$table." WHERE id_utente = ?";
        $p = \Singleton::DB()->prepare($sql);
        $p->bind_param("i",$id_utente);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->bind_result($id, $punti, $id_carrello);
        $r = $p->fetch();
        if($r === FALSE)
            throw new \SQLException("Error Fetching Statement", $sql, $p->error, 4);
        elseif($r === NULL)
            throw new \SQLException("Empty Result", $sql, 0, 8);
        $p->close();

        //Indirizzo preferito
        $sql = "SELECT id_indirizzo FROM indirizzi_utenti WHERE id_utente_r = ? AND preferito = 1";
        $p = \Singleton::DB()->prepare($sql);
        $p->bind_param("i",$id_utente);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->bind_result($id_indirizzo_preferito);
        $r = $p->fetch();
        if($r === FALSE)
            throw new \SQLException("Error Fetching Statement", $sql, $p->error, 4);
        elseif($r === NULL)
            throw new \SQLException("Empty Result", $sql, $id_utente, 8);
        $p->close();

        $indirizzo_preferito = F_Indirizzo::find($id_indirizzo_preferito);
        $indirizzi = F_Indirizzo::getIndirizziByUserId($id_utente);
        $carrello = F_Carrello::find($id_carrello);

        return new M_UtenteRegistrato($id_utente, $dati_anagrafici, $email, $username, $password, $id, $punti, array(), $indirizzi, $indirizzo_preferito, $carrello);
    }

    public static function addAddress(int $id_user, int $id_addr){
        $sql = "INSERT INTO indirizzi_utenti VALUES (NULL, ?, ?, 0)";
        $p = \Singleton::DB()->prepare($sql);
        $p->bind_param("ii",$id_user, $id_addr);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->close();
    }

    public static function isUtenteRegistrato($id){
        $sql = "SELECT id FROM ". self::$table." WHERE id_utente=?";
        $p = \Singleton::DB()->prepare($sql);
        $p->bind_param("i",$id);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $num=$p->get_result()->num_rows;
        $p->close();
        if($num>0) return true;
        else return false;
    }
}
