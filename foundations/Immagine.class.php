<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Immagini extends Foundation{
    protected static $table = "immagini";

    public static function getImmaginiProdotto(int $id): array{
        $DB = \Singleton::DB();
        $sql = "SELECT id_immagine FROM immagini_prodotti WHERE id_prodotto = ?";
        $p = $DB->prepare($sql);
        $p->bind_param("i",$id);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->bind_result($id_immagine);
        $r = array();
        $f = $p->fetch();
        $p->close();
        if($f === FALSE)
            throw new \SQLException("Error Fetching Statement", $sql, $p->error, 4);
        elseif($f === NULL)
            throw new \ModelException("Model Not Found", __CLASS__, array("id_prodotto"=>$id), 0);
        else
            foreach($id_immagine as $id)                    //TODO: questa non funziona usare get_result e ciclare
                $r[] = Immagine::find($id);
        return $r;
    }
}
?>
