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

/*    $idInsertedDatiAna, $gestore->getRuolo(), $gestore->getEmail(), $gestore->getUsername(), md5($password), $gestore->getIdValuta()    */
//  public static function insert(int $idDatiAna, string $tipoUtente, string $email, string $username, string $password, $idValutePref=null): int{


    public static function insert(Model $utente, array $params = array()): int{

            $idDatiAna=$utente->getDatiAnagrafici()->getId();
            $tipoUtente= $params['tipoUtente'];
            $email=$utente->getEmail();
            $username=$utente->getUsername();
            $password=$params['password'];
            $idValutePref=$utente->getIdValuta();

            $DB = \Singleton::DB();

            $sql = "INSERT INTO ".self::$table." (`id`, `id_datianagrafici`, `tipo_utente`, `email`, `username`, `password`, `idValutaDefault`) VALUES (NULL, ?, ?, ?, ?, ?, ?)";
            $p = $DB->prepare($sql);
            $p->bind_param("issssi", $idDatiAna, $tipoUtente, $email, $username,$password,$idValutePref);
            if(!$p->execute())
                throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
            $p->close();
            return $DB->lastId();
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

        if(\Foundations\utenti\F_UtenteRegistrato::isUtenteRegistrato($idUtente))
        {
           return "UtenteRegistrato";
        }
        else if(\Foundations\utenti\F_Dipendente::isDipendente($idUtente))
        {
            return \Foundations\utenti\F_Dipendente::getRuoloOfDipendenteWithId($idUtente);
        }
        else return null;
    }

        public static function setPassword($pass, $userId){
          $sql = "UPDATE `utenti` SET `password` = '?' WHERE `utenti`.`id` = ?";
          $p = \Singleton::DB()->prepare($sql);
          $p->bind_param("si",$pass,$userId);
          if(!$p->execute())
              throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
          $p->bind_result($qualcosa);
          var_dump($qualcosa);
        }

        public static function seekUsername(string $username): bool{

            $DB = \Singleton::DB();
            $sql = "SELECT * FROM ".static::$table." WHERE `username` = ?";
            $p = $DB->prepare($sql);
            $p->bind_param('s',$username);
            if(!$p->execute())
                throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
            $res = $p->get_result();
            $p->close();
            return $res && $res->num_rows>=1;  /*  nel caso in cui il get_result() fallisce res sara uguale a NULL, quindi devo ferificare sia che != NULL e sia che num_rows>=1*/
        }

}
