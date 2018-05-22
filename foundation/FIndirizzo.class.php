<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class FIndirizzo{
  protected static $table = "indirizzi";

  public static function getIndirizzoByid(int $id){
    $result = Singleton::DB()->query("SELECT id_comune, via, civico, note FROM indirizzi WHERE id=".$id);
    if($result){
      $row = $result->fetch_array(MYSQLI_ASSOC);
      $com = FComune::getComuneByid($row["id_comune"]);
      $ret = new EIndirizzo($com, $row["via"], $row["civico"], $row["note"]);
    }
    return $ret;
  }
}
?>
