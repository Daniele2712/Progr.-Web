<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Gestore extends Utente{
  protected static $table = "gestori";

    public static function insert(Model $user): int{

    }

    public static function update(Model $user){

    }

    public static function create_user(int $id_utente, \Models\DatiAnagrafici $dati_anagrafici, string $email, string $username): \Models\Gestore{
        $sql = "SELECT id FROM ".self::$table." WHERE id_utente = ?";
        $p = \Singleton::DB()->prepare($sql);
        $p->bind_param("i",$id_utente);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->bind_result($id);
        $r = $p->fetch();
        if($r === FALSE)
            throw new \SQLException("Error Fetching Statement", $sql, $p->error, 4);
        elseif($r === NULL)
            throw new \ModelException("Model Not Found", __CLASS__, array("id"=>$id_utente), 0);
        $p->close();

        return new \Models\Gestore($id_utente, $dati_anagrafici, $email, $username, $id);
    }

    public static function create(array $obj): Model{
        return Utente::find($obj["id_utente"]);
    }
}
