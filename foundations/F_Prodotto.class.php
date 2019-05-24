<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class F_Prodotto extends Foundation{
    protected static $table = "prodotti";

    public static function create(array $obj): Model{
        $DB = \Singleton::DB();
        $sql = "SELECT COALESCE(id_opzione,valori.valore) AS valore, filtri.nome, filtri.tipo
            FROM valori
            LEFT JOIN filtri ON filtri.id = id_filtro
            WHERE id_prodotto = ?";
        $p = $DB->prepare($sql);
        $p->bind_param("i",$obj["id"]);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $r = array();
        $res = $p->get_result();
        $p->close();
        if($res === FALSE)
            throw new \SQLException("Error Fetching Statement", $sql, $p->error, 4);
        else
            while ($row = $res->fetch_array(MYSQLI_ASSOC)){
                if($row["tipo"] === "multicheckbox"){
                    if(!array_key_exists($row["nome"], $r))
                        $r[$row["nome"]] = array();
                    $r[$row["nome"]][] = $row["valore"];
                }else
                    $r[$row["nome"]] = $row["valore"];
            }
        return new \Models\M_Prodotto($obj["id"], $obj["nome"], F_Categoria::find($obj["id_categoria"]), new \Models\M_Money($obj["prezzo"], $obj["id_valuta"]), $r);
    }

    public static function update(Model $prodotto, array $params = array()){
        $DB = \Singleton::DB();
        $sql = "UPDATE prodotti SET nome=?, info=?, descrizione=?, id_categoria=?, prezzo=?, id_valuta=? WHERE id = ?";
        $p = $DB->prepare($sql);
        $money=$prodotto->getPrezzo();
        $categoriaid=$prodotto->getCategoriaId();
        $p->bind_param("sssiis", $prodotto->getNome(), $prodotto->getInfo(), $prodotto->getDesrizione(), $categoriaid , $money->getPrezzo(), $money->getValuta());
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->close();
    }

    public static function insert(Model $prodotto, array $params = array()): int{
        $DB = \Singleton::DB();
        $sql = "INSERTO INTO categorie VALUES(NULL, ?, ?, ?, ? ,? ,?)";
        $p = $DB->prepare($sql);
        $money=$prodotto->getPrezzo();
        $categoriaid=$prodotto->getCategoriaId();
        $p->bind_param("sssiis", $prodotto->getNome(), $prodotto->getInfo(), $prodotto->getDesrizione(), $categoriaid , $money->getPrezzo(), $money->getValuta());
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->close();
        return $DB->lastId();
    }
}
