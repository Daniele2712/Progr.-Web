<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class FCarrello extends Foundation{
    protected static $table = "carrelli";

	  public static function all(){
        $ret = array();
        $results = Singleton::DB()->query("SELECT * FROM carrelli");
        if($result){
            while($row = $result->fetch_array()){
                $carrello = new ECarrello($row["id"]);
                $items = FItem::getCarrelloItems($row["id"]);
                foreach($items as $item){
                    $carrello->addItem($item);
                }
                $ret[] = $carrello;
            }
        }
        return $ret;
    }
}
?>
