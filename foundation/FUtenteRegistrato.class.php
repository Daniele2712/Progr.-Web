<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class FUtenteRegistrato extends FUtente{
    protected static $table = "utenti_registrati";

    public static function Login($user,$pw){
        return false;
    }
}
?>
