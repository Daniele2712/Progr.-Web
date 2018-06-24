<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class FComune extends Foundation{
  protected static $table = "comuni";

  public static function getComuneByid(int $id){
    $result = Singleton::DB()->query("SELECT CAP, nome, provincia FROM comuni WHERE id=".$id);
    if($result){
      $row = $result->fetch_array(MYSQLI_ASSOC);
      $com = new EComune($row["nome"], $row["CAP"], $row["provincia"]);
    }
    return $com;
  }
}
?>
