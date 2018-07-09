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

    public static function findClosestTo($addr){
        $dis="0 km";
        $arr=array();
        $mag_arr=array();
        $id=array();
        $result = \Singleton::DB()->query("SELECT id_indirizzo FROM magazzini");
        if($result){
            while($row = $result->fetch_array(MYSQLI_ASSOC)){
                $id[] = $row["id_indirizzo"];
            }
            $mag_arr=self::findMany($id);
            //print_r($mag_arr);
            for($i=0;$i<count($mag_arr);$i++){
                $ind = $mag_arr[$i]->getIndirizzo();
                $url='https://maps.googleapis.com/maps/api/distancematrix/json?origins='
                    .urlencode($addr->getVia()).','.urlencode($addr->getComune()->getNome()).
                    ',Italia&destinations='
                    .urlencode($ind->getVia()).','.urlencode($ind->getComune()->getNome()).
                    ',Italia&mode=driving&language=it';
                $data = file_get_contents($url);
                $arr = json_decode($data, true);
                $ret = $arr["rows"][0]["elements"][0]["distance"]["text"];
                if($dis="0 km" || $ret<$dis)
                   $dis=$ret;
                   $mag_fin=$mag_arr[$i];
            }
        }
        return $mag_fin;
    }
    public static function insert(Model $obj): int{}
    public static function update(Model $obj){}
    public static function create(array $obj): Model{
        $ind = Indirizzo::find($obj["id_indirizzo"]);
        $items = Item::getMagazzinoItems($obj["id"]);
        $ges = Gestore::find($obj["id_gestore"]);
        $r = new \Models\Magazzino($ind, $ges, $items);
        return $r;
    }
}
