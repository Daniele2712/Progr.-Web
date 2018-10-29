<?php
namespace Foundations;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class UtenteRegistrato extends Utente{
    protected static $table = "utenti_registrati";

    public static function insert(\Models\Model $obj): int{

    }

    public static function update(\Models\Model $obj){

    }

    public static function create_user(int $id_utente, \Models\DatiAnagrafici $dati_anagrafici, string $email, string $username): \Models\UtenteRegistrato{
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
            throw new \SQLException("Empty Result", $sql, 0, 8);
        $p->close();

        $indirizzo_preferito = Indirizzo::find($id_indirizzo_preferito);
        $indirizzi = Indirizzo::getIndirizziByUserId($id_utente);
        $carrello = Carrello::find($id_carrello);

        return new \Models\UtenteRegistrato($id_utente, $dati_anagrafici, $email, $username, $id, $punti, array(), $indirizzi, $indirizzo_preferito, $carrello);
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
