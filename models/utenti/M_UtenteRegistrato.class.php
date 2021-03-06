<?php
namespace Models\Utenti;
use \Models\M_Utente as M_Utente;
use \Models\M_Indirizzo as M_Indirizzo;
use \Models\M_Carrello as M_Carrello;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class M_UtenteRegistrato extends M_Utente{
    private $idRegistrato;
    private $punti;
    private $pagamenti = array();
    private $indirizzi = array();
    private $indirizzo_preferito;
    private $carrello;

    public function __construct($idUtente, $datiAnagrafici, $email, $username, $password, int $idRegistrato=0, int $punti = 0, array $pagamenti = array(), array $indirizzi = array(), M_Indirizzo $indirizzo_preferito, M_Carrello $carrello){
        parent::__construct($idUtente, $datiAnagrafici, $email, $username, $password);
        $this->idRegistrato = $idRegistrato;
        $this->punti = $punti;
        foreach($pagamenti as $p){
            $this->pagamenti[] = clone $p;
        }
        foreach($indirizzi as $i){
            $this->indirizzi[] = clone $i;
        }
        $this->indirizzo_preferito = clone $indirizzo_preferito;
        $this->carrello = clone $carrello;
        $this->email = $email;
    }

    public function getIndirizzi(): array{
        $r = array();
        foreach($this->indirizzi as $i){
            $r[] = clone $i;
        }
        return $r;
    }

    public function getIdRegistrato(): int{
        return $this->idRegistrato;
    }

    public function getPunti(): int{
        return $this->punti;
    }

    public function getIndirizzoPreferito(): M_Indirizzo{
        return clone $this->indirizzo_preferito;
    }

    public function getCarrello(): \Models\M_Carrello{
        return clone $this->carrello;
    }

    public function setCarrello(\Models\M_Carrello $cart){
        $this->carrello = clone $cart;
    }

    public function setNewCartAddress(int $id_comune, string $via, string $civico, string $note){
        $addr = new M_Indirizzo(0, \Foundations\F_Comune::find($id_comune), $via, $civico, $note);
        $this->addAddress($addr);
        $this->setCartAddress($addr->getId());
    }

    public function addAddress(M_Indirizzo &$addr): int{
        $id = \Foundations\F_Indirizzo::save($addr);
        $addr->setId($id);
        $this->indirizzi[] = clone $addr;
        \Foundations\Utenti\F_UtenteRegistrato::addAddress($this->getId(), $addr->getId());
        return $id;
    }

    /**
     * metodo per impostare l'indirizzo da usare per l'ordine
     *
     * @param    mixed    $addr    id dell'indirizzo da usare o "default" per usare l'indirizzo preferito dell'utente
     */
    public function setCartAddress($addr){
        if($addr==="default")
            $this->useDefaultAddress();
        else
            $this->useAddress($addr);
    }

    /**
     * metodo per impostare l'idirizzo da usare per l'ordine
     *
     * @param     int       $id    id dell'indirizzo
     */
    private function useAddress(int $id){
        \Singleton::Session()->setUserAddress($this->findUserAddress($id));
    }

    /**
     * metodo per impostare l'idirizzo preferito dell'Utente
     * come indirizzo da usare per l'ordine
     */
    private function useDefaultAddress(){
        \Singleton::Session()->setUserAddress($this->getIndirizzoPreferito());
    }

    /**
     * metodo che restituisce l'indirizzo dell'utente con l'id specificato
     *
     * @param     int       $id_addr    id dell'indirizzo da cercare
     * @return    \ModelException       eccezione restituita se nessun indirizzo dell'utente ha l'id cercato
     */
    private function findUserAddress(int $id_addr){
        foreach($this->indirizzi as $addr)
            if($addr->getId() === $id_addr)
                return $addr;
        throw new \ModelException("Model Not Found", __CLASS__, array("id_utente"=>$this->id, "id_addr"=>$id_addr), 0);
    }

    public function getRuolo(){
        return "UtenteRegistrato";
    }

    public static function nuovo(string $nome,string $cognome,string $email,string $username,string $password,int $comuneId,string $via,string $civico,string $note){
        $DB = \Singleton::DB();

        $dati = new \Models\M_DatiAnagrafici(0, $nome, $cognome);
        $indirizzo = new \Models\M_Indirizzo(0, \Foundations\F_Comune::find($comuneId), $via, $civico, $note);
        $cart = new \Models\M_Carrello(0);

        $user = new M_UtenteRegistrato(0, $dati, $email, $username, $password, 0, 0, array(), array($indirizzo), $indirizzo, $cart);

        $DB->begin_transaction();
        \Foundations\F_Utente::save($user);
        $DB->commit();
        \Singleton::Session()->login($username,$password);
    }
}
