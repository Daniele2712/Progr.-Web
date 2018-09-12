<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Immagine extends Foundation{
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
        else{
            $res = $p->get_result();
            while ($row = $result->fetch_array(MYSQLI_NUM))
                $r[] = Immagine::find($row[0]);
        }
        return $r;
    }

    public static function create(array $obj): Model{
        return new \Models\Immagine($obj["id"], $obj["nome"], $obj["size"], $obj["type"], $obj["immagine"]);
    }

    public static function insert(Model $obj): int{

    }

    public static function update(Model $obj){

    }
}
