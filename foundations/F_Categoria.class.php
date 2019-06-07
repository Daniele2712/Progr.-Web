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
        $sql = "INSERT INTO categorie VALUES(NULL, ?, ?)";
        $p = $DB->prepare($sql);
        $money=$carrello->getTotale();
        $p->bind_param("si", $categoria->getCategoria(), $categoria->getFather()->getId());
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->close();
        return $DB->lastId();
    }

    public static function update(Model $categoria, array $params = array()): int{
        $DB = \Singleton::DB();
        $sql = "UPDATE categorie SET nome=?, padre=? WHERE id = ?";
        $p = $DB->prepare($sql);
        $money = $carrello->getTotale();
        $p->bind_param("sii", $categoria->getCategoria(), $categoria->getFather()->getId(), $categoria->getid());
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->close();
        return $categoria->getid();
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
    public static function seekName(string $name): bool{
        $DB = \Singleton::DB();
        $sql = "SELECT * FROM ".static::$table." WHERE nome = ?";
        $p = $DB->prepare($sql);
        $p->bind_param('s',$name);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $res = $p->get_result();
        $p->close();
        return $res && $res->num_rows===1;
    }

    public static function idToName(int $id){
      $DB = \Singleton::DB();
      $sql = "SELECT nome FROM ".static::$table." WHERE id = ?";
      $p = $DB->prepare($sql);
      $p->bind_param('i',$id);
      if(!$p->execute())
          throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
      $res = $p->get_result();
      $p->close();
      return $res && $res->num_rows===1;
    }

    public static function nameToId(string $nome){
      $DB = \Singleton::DB();
      $sql = "SELECT id FROM ".static::$table." WHERE nome = ?";
      $p = $DB->prepare($sql);
      $p->bind_param('s',$name);
      if(!$p->execute())
          throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
      $res = $p->get_result();
      $p->close();
      return $res;
    }


    public static function findSubcategories(int $idCat){
        $rows = array();
        $DB = \Singleton::DB();
        $sql = "SELECT * from categorie WHERE padre = ?";
        $p = $DB->prepare($sql);
        $p->bind_param("i", $idCat);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $res = $p->get_result();
        $p->close();
        while($row = mysqli_fetch_assoc($res))
            $rows[] = self::create($row);
        return $rows;
    }

}
?>
