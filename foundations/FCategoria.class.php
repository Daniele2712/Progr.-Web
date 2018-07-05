<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class FCategoria extends Foundation{
    protected static $table = "categorie";

    public static function create(array $obj): Entity{
        return new ECategoria($obj["id"], $obj["nome"], $obj["padre"]?FCategoria::find($obj["padre"]):NULL);
    }

    public static function insert(Entity $categoria): int{
        $DB = Singleton::DB();
        $sql = "INSERTO INTO categorie VALUES(NULL, ?, ?)";
        $p = $DB->prepare($sql);
        $money=$carrello->getTotale();
        $p->bind_param("si", $categoria->getCategoria(), $categoria->getPadreid());
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 1);
        $p->close();
        return $DB->lastId();
    }

    public static function update(Entity $categoria){
        $DB = Singleton::DB();
        $sql = "UPDATE categorie SET nome=?, padre=? WHERE id = ?";
        $p = $DB->prepare($sql);
        $money = $carrello->getTotale();
        $p->bind_param("sii", $categoria->getCategoria(), $categoria->getPadreid(), $categoria->getid());
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 1);
        $p->close();
    }
}
?>
