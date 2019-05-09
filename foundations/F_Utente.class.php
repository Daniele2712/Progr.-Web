<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

abstract class F_Utente extends Foundation{
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
        $dati_anagrafici = F_DatiAnagrafici::find($obj["id_datianagrafici"]);
        $Fname = "\\Foundations\\Utenti\\F_".$obj["tipo_utente"];
        if(class_exists($Fname) && (new \ReflectionClass($Fname))->isSubclassOf("\\Foundations\\F_Utente"))
            return $Fname::create_user($obj["id"], $dati_anagrafici, $obj["email"], $obj["username"]);
        else throw new \Exception("Error User Type not found", 2);
    }


    protected abstract static function create_user(int $id, \Models\M_DatiAnagrafici $dati_anagrafici, string $email, string $username);

    public static function getRuoloOfUserId($idUtente){ // magari puoi fare anche un controllo prima x vedere se e effettivamente un dipendente o no...qui do x scontato che e un dipendente
            //Restituisce UtenteRegistrato, oppure Gestore, Corriere, Amministratore, ecc se l-utente e un dipendente

        if(\Foundations\F_UtenteRegistrato::isUtenteRegistrato($idUtente))
        {
           return "UtenteRegistrato";
        }
        else if(\Foundations\F_Dipendente::isDipendente($idUtente))
        {
            return \Foundations\F_Dipendente::getRuoloOfDipendenteWithId($idUtente);
        }
        else return null;
    }

}
