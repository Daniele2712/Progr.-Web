<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class FMagazzino extends Foundation{
    protected static $table = "magazzini";
    
    public static function insert(Entity $object): int{}
    public static function update(Entity $object){}
    public static function create(array $object): Entity{}

    public static function RiempiMagazzino($id){
      $ret=array();
      $result = Singleton::DB()->query("SELECT id_gestore, id_indirizzo FROM magazzini WHERE id=".$id);
      if($result){
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $ges = FGestore::getGestoreByid($row["id_gestore"]);
        $ind = FIndirizzo::getIndirizzoByid($row["id_indirizzo"]);
        $items = FItems::getMagazzinoItems($id);
        $mag = new EMagazzino($ind, $items);
        $mag->setGestore($ges);
      }
      return $mag;
    }
    
    public static function allItems($IDmagazzino){
        
        /*   Restituisce un array di oggetti Json fatti in questo modo:

         *  {"id":"aaa","nome":"bbb","info":"ccc","descrizione":"ddd","id_categoria":"eee","prezzo":"fff","valuta":"ggg","quantita":"hhh"}
        */
        echo "F-Items";
        $rows = array();
        $DB = Singleton::DB();
        $sql = "SELECT prodotti.*,items_magazzino.quantita from prodotti, items_magazzino WHERE prodotti.id=items_magazzino.id_prodotto AND items_magazzino.id_magazzino=$IDmagazzino";
        $result = $DB->query($sql);
        while($r = mysqli_fetch_assoc($result)) {
            $rows[] = $r;
        }
        return json_encode($rows);
        }
}
?>
