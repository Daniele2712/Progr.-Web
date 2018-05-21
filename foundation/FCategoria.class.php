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
      $results = Singleton::DB()->query("SELECT nome, padre FROM categorie WHERE id=$id");

    }

}
?>
