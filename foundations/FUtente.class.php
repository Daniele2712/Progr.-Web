<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

abstract class FUtente extends FDatiAnagrafici{
    protected static $table = "utenti";

    public static function Login($user,$pw){
        $DB = Singleton::DB();
        $p = $DB->prepare("
            SELECT id, id_datianagrafici, tipoUtente, email
            FROM utenti
            WHERE username = ? AND password = ?");
        if(!$p){
            var_dump($p);
            echo $DB->error();
            die();
        }
        $p->bind_param("ss",$user,$pw);
        $p->execute();
        $p->bind_result($id, $dati, $tipo, $email);
        $r = null;
        if($p->fetch()){
            $p->close();
            $r = self::create(array("id"=>$id, "dati"=>$dati, "tipo"=>$tipo, "email"=>$email, "username"=>$user));
        }else
            $p->close();
        return $r;
    }

    public static function create($obj){
        $DB = Singleton::DB();
        $dati_anagrafici = FDatiAnagrafici::find($obj["dati"]);
        $Fname = "F".$obj["tipo"];
        if(class_exists($Fname) && (new ReflectionClass($Fname))->isSubclassOf("FUtente"))
            return $Fname::load($obj["id"], $dati_anagrafici, $obj["email"], $obj["username"]);
        return null;
    }

    protected abstract static function load(int $id, EDatiAnagrafici $dati_anagrafici, string $email, string $username);
}
?>
