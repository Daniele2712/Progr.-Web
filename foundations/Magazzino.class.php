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
        $ges = Dipendente::find($row["id_gestore"]);
        $ind = Indirizzo::find($row["id_indirizzo"]);
        $items = Items::getMagazzinoItems($id);
        $mag = new \Models\Magazzino($ind, $items);
        $mag->setGestore($ges);
      }
      return $mag;
    }

    public static function findClosestTo($addr){
        $result = \Singleton::DB()->query("SELECT id_indirizzo FROM ".self::$table);
        if($result){
            while($row = $result->fetch_assoc())
                $id[] = $row["id_indirizzo"];
            $mag_arr = self::findMany($id);
            $dis = NULL;
            foreach($mag_arr as $mag){
                $ret = $addr->distance($mag->getIndirizzo());
                if($ret < $dis || $dis === NULL){
                   $dis = $ret;
                   $mag_fin = $mag;
               }
           }
        }
        return $mag_fin;
    }

    public static function insert(Model $mag): int{
        return 0;
    }

    public static function update(Model $mag){
    }

    public static function create(array $obj):Model{
        $ind = Indirizzo::find($obj["id_indirizzo"]);
        $items = Item::getMagazzinoItems($obj["id"]);
        $ges = Dipendente::find($obj["id_gestore"]);
        return new \Models\Magazzino($obj["id"], $ind, $items, $ges);
    }
}
