<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

abstract class FUtente extends FDatiAnagrafici{
    protected static $table = "utenti";

    public static function login($user,$pw){
        $DB = Singleton::DB();
        $sql = "SELECT id, id_datianagrafici, tipo_utente, email FROM utenti WHERE username = ? AND password = ?";
        $p = $DB->prepare($sql);
        $p->bind_param("ss",$user,$pw);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 1);
        $p->bind_result($id, $dati, $tipo, $email);
        $r = null;
        if($p->fetch()){
            $p->close();
            $r = self::create(array("id"=>$id, "dati"=>$dati, "tipo"=>$tipo, "email"=>$email, "username"=>$user));
        }else
            $p->close();
        return $r;
    }

    public static function create(array $obj): Entity{
        $DB = Singleton::DB();
        $dati_anagrafici = FDatiAnagrafici::find($obj["dati"]);
        $Fname = "F".$obj["tipo"];
        if(class_exists($Fname) && (new ReflectionClass($Fname))->isSubclassOf("FUtente"))
            return $Fname::create_user($obj["id"], $dati_anagrafici, $obj["email"], $obj["username"]);
        throw new \Exception("Error User Type not found", 1);
    }

    protected abstract static function create_user(int $id, EDatiAnagrafici $dati_anagrafici, string $email, string $username);
}
?>
