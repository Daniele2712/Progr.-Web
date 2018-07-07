<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Magazzino extends Foundation{
    protected static $table = "magazzini";

    public static function RiempiMagazzino($id){
      $ret=array();
      $result = \Singleton::DB()->query("SELECT id_gestore, id_indirizzo FROM magazzini WHERE id=".$id);
      if($result){
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $ges = Gestore::getGestoreByid($row["id_gestore"]);
        $ind = Indirizzo::getIndirizzoByid($row["id_indirizzo"]);
        $items = Items::getMagazzinoItems($id);
        $mag = new \Models\Magazzino($ind, $items);
        $mag->setGestore($ges);
      }
      return $mag;
    }
}
