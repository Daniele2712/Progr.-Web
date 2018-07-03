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

    public static function create(EDatiAnagrafici $dati_anagrafici):int{
        $DB = Singleton::DB();
        $p = $DB->prepare("
        INSERTO INTO dati_anagrafici
        VALUES(NULL, ?, ?, ?, ?)");
        if(!$p){
            var_dump($p);
            echo $DB->error();
            die();
        }
        $p->bind_param("ssss", $dati_anagrafici->getNome(), $dati_anagrafici->getCognome(), $dati_anagrafici->getTelefono(), $dati_anagrafici->getDataNascita())
        $r = 0;
        if($p->execute())
        $r = $DB->lastId();
        $p->close();
        return $r;
    }

    public static function store(EDatiAnagrafici $dati_anagrafici){
        $DB = Singleton::DB();
        $p = $DB->prepare("
        UPDATE dati_anagrafici
        SET nome=?, cognome=?, telefono=?, data_nascita=?
        WHERE dati_anagrafici.id = ?");
        if(!$p){
            var_dump($p);
            echo $DB->error();
            die();
        }
        $p->bind_param("ssss", $dati_anagrafici->getNome(), $dati_anagrafici->getCognome(), $dati_anagrafici->getTelefono(), $dati_anagrafici->getDataNascita());
        $r=$p->execute();
        $p->close();
        if(!$r)
            return $r;
        return true;
    }

    public static function find(int $id){
        $DB = Singleton::DB();
        $p = $DB->prepare("
        SELECT *
        FROM dati_anagrafici
        WHERE dati_anagrafici.id = ?");
        if(!$p){
            var_dump($p);
            echo $DB->error();
            die();
        }
        $p->bind_param("i",$id);
        $p->execute();
        $p->bind_result($nome, $cognome, $telefono, $datanascita);
        $r = null;
        if($p->fetch()){
            $p->close();
            $r = new EDatiAnagrafici($nome, $cognome, $telefono, new DateTime($datanascita));
        }else
        $p->close();
        return $r;
    }
}
?>
