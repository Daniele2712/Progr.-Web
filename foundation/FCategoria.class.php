<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class FCategoria extends Foundation{
    //Attributi
    protected static $table = "categorie";
		//Metodi
    public static function getCategoriaByid(int $id){
      $ret = array();
      $result = Singleton::DB()->query("SELECT nome, padre FROM categorie WHERE id=".$id);
      if($result){
          $row = $result->fetch_array(MYSQLI_ASSOC);
              if($row["padre"]==NULL){
                  $cat=new ECategoria($row["nome"]);
                  $ret[]=$cat;
              }
              else{
                  $res_par=Singleton::DB()->query("SELECT nome FROM categorie WHERE id=".$row[padre]);
                  $row_par = $result->fetch_array(MYSQLI_ASSOC);
                  $cat=new ECategoria($row_par["nome"]);
                  $sot_cat=new ECategoria($row["nome"], $cat]);
                  $ret[]=$cat;
                  $ret[]=$sot_cat;
              }
      }
    return $ret;
    }

}
?>
