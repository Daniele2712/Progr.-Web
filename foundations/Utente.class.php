<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

abstract class Utente extends DatiAnagrafici{
    protected static $table = "utenti";

    public static function login($user,$pw): int{
        $DB = \Singleton::DB();
        $sql = "SELECT id FROM utenti WHERE username = ? AND password = ?;";
        $p = $DB->prepare($sql);
        $hash=md5($pw);
        $p->bind_param('ss', $user, $hash);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->bind_result($id);       /*  mette i risultati nella variabile $id, essendo una sola riga non devo fare while p-> fetch, ed avendo una sola colonna, nella bind ci metto un solo parametro, ossia id */
        //$r = null;    /*  non so a cosa serve...*/
        $f = $p->fetch();
        $p->close();
        /*    debg    */
        if($f === FALSE)
            throw new \SQLException("Error Fetching Statement", $sql, $p->error, 4);
        elseif($f === NULL)
            throw new \ModelException("Model Not Found", __CLASS__, array("username"=>$user, "password"=>$pw), 0);
        else
            return $id;
    }

    public static function create(array $obj): Model{
        $DB = \Singleton::DB();
        $dati_anagrafici = DatiAnagrafici::find($obj["id_datianagrafici"]);
        $Fname = "Foundations\\".$obj["tipo_utente"];
        if(class_exists($Fname) && (new \ReflectionClass($Fname))->isSubclassOf("\\Foundations\\Utente"))
            return $Fname::create_user($obj["id"], $dati_anagrafici, $obj["email"], $obj["username"]);
        throw new \Exception("Error User Type not found", 2);
    }
    

    protected abstract static function create_user(int $id, \Models\DatiAnagrafici $dati_anagrafici, string $email, string $username);
}
