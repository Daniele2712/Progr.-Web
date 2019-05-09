<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class F_Immagine extends Foundation{
    protected static $table = "immagini";

    public static function findByProduct(int $id): array{
        $DB = \Singleton::DB();
        $sql = "SELECT id_immagine FROM immagini_prodotti WHERE id_prodotto = ?";
        $p = $DB->prepare($sql);
        $p->bind_param("i",$id);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->bind_result($id_immagine);
        $r = array();
        $res = $p->get_result();
        $p->close();
        if($res === FALSE)
            throw new \SQLException("Error Fetching Statement", $sql, $p->error, 4);
        else
            while ($row = $res->fetch_array(MYSQLI_NUM))
                $r[] = $row[0];
        return F_Immagine::findMany($r);
    }

    public static function findFavouriteByProduct(int $id): \Models\M_Immagine{
        $DB = \Singleton::DB();
        $sql = "SELECT id_immagine FROM immagini_prodotti WHERE id_prodotto = ? AND preferita = 1";
        $p = $DB->prepare($sql);
        $p->bind_param("i",$id);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $res = $p->get_result();
        $p->close();
        if($res === FALSE)
            throw new \SQLException("Error Fetching Statement", $sql, $p->error, 4);
        else{
            if($res->num_rows==0)
                throw new \SQLException("Empty Result", $sql, 0, 8);
            elseif($res->num_rows>1)
                throw new \SQLException("Too Much Results", $sql, $res->num_rows, 9);
            else{
                $row = $res->fetch_array(MYSQLI_NUM);
                $r = F_Immagine::find($row[0]);
            }
        }
        return $r;
    }

    public static function create(array $obj): Model{
        return new \Models\M_Immagine($obj["id"], $obj["nome"], $obj["size"], $obj["type"], $obj["immagine"]);
    }

    public static function insert(Model $obj): int{

    }

    public static function update(Model $obj){

    }
}
