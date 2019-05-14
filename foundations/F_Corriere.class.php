<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class F_Corriere extends F_Dipendente{
  protected static $table = "corrieri";

    public static function insert(Model $user, array $params = array()): int{

    }

    public static function update(Model $user, array $params = array()){

    }

    //TODO: aggiornare
    /*public static function create_dipendente(int $id_utente, \Models\M_DatiAnagrafici $dati_anagrafici, string $email, string $username, int $id_dipendente, string $ruolo, string $tipoContratto = '', DateTime $dataAssunzioni = new \DateTime(), int $oreSettimanali = 0, Money $stipendioOrario = new F_Money(0,1), array $turni = array()): \Models\M_Corriere{
        $sql = "SELECT id FROM ".self::$table." WHERE id_dipendente = ?";
        $p = \Singleton::DB()->prepare($sql);
        $p->bind_param("i",$id_dipendente);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->bind_result($id);
        $r = $p->fetch();
        if($r === FALSE)
            throw new \SQLException("Error Fetching Statement", $sql, $p->error, 4);
        elseif($r === NULL)
            throw new \ModelException("Model Not Found", __CLASS__, array("id"=>$id_dipendente), 0);
        $p->close();

        return new \Models\M_Corriere($id_utente, $dati_anagrafici, $email, $username, $id_dipendente, $ruolo, $id);
    }*/

    public static function create(array $obj): Model{
        return Dipendente::find($obj["id_dipendente"]);
    }
}
