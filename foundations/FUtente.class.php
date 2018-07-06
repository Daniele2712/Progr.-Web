<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

abstract class FUtente extends FDatiAnagrafici{
    protected static $table = "utenti";

    public static function login($user,$pw): int{
        $DB = Singleton::DB();
        $sql = "SELECT id FROM utenti WHERE username = ? AND password = MD5(?)";
        $p = $DB->prepare($sql);
        $p->bind_param("ss",$user,$pw);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->bind_result($id);
        $r = null;
        $f = $p->fetch();
        $p->close();
        if($f === FALSE)
            throw new \SQLException("Error Fetching Statement", $sql, $p->error, 4);
        elseif($f === NULL)
            throw new \EntityException("Entity Not Found", __CLASS__, array("username"=>$user, "password"=>$pw), 0);
        else
            return $id;
    }

    public static function create(array $obj): Entity{
        $DB = Singleton::DB();
        $dati_anagrafici = FDatiAnagrafici::find($obj["id_datianagrafici"]);
        $Fname = "F".$obj["tipo_utente"];
        if(class_exists($Fname) && (new ReflectionClass($Fname))->isSubclassOf("FUtente"))
            return $Fname::create_user($obj["id"], $dati_anagrafici, $obj["email"], $obj["username"]);
        throw new \Exception("Error User Type not found", 2);
    }

    protected abstract static function create_user(int $id, EDatiAnagrafici $dati_anagrafici, string $email, string $username);
}
?>
