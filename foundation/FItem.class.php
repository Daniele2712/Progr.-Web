<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class FItem extends Foundation{
    protected static $table = "items";

    public static function getCarrelloItems(int $id){
      $ret=array();
      $result = Singleton::DB()->query("SELECT id_prodotto, totale, valuta, quantita FROM items WHERE locazione='C' AND id=".$id);
      if($result){
          while($row = $result->fetch_array(MYSQLI_ASSOC)){
              $pro = FProdotto::getProdottoByid($row["id_prodotto"]);
              $pre = new EMoney($row["totale"], $row["valuta"]);
              $item = new EItem($pro, $pre, $row["quantita"]);
              $ret[] = $item;
          }
      }
      return $ret;
    }
}
