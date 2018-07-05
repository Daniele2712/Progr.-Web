<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class FProdotto extends Foundation{
    //Attributi
    protected static $table = "prodotti";
    //Metodi
    public static function getProdottoByid($id){
        $result = Singleton::DB()->query("SELECT * FROM prodotti WHERE id=".$id);
        if($result){
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $cat_ar = array();
            $cat_ar = FCategoria::getCategoriaByid($row["id_categoria"]);
            if(count($cat_ar)==2)
              $cat = $cat_ar[1];
            else
              $cat = $cat_ar[0];
            $pre = new EMoney($row["prezzo"], $row["valuta"]);
            $pro = new EProdotto($row["nome"], $cat, $pre);
            $pro->setInfo($row["info"]);
            $pro->setDescrizione($row["descrizione"]);
            return $pro;
        }
    }

    public static function find(int $id){
        $DB = Singleton::DB();
        $p = $DB->prepare("
        SELECT *
        FROM prodotti
        WHERE prodotti.id = ?");
        if(!$p){
            var_dump($p);
            echo $DB->error();
            die();
        }
        $p->bind_param("i",$id);
        $p->execute();
        $p->bind_result($id, $nome, $info, $descrizione, $id_categoria, $valuta, $prezzo);
        $r = null;
        if($p->fetch()){
            $p->close();
            $r = new EProdotto($nome,NULL , new EMoney($prezzo, $valuta));
            $r->setInfo($info);
            $r->setDescrizione($descrizione);
        }else
        $p->close();
        return $r;
    }

    public static function create(EProdotto $prodotto):int{
        $DB = Singleton::DB();
        $p = $DB->prepare("
        INSERTO INTO categorie
        VALUES(NULL, ?, ?, ?, ? ,? ,?)");
        if(!$p){
            var_dump($p);
            echo $DB->error();
            die();
        }
        $money=$prodotto->getPrezzo();
        $categoriaid=$prodotto->getCategoriaId();
        $p->bind_param("sssiis", $prodotto->getNome(), $prodotto->getInfo(), $prodotto->getDesrizione(), $categoriaid , $money->getPrezzo(), $money->getValuta());
        $r = 0;
        if($p->execute())
        $r = $DB->lastId();
        $p->close();
        return $r;
    }

    public static function store(EProdotto $prodotto){
        $DB = Singleton::DB();
        $p = $DB->prepare("
        UPDATE prodotti
        SET nome=?, info=?, descrizione=?, id_categoria=?, prezzo=?, valuta=?
        WHERE prodotti.id = ?");
        if(!$p){
            var_dump($p);
            echo $DB->error();
            die();
        }
        $money=$prodotto->getPrezzo();
        $categoriaid=$prodotto->getCategoriaId();
        $p->bind_param("sssiis", $prodotto->getNome(), $prodotto->getInfo(), $prodotto->getDesrizione(), $categoriaid , $money->getPrezzo(), $money->getValuta());
        $r=$p->execute();
        $p->close();
        if(!$r)
            return $r;
        }
        return true;
    }
}
?>
