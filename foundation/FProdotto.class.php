<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class FProdotto extends Foundation{
    //Attributi
    protected static $table = "prodotti";
    //Metodi
    public static function getProdottoByid($id){
        $ret = array();
        $results = Singleton::DB()->query("SELECT nome FROM prodotti WHERE id=".$id);
    }
}
?>
