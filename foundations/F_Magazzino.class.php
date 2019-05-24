<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class F_Magazzino extends Foundation{
    protected static $table = "magazzini";

    public static function RiempiMagazzino($id){
        $ret=array();
        $result = \Singleton::DB()->query("SELECT id_gestore, id_indirizzo FROM magazzini WHERE id=".$id);
        if($result){
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $ges = Dipendente::find($row["id_gestore"]);
            $ind = Indirizzo::find($row["id_indirizzo"]);
            $items = Items_Magazzino::getMagazzinoItems($id);
            $mag = new \Models\M_Magazzino($ind, $items);
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

    public static function insert(Model $mag, array $params = array()): int{
      $indirizzo=$mag->getIndirizzo();
      if($indirizzo) $idIndirizzo=$indirizzo->getId();
      $gestore=$mag->getResponsabile();
      if($gestore) $id_gestore=$gestore->getId();
      else $id_gestore=NULL;

      $DB = \Singleton::DB();
      $sql = "INSERT INTO ".self::$table." VALUES(NULL,?,?);";
      $p = $DB->prepare($sql);
      $p->bind_param("ii", $id_gestore, $idIndirizzo);
      if(!$p->execute())
          throw new \SQLException("Error Executing Statementdasdsa", $sql, $p->error, 3);
      $p->close();
      $id = $DB->lastId();
      return $id;
    }

    public static function update(Model $mag, array $params = array()){
    }

    public static function create(array $obj):Model{
        $ind = F_Indirizzo::find($obj["id_indirizzo"]);
        $items = F_Item_Magazzino::getMagazzinoItems($obj["id"]);
        $ges = Utenti\F_Dipendente::find($obj["id_gestore"]);
        return new \Models\M_Magazzino($obj["id"], $ind, $items, $ges);
    }
}
