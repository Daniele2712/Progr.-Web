<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class OffertaSconto extends FOfferta{
    protected static $table = "offerte_sconti";

    protected static function load(int $idOfferta, string $tipo, \DateTime $inizio, \DateTime $fine): \Models\OffertaSconto{
        $sql = "SELECT id, id_prodotto, prezzo, valuta FROM ".self::$table." WHERE id_offerta = ?";
        $p = \Singleton::DB()->prepare($sql);
        $p->bind_param("i",$idOfferta);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->bind_result($id, $idProdotto, $prezzo, $valuta);
        $f = $p->fetch();
        $p->close();
        if($f === FALSE)
            throw new \SQLException("Error Fetching Statement", $sql, $p->error, 4);
        elseif($f === NULL)
            throw new \ModelException("Model Not Found", __CLASS__, array("username"=>$user, "password"=>$pw), 0);
        else
            return new \Models\OffertaSconto($id, $tipo, $inizio, $fine, $id, $idProdotto, $prezzo, $valuta);
    }

}
?>
