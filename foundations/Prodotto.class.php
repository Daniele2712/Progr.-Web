<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Prodotto extends Foundation{
    protected static $table = "prodotti";

    public static function create(array $obj): Model{
        return new \Models\Prodotto($obj["id"], $obj["nome"], Categoria::find($obj["id_categoria"]), new \Models\Money($obj["prezzo"], $obj["valuta"]));
    }

    public static function update(Model $prodotto){
        $DB = \Singleton::DB();
        $sql = "UPDATE prodotti SET nome=?, info=?, descrizione=?, id_categoria=?, prezzo=?, valuta=? WHERE id = ?";
        $p = $DB->prepare($sql);
        $money=$prodotto->getPrezzo();
        $categoriaid=$prodotto->getCategoriaId();
        $p->bind_param("sssiis", $prodotto->getNome(), $prodotto->getInfo(), $prodotto->getDesrizione(), $categoriaid , $money->getPrezzo(), $money->getValuta());
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->close();
    }

    public static function insert(Model $prodotto): int{
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
