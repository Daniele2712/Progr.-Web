<?php
class FCarrello{
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
