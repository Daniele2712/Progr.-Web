<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Dipendente extends Utente{
    protected static $table = "dipendenti";
    private static $ruoli = array();
    private static $contratti = array();

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
        $p->bind_result($id_utente, $id_dipendente, $idRuolo, $tipoContratto, $dataAssunzione, $oreSettimanali, $prezzo, $valuta,$id_magazzino);
        $r = $p->fetch();
        if($r === FALSE)
            throw new \SQLException("Error Fetching Statement", $sql, $p->error, 4);
        elseif($r === NULL)
            throw new \ModelException("Model Not Found", __CLASS__, array("id"=>$id_utente), 0);
        $p->close();
        $ruolo = self::getRuolo($idRuolo);
        $turni = Turno::findByDipendente($id_dipendente);
        $Fname = "Foundations\\".$ruolo;

        /*      Finche non facciamo le altre classi Foundation\gestore, Foundation\Amminstratore, ecc, questa sezione la commento cosi non crea problemi
        La parte che ho commentato crea un diverso Foundation\abc in base al ruolo
         * if($ruolo==="Amministratore")
            return self::create_dipendente($id_utente, $dati_anagrafici, $email, $username, $id_dipendente, $ruolo, self::getContratto($tipoContratto), new \DateTime($dataAssunzione), $oreSettimanali, new \Models\Money($prezzo,$valuta), $turni);
        elseif(class_exists($Fname) && (new \ReflectionClass($Fname))->isSubclassOf("\\Foundations\\Dipendente")){
            return $Fname::create_dipendente($id_utente, $dati_anagrafici, $email, $username, $id_dipendente, $ruolo, self::getContratto($tipoContratto), new \DateTime($dataAssunzione), $oreSettimanali, new \Models\Money($prezzo,$valuta), $turni);
        }
        throw new \Exception("Error Dipendente Type not found", 2);
        */
        
        //  quindi la seguente istruzione vuol dire che a  prescindere da tutto, io creo un dipendente
        return self::create_dipendente($id_utente, $dati_anagrafici, $email, $username, $id_dipendente, $ruolo, self::getContratto($tipoContratto), new \DateTime($dataAssunzione), $oreSettimanali, new \Models\Money($prezzo,$valuta), $turni);
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
            $stipendioOrario = \Models\Money(0,1);
        return new \Models\Dipendente($id_utente, $dati_anagrafici, $email, $username, $id_dipendente, $ruolo, $tipoContratto, $dataAssunzione, $oreSettimanali, $stipendioOrario, $turni);
    }

    private static function getRuolo($id_ruolo){
        if(!isset(self::$ruoli[$id_ruolo])){
            $sql = "SELECT ruolo FROM dipendenti_ruoli WHERE id = ?";
            $p = \Singleton::DB()->prepare($sql);
            $p->bind_param("i",$id_ruolo);
            if(!$p->execute())
                throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
            $p->bind_result($nome);
            $r = $p->fetch();
            if($r === FALSE)
                throw new \SQLException("Error Fetching Statement", $sql, $p->error, 4);
            elseif($r === NULL)
                throw new \SQLException("Empty Result", $sql, 0, 8);
            $p->close();
            self::$ruoli[$id_ruolo] = $nome;
        }
        return self::$ruoli[$id_ruolo];
    }

    private static function getContratto($id_contratto){
        if(!isset(self::$contratti[$id_contratto])){
            $sql = "SELECT contratto FROM dipendenti_contratti WHERE id = ?";
            $p = \Singleton::DB()->prepare($sql);
            $p->bind_param("i",$id_contratto);
            if(!$p->execute())
                throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
            $p->bind_result($nome);
            $r = $p->fetch();
            if($r === FALSE)
                throw new \SQLException("Error Fetching Statement", $sql, $p->error, 4);
            elseif($r === NULL)
                throw new \SQLException("Empty Result", $sql, 0, 8);
            $p->close();
            self::$contratti[$id_contratto] = $nome;
        }
        return self::$contratti[$id_contratto];
    }
    
    public static function isDipendente($id){
        $sql = "SELECT id FROM ".self::$table." WHERE id_utente=?";
        $p = \Singleton::DB()->prepare($sql);
        $p->bind_param("i",$id);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $num=$p->get_result()->num_rows;
        $p->close();
        if($num) return true;
        else return false;
    }
    
    
    public static function getRuoloOfDipendenteWithId($idUtente){ // magari puoi fare anche un controllo prima x vedere se e effettivamente un dipendente o no...qui do x scontato che e un dipendente
            //Restituisce UtenteRegistrato, oppure Gestore, Corriere, Amministratore, ecc se l-utente e un dipendente
            
            $sql = "SELECT ruolo FROM ".self::$table." WHERE id_utente=?";
            $p = \Singleton::DB()->prepare($sql);
            $p->bind_param("i",$idUtente);
            if(!$p->execute())
                throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
            $p->bind_result($idRuolo);
            $r = $p->fetch();
            if($r === FALSE)
                throw new \SQLException("Error Fetching Statement", $sql, $p->error, 4);
            elseif($r === NULL)
                throw new \SQLException("Empty Result", $sql, 0, 8);
            $p->close();
            
            return self::getRuolo($idRuolo);
        
    }
    
    public static function getMagazziniOfDipendenteWithId($idGestore){ // magari puoi fare anche un controllo prima x vedere se e effettivamente un dipendente o no...qui do x scontato che e un dipendente
            //Restituisce UtenteRegistrato, oppure Gestore, Corriere, Amministratore, ecc se l-utente e un dipendente
            
            $sql = "SELECT magazzini.id, comuni.CAP, comuni.nome, comuni.provincia, indirizzi.via, indirizzi.civico FROM magazzini,indirizzi,comuni WHERE magazzini.id_gestore= ? AND magazzini.id_indirizzo=indirizzi.id AND indirizzi.id_comune=comuni.id;";
            $p = \Singleton::DB()->prepare($sql);
            $p->bind_param('i',$idGestore);
            if(!$p->execute())
                throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
            $p->bind_result($id, $CAP, $nome, $provincia, $via, $civico);
            while ($p->fetch()) {
            $data_array[] = array("id"=>$id,"CAP"=>$CAP,"nome"=>$nome,"provincia"=>$provincia,"via"=>$via,"civico"=>$civico);
            }
            /*if($r === FALSE)
                throw new \SQLException("Error Fetching Statement", $sql, $p->error, 4);
            elseif($r === NULL)
                throw new \SQLException("Empty Result", $sql, 0, 8);*/
            $p->close();
            
            return $data_array;
        
    }
}
?>
