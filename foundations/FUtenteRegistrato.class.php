<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class FUtenteRegistrato extends FUtente{
    protected static $table = "utenti_registrati";

    public static function create_user(int $id_utente, EDatiAnagrafici $dati_anagrafici, string $email, string $username): EUtenteRegistrato{
        $sql = "SELECT id, punti, id_carrello FROM ".self::$table." WHERE id_utente = ?";
        $p = Singleton::DB()->prepare($sql);
        $p->bind_param("i",$id_utente);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 1);
        $p->bind_result($id, $punti, $id_carrello);
        $r = null;
        if(!$p->fetch())
            throw new \SQLException("Error Fetching Statement", $sql, $p->error, 1);
        $p->close();

        $indirizzi = FIndirizzo::getIndirizziByUserId($id_utente);
        $carrello = FCarrello::find($id_carrello);

        return new EUtenteRegistrato($id_utente, $dati_anagrafici, $email, $username, $id, $punti, array(), $indirizzi, $carrello);
    }
}
?>
