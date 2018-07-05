<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class FUtenteRegistrato extends FUtente{
    protected static $table = "utenti_registrati";

    public static function load(int $id_utente, EDatiAnagrafici $dati_anagrafici, string $email, string $username){
        $p = Singleton::DB()->prepare("
            SELECT id, punti
            FROM ".self::$table."
            WHERE id_utente = ?");
        $p->bind_param("i",$id_utente);
        $p->execute();
        $p->bind_result($id, $punti);
        $r = null;
        if(!$p->fetch())
            die("Error fetching utente registrato");
        $p->close();

        $indirizzi = FIndirizzo::getIndirizziByUserId($id_utente);

        $r = new EUtenteRegistrato($id_utente, $dati_anagrafici, $email, $username, $id, $punti, array(), $indirizzi, 1);
        return $r;
    }
}
?>
