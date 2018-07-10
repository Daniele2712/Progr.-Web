<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Categoria extends Foundation{
    protected static $table = "categorie";

    public static function create(array $obj): Model{
        return new \Models\Categoria($obj["id"], $obj["nome"], $obj["padre"]?Categoria::find($obj["padre"]):NULL);
    }

    public static function insert(Model $categoria): int{
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

    public static function update(Model $categoria){
        $DB = \Singleton::DB();
        $sql = "UPDATE categorie SET nome=?, padre=? WHERE id = ?";
        $p = $DB->prepare($sql);
        $money = $carrello->getTotale();
        $p->bind_param("sii", $categoria->getCategoria(), $categoria->getPadreid(), $categoria->getid());
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->close();
    }
    
    public static function allCategories(){
        echo "F-Categorie";
        $rows = array();
        $DB = Singleton::DB();
        $sql = "SELECT * from categorie";
        $result = $DB->query($sql);
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }
        return json_encode($rows);
        
        }

}
?>
