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
}
?>