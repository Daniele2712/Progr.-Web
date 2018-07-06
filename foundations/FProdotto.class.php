<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class FProdotto extends Foundation{
    protected static $table = "prodotti";

    public static function create(array $obj): Entity{
        return new EProdotto($obj["id"], $obj["nome"], FCategoria::find($obj["id_categoria"]), new EMoney($obj["prezzo"], $obj["valuta"]));
    }

    public static function update(Entity $prodotto){
        $DB = Singleton::DB();
        $sql = "UPDATE prodotti SET nome=?, info=?, descrizione=?, id_categoria=?, prezzo=?, valuta=? WHERE id = ?";
        $p = $DB->prepare($sql);
        $money=$prodotto->getPrezzo();
        $categoriaid=$prodotto->getCategoriaId();
        $p->bind_param("sssiis", $prodotto->getNome(), $prodotto->getInfo(), $prodotto->getDesrizione(), $categoriaid , $money->getPrezzo(), $money->getValuta());
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->close();
    }

    public static function insert(Entity $prodotto): int{
        $DB = Singleton::DB();
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
?>
