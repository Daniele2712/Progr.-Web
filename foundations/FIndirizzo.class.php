<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class FIndirizzo extends Foundation{
  protected static $table = "indirizzi";

  public static function getIndirizzoByUserId(int $id){
        $p = Singleton::DB()->prepare("
            SELECT id, id_comune, via, civico, note
            FROM indirizzi
            LEFT JOIN indirizzi_preferiti ON indirizzi.id=indirizzi_preferiti.id_indirizzo
            WHERE id_utente_r = ?");
        $p->bind_param("i",$id);
        $p->execute();
        $p->bind_result($id, $id_comune, $via, $civico, $note);
        $r = array();
        while($p->fetch()){                 //TODO:cambiare fetch con getresource
            $comune = FComune::find($id_comune);
            $r[] = new EIndirizzo($comune, $via, $civico, $note);
        }
        $p->close();
        return $r;
    }
}
?>
