<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class FItem extends Foundation{
    protected static $table = "items";

    public static function getCarrelloItems(int $id){
      $ret=array();
      $results = Singleton::DB()->query("SELECT id_prodotto, prezzo, valuta, quantita FROM items WHERE locazione=C AND id=".$id);
      if($result){
          while($row = $result->fetch_array(MYSQLI_ASSOC)){
              $pro = getProdottoByid($row["id_prodotto"]);
              $pre = new EMoney($row["prezzo"], $row["valuta"]);
              $item = new EItem($pro, $pre, $row["quantita"]);
              $ret[] = $item;
          }
      }
      return $ret;
    }
}
?>
