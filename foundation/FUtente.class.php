<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class FUtente extends FDatiAnagrafici{
    protected static $table = "utenti";

    public static function Login($user,$pw){
        return false;
    }
}
?>
