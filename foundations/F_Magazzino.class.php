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
        $result = \Singleton::DB()->query("SELECT id_gestore, id_indirizzo FROM ".self::$table." WHERE id=".$id);
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

    public static function findClosestTo($addr):\Models\M_Magazzino{
        $addr_arr = self::getIndirizzi();
        $dis = \Singleton::Settings()->getMaxShippingDistance();
        $mag_fin = NULL;
        foreach($addr_arr as $k=>$addr){
            $ret = $addr->distance($addr);
            if($ret <= $dis){
               $dis = $ret;
               $mag_fin = $k;
           }
        }
        if($mag_fin === NULL)
            throw new \ModelException("Closest Magazzino not found", __CLASS__, array("addr_id"=>$addr->getId()), 0);
        return self::find($mag_fin);
    }

    public static function getIndirizzi(): array{
        $DB = \Singleton::DB();
        $sql = "SELECT id, id_indirizzo FROM ".self::$table;
        $p = $DB->prepare($sql);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $r = array();
        $res = $p->get_result();
        $p->close();
        if($res === FALSE)
            throw new \SQLException("Error Fetching Statement", $sql, $p->error, 4);
        else
            while ($row = $res->fetch_array(MYSQLI_NUM))
                $r[$row[0]] = F_Indirizzo::find($row[1]);
        return $r;
    }

    public static function insert(Model $mag, array $params = array()): int{
        return 0;
    }

    public static function update(Model $mag, array $params = array()): int{
        return 0;
    }

    public static function create(array $obj):Model{
        $ind = F_Indirizzo::find($obj["id_indirizzo"]);
        $items = F_Item_Magazzino::getMagazzinoItems($obj["id"]);
        $ges = Utenti\F_Dipendente::find($obj["id_gestore"]);
        return new \Models\M_Magazzino($obj["id"], $ind, $items, $ges);
    }

    public static function sellItem(\Models\M_Item $item, int $id_magazzino){
        $ret = array();
        $DB = \Singleton::DB();
        $sql = "INSERT INTO prodotti_venduti VALUES (null, ?, ?, ?, ?)";
        $p = $DB->prepare($sql);
        $id = $item->getProdotto()->getId();
        $qta = $item->getQuantita();
        $data = date("Y-m-d");
        $p->bind_param("iisi", $id, $qta, $data, $id_magazzino);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->close();
    }
}
