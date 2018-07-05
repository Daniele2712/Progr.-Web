<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class FCategoria extends Foundation{
    //Attributi
    protected static $table = "categorie";
		//Metodi
    public static function getCategoriaByid(int $id){
      $ret = array();
      $result = Singleton::DB()->query("SELECT nome, padre FROM categorie WHERE id=".$id);
      if($result){
          $row = $result->fetch_array(MYSQLI_ASSOC);
              if($row["padre"]==NULL){
                  $cat=new ECategoria($row["nome"]);
                  $ret[]=$cat;
              }
              else{
                  $res_par=Singleton::DB()->query("SELECT nome FROM categorie WHERE id=".$row["padre"]);
                  $row_par = $res_par->fetch_array(MYSQLI_ASSOC);
                  $cat=new ECategoria($row_par["nome"]);
                  $sot_cat=new ECategoria($row["nome"], $cat);
                  $ret[]=$cat;
                  $ret[]=$sot_cat;
              }
      }
    return $ret;
    }
    public static function find(int $id){
        $DB = Singleton::DB();
        $p = $DB->prepare("
        SELECT *
        FROM categorie
        WHERE categorie.id = ?");
        if(!$p){
            var_dump($p);
            echo $DB->error();
            die();
        }
        $p->bind_param("i",$id);
        $p->execute();
        $p->bind_result($id, $nome, $padre);
        $r = null;
        if($p->fetch()){
            $p->close();
            $r = new ECategoria($nome);
        }else
        $p->close();
        return $r;
    }

    public static function create(ECategoria $categoria):int{
        $DB = Singleton::DB();
        $p = $DB->prepare("
        INSERTO INTO categorie
        VALUES(NULL, ?, ?)");
        if(!$p){
            var_dump($p);
            echo $DB->error();
            die();
        }
        $money=$carrello->getTotale();
        $p->bind_param("si", $categoria->getCategoria(), $categoria->getPadreid());
        $r = 0;
        if($p->execute())
        $r = $DB->lastId();
        $p->close();
        return $r;
    }
    public static function store(ECategoria $categoria){
        $DB = Singleton::DB();
        $p = $DB->prepare("
        UPDATE categorie
        SET nome=?, padre=?
        WHERE categorie.id = ?");
        if(!$p){
            var_dump($p);
            echo $DB->error();
            die();
        }
        $money=$carrello->getTotale();
        $p->bind_param("sii", $categoria->getCategoria(), $categoria->getPadreid(), $categoria->getid());
        $r=$p->execute();
        $p->close();
        if(!$r)
            return $r;
        }
        return true;
    }
}
?>
