<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Dipendente extends Utente{
    protected static $table = "dipendenti";

    public static function insert(Model $obj): int{

    }

    public static function update(Model $obj){

    }

    public static function create_user(int $id_utente, \Models\DatiAnagrafici $dati_anagrafici, string $email, string $username): \Models\Dipendente{
        $sql = "SELECT * FROM ".self::$table." WHERE id_utente = ?";
        $p = \Singleton::DB()->prepare($sql);
        $p->bind_param("i",$id_utente);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->bind_result($id_utente, $id_dipendente, $ruolo, $tipoContratto, $dataAssunzione, $oreSettimanali, $prezzo, $valuta);
        $r = $p->fetch();
        if($r === FALSE)
            throw new \SQLException("Error Fetching Statement", $sql, $p->error, 4);
        elseif($r === NULL)
            throw new \ModelException("Model Not Found", __CLASS__, array("id"=>$id_utente), 0);
        $p->close();

        $turni = Turno::findByDipendente($id_dipendente);

        if($ruolo==="Amministratore")
            return self::create_dipendente($id_utente, $dati_anagrafici, $email, $username, $id_dipendente, $ruolo, $tipoContratto, new \DateTime($dataAssunzione), $oreSettimanali, new \Models\Money($prezzo,$valuta), $turni);
        elseif(class_exists($Fname) && (new \ReflectionClass($Fname))->isSubclassOf("\\Foundations\\Dipendente")){
            $Fname = "Foundations\\".$ruolo;
            return $Fname::create_dipendente($id_utente, $dati_anagrafici, $email, $username, $id_dipendente, $ruolo, $tipoContratto, new \DateTime($dataAssunzione), $oreSettimanali, new \Models\Money($prezzo,$valuta), $turni);
        }
        throw new \Exception("Error Dipendente Type not found", 2);
    }

    public static function create(array $obj): Model{
        return Utente::find($obj["id_utente"]);
    }

    protected static function create_dipendente(int $id_utente, \Models\DatiAnagrafici $dati_anagrafici, string $email,
        string $username, int $id_dipendente, string $ruolo, string $tipoContratto = '', \DateTime $dataAssunzione,
        int $oreSettimanali = 0, \Models\Money $stipendioOrario = NULL, array $turni = array()):\Models\Dipendente{
        if($dataAssunzione === NULL)
            $dataAssunzione = new \DateTime();
        if($stipendioOrario === NULL)
            $stipendioOrario = \Models\Money(0,'EUR');
        return new \Models\Dipendente($id_utente, $dati_anagrafici, $email, $username, $id_dipendente, $ruolo, $tipoContratto, $dataAssunzione, $oreSettimanali, $stipendioOrario, $turni);
    }
}
?>
