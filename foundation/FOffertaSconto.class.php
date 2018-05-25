<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class FOffertaSconto extends FOfferta{
    protected static $table = "offerte_sconti";

    protected static function load(int $idOfferta, string $tipo, DateTime $inizio, DateTime $fine){
        $p = Singleton::DB()->prepare("
            SELECT id, id_prodotto, prezzo, valuta
            FROM ".self::$table."
            WHERE id_offerta = ?");
        $p->bind_param("i",$idOfferta);
        $p->execute();
        $p->bind_result($id, $idProdotto, $prezzo, $valuta);
        $r = null;
        if($p->fetch()){
            $p->close();
            $r = new EOffertaSconto($id, $tipo, $inizio, $fine, $id, $idProdotto, $prezzo, $valuta);
        }else
            $p->close();
        return $r;
    }

}
?>
