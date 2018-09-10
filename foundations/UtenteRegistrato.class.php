<?php
namespace Foundations;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class UtenteRegistrato extends Utente{
    protected static $table = "utenti_registrati";

    public static function insert(Model $obj): int{

    }

    public static function update(Model $obj){

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
            throw new \ModelException("Model Not Found", __CLASS__, array("id"=>$id_utente), 0);
        $p->close();

        $indirizzi = Indirizzo::getIndirizziByUserId($id_utente);
        $carrello = Carrello::find($id_carrello);

        return new \Models\UtenteRegistrato($id_utente, $dati_anagrafici, $email, $username, $id, $punti, array(), $indirizzi, $carrello);
    }
}
