<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class FDatiAnagrafici extends Foundation{
    protected static $table = "dati_anagrafici";

    public static function all(){
        $ret = array();
        $result = Singleton::DB()->query("SELECT * FROM $table");
        if($result)
            while($row = $result->fetch_array(MYSQLI_ASSOC))
                $ret[] = new EDatiAnagrafici($row["id"], $row["nome"], $row["cognome"], $row["telefono"], $row["data_nascita"]);
        return $ret;
    }
}
?>
