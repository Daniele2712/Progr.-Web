<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class FOffertaSconto extends FOfferta{
    protected static $table = "offerte_sconti";

    protected static function load(int $idOfferta, string $tipo, DateTime $inizio, DateTime $fine): EOffertaSconto{
        $sql = "SELECT id, id_prodotto, prezzo, valuta FROM ".self::$table." WHERE id_offerta = ?";
        $p = Singleton::DB()->prepare($sql);
        $p->bind_param("i",$idOfferta);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->bind_result($id, $idProdotto, $prezzo, $valuta);
        $f = $p->fetch();
        $p->close();
        if($f === FALSE)
            throw new \SQLException("Error Fetching Statement", $sql, $p->error, 4);
        elseif($f === NULL)
            throw new \EntityException("Entity Not Found", __CLASS__, array("username"=>$user, "password"=>$pw), 0);
        else
            return new EOffertaSconto($id, $tipo, $inizio, $fine, $id, $idProdotto, $prezzo, $valuta);
    }

}
?>
