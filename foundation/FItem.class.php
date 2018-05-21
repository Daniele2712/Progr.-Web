<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class FItem extends Foundation{
    protected static $table = "items";

    public static function getCarrelloItems(int $id){
      $ret=array();
      $results = Singleton::DB()->query("SELECT  FROM  WHERE locazione=C AND id=$id");
    }

}
?>
