<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class F_Categoria extends Foundation{
    protected static $table = "categorie";

    public static function create(array $obj): Model{
        return new \Models\M_Categoria($obj["id"], $obj["nome"], $obj["padre"]?F_Categoria::find($obj["padre"]):NULL);
    }

    public static function insert(Model $categoria, array $params = array()): int{
        $DB = \Singleton::DB();
        $sql = "INSERTO INTO categorie VALUES(NULL, ?, ?)";
        $p = $DB->prepare($sql);
        $money=$carrello->getTotale();
        $p->bind_param("si", $categoria->getCategoria(), $categoria->getPadreid());
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->close();
        return $DB->lastId();
    }

    public static function update(Model $categoria, array $params = array()){
        $DB = \Singleton::DB();
        $sql = "UPDATE categorie SET nome=?, padre=? WHERE id = ?";
        $p = $DB->prepare($sql);
        $money = $carrello->getTotale();
        $p->bind_param("sii", $categoria->getCategoria(), $categoria->getPadreid(), $categoria->getid());
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->close();
    }

    public static function findMainCategories(){
        $rows = array();
        $DB = \Singleton::DB();
        $sql = "SELECT * from categorie WHERE padre IS NULL";
        $result = $DB->query($sql);
        while($row = mysqli_fetch_assoc($result)) {
            $rows[] = self::create($row);
        }
        return $rows;
    }

}
?>
