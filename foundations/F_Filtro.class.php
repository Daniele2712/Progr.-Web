<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class F_Filtro extends Foundation{
    protected static $table = "filtri";

    public static function findInCat(int $idCat = 0):array{
        $DB = \Singleton::DB();
        if($idCat === 0){
            $categorie = array();
            $sql = "SELECT * FROM filtri WHERE id_categoria IS NULL AND filtrabile = 1";
            $p = $DB->prepare($sql);
        }else{
            $categorie = Categoria::find($idCat)->getAncestors();
            $sql = "SELECT * FROM filtri WHERE (id_categoria IS NULL OR id_categoria IN (" .
                    implode(",", array_fill(0, count($categorie), "?")) . ")) AND filtrabile = 1";
            $p = $DB->prepare($sql);
            $args = array_merge(array(str_repeat("i", count($categorie))), $categorie);   // array("iiiii...", 1, 2, 3, ...)
            call_user_func_array(array($p, 'bind_param'), self::ref($args));              // $p->bind_param(...)
        }
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $r = array();
        $res = $p->get_result();
        $p->close();
        if($res === FALSE)
            throw new \SQLException("Error Fetching Statement", $sql, $p->error, 4);
        else
            while ($row = $res->fetch_array(MYSQLI_ASSOC)){     //cerco filtri con lo stesso nome per implementare
                $f = FALSE;                                     //una specie di overload dei filtri
                foreach($r as $k => $filtro)                    //cerco il filtro con lo stesso nome
                    if($filtro->getNome() === $row["nome"])
                        $f = $k;
                if($f === FALSE)
                    $r[] = self::create($row);                  //se non lo trovo aggiungo il filtro
                else
                    $r[$f] = self::create($row);                //altrimenti lo sostituisco
            }                   //i filtri sono ordinati per discendenza, quindi quando li sostituisco
                                //sostituisco sempre il filtro di una categoria più generica, con il filtro di una Categoria
                                //più specifica (discendente dall'altra per intenderci)

        return $r;
    }

    public static function insert(Model $obj): int{

    }

    public static function update(Model $obj){

    }

    public static function create(array $obj): Model{
        $DB = \Singleton::DB();
        $sql = "SELECT * FROM opzioni WHERE id_filtro = ?";
        $p = $DB->prepare($sql);
        $p->bind_param("i", $obj["id"]);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $opzioni = array();
        $res = $p->get_result();
        $p->close();
        if($res === FALSE)
            throw new \SQLException("Error Fetching Statement", $sql, $p->error, 4);
        else
            while ($row = $res->fetch_array(MYSQLI_ASSOC))
                $opzioni[] = array("id"=>$row["id"], "nome"=>$row["valore"]);
        return new \Models\M_Filtro($obj["id"], $obj["nome"], $obj["filtrabile"], $obj["tipo"], ($obj["id_categoria"] === NULL ? NULL : Categoria::find($obj["id_categoria"])), $opzioni);
    }

    /**
     * metodo per trasformare un array di valori in un array di reference di valori
     *
     * @param     array    $arr    array di valori
     * @return    array            array di reference di valori
     */
    private static function ref(array $arr):array{
        $refs = array();
        foreach($arr as $key => $val)
            $refs[$key] = &$arr[$key];
        return $refs;
    }
}
