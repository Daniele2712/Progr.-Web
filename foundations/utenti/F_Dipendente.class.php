<?php
namespace Foundations\Utenti;
use \Foundations\F_Utente as F_Utente;
use \Foundations\F_Turno as F_Turno;
use \Models\Model as Model;
use \Models\Utenti\M_Dipendente as M_Dipendente;
use \Models\M_DatiAnagrafici as M_DatiAnagrafici;
use \Models\M_Money as M_Money;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class F_Dipendente extends F_Utente{
    protected static $table = "dipendenti";
    private static $ruoli = array();
    private static $contratti = array();

    public static function insert(Model $obj, array $params = array()): int{

    }
public static function insertGestore(M_Dipendente $gestore, string $password, int $id_magazzino): array{ /* Nel caso divideremo ulteriormente la calsse Dipendente creando gesotre, amminisitratore e altri, questa funzione la metteremo nella parte del Gestore*/

  /*  Per prima cosa aggiungo alla tabblla dei dati anagrafici i dati anagrafici del Gestore  */
    $idInsertedDatiAna=\Foundations\F_DatiAnagrafici::insert($gestore->getDatiAnagrafici());
    if($idInsertedDatiAna)  echo "Dati anagrafici inseriti con successo  (ID - $idInsertedDatiAna).</br>";
    else echo "Errore inserimento dati anagrafici.</br>";
    //Ora aggiorno il modello per cambiarli l-id dei dati anagrafici, prima era 0 e adesso lo imposto uguale a $idInsertedDatiAna
    $DatiAnaTemp=$gestore->getDatiAnagrafici();
    $DatiAnaTemp->setId($idInsertedDatiAna);
    $gestore->setDatiAnagrafici($DatiAnaTemp);

  /*  Per seconda cosa aggiungo alla tabblla degli utenti l-utente creato con i dati del gestore */
    $params['password']=$password;
    $params['tipoUtente']='Dipendente';
    $idInsertedUser=\Foundations\F_Utente::insert($gestore,$params);
    if($idInsertedUser)  echo "Utente inserito con successo (ID - $idInsertedUser).</br>";
    else echo "Errore inserimento utente.</br>";
    //Ora aggiorno il modello per cambiare l-idid del USER ,prima era 0 e adesso lo imposto uguale a $idInsertedUser
    $gestore->setUtenteId($idInsertedUser);

    /*  Per terza cosa aggiungo alla tabblla dei dipendenti il l-utente appena creato, con id del ruolo 3(gestore)  */
    $idOfGestore=self::ruoloToId('gestore');
    $idInsertedDipendente=self::insertUserIntoDipendentiTable($gestore->getUtenteId(), $idOfGestore ,self::contrattoToId($gestore->getTipoContratto()),NULL, $gestore->getOreSettimanali(), $gestore->getStipendioOrario()->getPrezzo(), $gestore->getStipendioOrario()->getIdValuta(),  $id_magazzino);
    if($idInsertedDipendente)  echo "Dipendente inserito con successo (ID - $idInsertedDipendente).</br>";
    else echo "Errore inserimento dipendente.</br>";
    $gestore->setDipendenteId($idInsertedDipendente);

    /*  Per quarta cosa aggiungo linko il gestore al suo negozio  */
    $idInsertedMagazzini=\Foundations\F_Magazzino::insertByIds($gestore->getDipendenteId(),$id_magazzino);
    if($idInsertedMagazzini)  echo "Link Gestore-Magazzino avvenuto con successo (ID - $idInsertedMagazzini).</br>";
    else echo "Errore inserimento link Gestore-Magazzino.</br>";


    $r['idInsertedDatiAna']=$idInsertedDatiAna;
    $r['idInsertedUtente']=$idInsertedUser;
    $r['idInsertedDipendente']=$idInsertedDipendente;
    $r['idInsertedMagazzini']=$idInsertedMagazzini;
    return $r;
    }

    public static function insertUserIntoDipendentiTable($idUser, $idRuolo, $idTipoContratto, $dataAssunzione=NULL, $oreSettimanali, $pagaOraria, $idValuta, $idMagazzino=NULL){
      if($dataAssunzione === NULL) $dataAssunzione = new \DateTime();
      $dataAssunzione=date_format($dataAssunzione, 'Y-m-d');


      $DB = \Singleton::DB();
      $sql = "INSERT INTO `dipendenti` (`id`, `id_utente`, `ruolo`, `tipo_contratto`, `data_assunzione`, `ore_settimanali`, `paga_oraria`, `id_valuta`, `id_magazzino`) VALUES (NULL, ? , ? , ? , ? , ? , ? , ? , ?)";
      $p = $DB->prepare($sql);
      $p->bind_param("iiisidii", $idUser, $idRuolo, $idTipoContratto, $dataAssunzione,$oreSettimanali,$pagaOraria, $idValuta, $idMagazzino);
      if(!$p->execute())
          throw new \SQLException("Error Executing Statssssssement", $sql, $p->error, 3);
      $p->close();
      return $DB->lastId();
    }

    public static function insertDipendente(M_Dipendente $obj): int{
        /*  aggiungi al db il dipendente */
    }

    public static function update(Model $obj, array $params = array()){

    }

    public static function create_user(int $id_utente, M_DatiAnagrafici $dati_anagrafici, string $email, string $username): M_Dipendente{
        $sql = "SELECT * FROM ".self::$table." WHERE id_utente = ?";
        $p = \Singleton::DB()->prepare($sql);
        $p->bind_param("i",$id_utente);
        if($p->execute() === FALSE)
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->bind_result($id_utente, $id_dipendente, $idRuolo, $tipoContratto, $dataAssunzione, $oreSettimanali, $prezzo, $valuta,$id_magazzino);
        $r = $p->fetch();
        if($r === FALSE)
            throw new \SQLException("Error Fetching Statement", $sql, $p->error, 4);
        elseif($r === NULL)
            throw new \ModelException("Model Not Found", __CLASS__, array("id"=>$id_utente), 0);
        $p->close();
        $ruolo = self::getRuolo($idRuolo);
        $turni = F_Turno::findByDipendente($id_dipendente);
        $Fname = "Foundations\\".$ruolo;

        /*      Finche non facciamo le altre classi Foundation\gestore, Foundation\Amminstratore, ecc, questa sezione la commento cosi non crea problemi
        La parte che ho commentato crea un diverso Foundation\abc in base al ruolo
         * if($ruolo==="Amministratore")
            return self::create_dipendente($id_utente, $dati_anagrafici, $email, $username, $id_dipendente, $ruolo, self::getContratto($tipoContratto), new \DateTime($dataAssunzione), $oreSettimanali, new M_Money($prezzo,$valuta), $turni);
        elseif(class_exists($Fname) && (new \ReflectionClass($Fname))->isSubclassOf("\\Foundations\\F_Dipendente")){
            return $Fname::create_dipendente($id_utente, $dati_anagrafici, $email, $username, $id_dipendente, $ruolo, self::getContratto($tipoContratto), new \DateTime($dataAssunzione), $oreSettimanali, new M_Money($prezzo,$valuta), $turni);
        }
        throw new \Exception("Error Dipendente Type not found", 2);
        */

        //  quindi la seguente istruzione vuol dire che a  prescindere da tutto, io creo un dipendente
        return self::create_dipendente($id_utente, $dati_anagrafici, $email, $username, $id_dipendente, $ruolo, self::getContratto($tipoContratto), new \DateTime($dataAssunzione), $oreSettimanali, new M_Money($prezzo,$valuta), NULL, $turni);   /* Quando crei un dipendente metto la valuta a EURO, questo va cambiato, in particolare va cambiata la querry per avere acnche informazioni sulid Della valuta preferita del utente, ora non avendo la querry complessa do per scontato che l'utente usi EURO*/
    }

    public static function create(array $obj): Model{
        return F_Utente::find($obj["id_utente"]);
    }

    protected static function create_dipendente(int $id_utente, M_DatiAnagrafici $dati_anagrafici, string $email,
        string $username, int $id_dipendente, string $ruolo, string $tipoContratto = '', \DateTime $dataAssunzione,
        int $oreSettimanali = 0, M_Money $stipendioOrario = NULL, $idValutaPref, array $turni = array()): M_Dipendente{
        if($dataAssunzione === NULL)
            $dataAssunzione = new \DateTime();
        if($stipendioOrario === NULL)
            $stipendioOrario = M_Money(0,1);
        return new M_Dipendente($id_utente, $dati_anagrafici, $email, $username, $id_dipendente, $ruolo, $tipoContratto, $dataAssunzione, $oreSettimanali, $stipendioOrario,$idValutaPref, $turni);
    }

    /*  Ora, non so bene dove mettere queste funzioni, ma per ora le lasciamo in F_Dipendente finche troviamo un altro posto migliore */
    public static function idToRuolo(int $idRuolo){
        $DB = \Singleton::DB();
        $sql = "SELECT ruolo FROM dipendenti_ruoli WHERE id = ?";
        $p = $DB->prepare($sql);
        $p->bind_param("i",$idRuolo);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $res = $p->get_result();
        $fetchedResul=$res->fetch_assoc();
      return $fetchedResul['ruolo'];
    }
    public static function ruoloToId(string $Ruolo){
      $DB = \Singleton::DB();
      $sql = "SELECT id FROM dipendenti_ruoli WHERE ruolo = ?";
      $p = $DB->prepare($sql);
      $p->bind_param("s",$Ruolo);
      if(!$p->execute())
          throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
      $res = $p->get_result();
      $fetchedResul=$res->fetch_assoc();
      return $fetchedResul['id'];
    }
    public static function existsIdRuolo($id_ruolo){
        if(self::idToRuolo($id_ruolo) != NULL) return true;
        else return false;
    }
    public static function existsNomeRuolo($nome_ruolo){
      if(self::ruoloToId($nome_ruolo) != NULL) return true;
      else return false;
    }
    public static function idToContratto(int $id_contratto){
        $DB = \Singleton::DB();
        $sql = "SELECT contratto FROM dipendenti_contratti WHERE id = ?";
        $p = $DB->prepare($sql);
        $p->bind_param("i",$id_contratto);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $res = $p->get_result();
        $fetchedResul=$res->fetch_assoc();
      return $fetchedResul['contratto'];
    }
    public static function contrattoToId(string $nome_contratto){
      $DB = \Singleton::DB();
      $sql = "SELECT id FROM dipendenti_contratti WHERE contratto = ?";
      $p = $DB->prepare($sql);
      $p->bind_param("s",$nome_contratto);
      if(!$p->execute())
          throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
      $res = $p->get_result();
      $fetchedResul=$res->fetch_assoc();
      return $fetchedResul['id'];
    }
    public static function existsIdContratto($id_contratto){
      if(self::idToContratto($id_contratto) !=NULL) return true;
      else return false;
    }
    public static function existsNomeContratto($nome_contratto){
      if(self::contrattoToId($nome_contratto) != NULL) return true;
      else return false;
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

    public static function getMagazziniOfDipendenteWithId($idGestore){ // I controlli che sia un vero Gestore vanno fatti prima, qui do per scontato che sia un gestore


            $sql = "SELECT magazzini.id, comuni.CAP, comuni.nome, comuni.provincia, indirizzi.via, indirizzi.civico FROM magazzini,indirizzi,comuni WHERE magazzini.id_gestore= ? AND magazzini.id_indirizzo=indirizzi.id AND indirizzi.id_comune=comuni.id;";
            $p = \Singleton::DB()->prepare($sql);
            $p->bind_param('i',$idGestore);
            if(!$p->execute())
                throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
            $p->bind_result($id, $CAP, $nome, $provincia, $via, $civico);
            while ($p->fetch()) {
            $data_array[] = array("id_magazzino"=>$id,"CAP_magazzino"=>$CAP,"nome_citta_magazzino"=>$nome,"provincia_magazzino"=>$provincia,"via_magazzino"=>$via,"civico_magazzino"=>$civico);
            }
            /*if($r === FALSE)
                throw new \SQLException("Error Fetching Statement", $sql, $p->error, 4);
            elseif($r === NULL)
                throw new \SQLException("Empty Result", $sql, 0, 8);*/
            $p->close();

            return $data_array;

    }

    public static function getMagazziniOfAmministratore(){  // Il controllo non lo faccio qui perche l-ho fatto prima(o lo devo fare prima)
                                                        // Quindi vado su fiducia che si tratta veramente di un Amministratore

            $sql = "SELECT magazzini.id, comuni.CAP, comuni.nome, comuni.provincia, indirizzi.via, indirizzi.civico FROM magazzini,indirizzi,comuni WHERE magazzini.id_indirizzo=indirizzi.id AND indirizzi.id_comune=comuni.id;";
            $p = \Singleton::DB()->prepare($sql);
            if(!$p->execute())
                throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
            $p->bind_result($id, $CAP, $nome, $provincia, $via, $civico);
            while ($p->fetch()) {
            $data_array[] = array("id_magazzino"=>$id,"CAP_magazzino"=>$CAP,"nome_citta_magazzino"=>$nome,"provincia_magazzino"=>$provincia,"via_magazzino"=>$via,"civico_magazzino"=>$civico);
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
