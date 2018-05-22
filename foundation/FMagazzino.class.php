<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class FMagazzino extends Foundation{
    protected static $table = "magazzini";

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
?>
