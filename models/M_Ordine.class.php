<?php
namespace Models;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class M_Ordine extends Model{     /*  Chiedi a mattia: devo mettere INDIRIZZO e DATI ANAGRAFICI oppure IdIdIndirizzo e IdDatiAnagrafici? */
	//Attributi
    private $items = array();   // array di items
    private $pagamento;         // modello del pagamento
    private $indirizzo;         // modello indirizzo
    private $datiAnagrafici;    // modello datiAnagrafici
    private $magazzino;         // modello magazzino
    private $subtotale;
    private $speseSpedizione;
    private $totale;
    private $idValuta;          // la valuta e contenuta anche nel pagamento...quindi...o teniamo l'uno o l-altro?
    private $dataOrdine;
    private $dataConsegna;
    private $stato;
    //Costruttori
    public function __construct(int $id=0, array $items, M_Pagamento $pagamento, M_Indirizzo $indirizzo, M_DatiAnagrafici $datiAnagrafici, M_Magazzino $magazzino, float $subtotale=0, float $speseSpedizione=0, float $totale=0, int $idValuta=1, \DateTime $dataOrdine=null, \DateTime $dataConsegna=null, string $stato=""){
        $this->id = $id;
    	$this->items =  $items;                 // $items e' un array di Item
        $this->pagamento = clone $pagamento;
        $this->indirizzo = clone $indirizzo;
	    $this->datiAnagrafici = clone $datiAnagrafici;
        $this->magazzino = clone $magazzino;
        $this->subtotale = $subtotale;
        $this->speseSpedizione = $speseSpedizione;
        $this->totale = $totale;
        $this->idValuta = $idValuta;
        if(isset($dataOrdine) && is_a($dataOrdine, 'DateTime'))
            $this->dataOrdine = $dataOrdine;
        else
            $this->dataOrdine = new \DateTime();
        if(isset($dataConsegna) && is_a($dataConsegna, 'DateTime'))
            $this->dataConsegna = $dataConsegna;
        else
            $this->dataConsegna = null;
        $this->stato = $stato;
        $this->link = md5($totale."-".$this->dataOrdine->format('Y-m-d H:i:s'));
    }
	//Metodi
    public static function nuovo(Request $req): M_Ordine{
        $session = \Singleton::Session();
        $carrello = $session->getCart();
        $addr = $session->getAddr();

        $pagamento = M_Pagamento::nuovo($req);

        $nome = $req->getString("nome", "", "POST");
        $cognome = $req->getString("cognome", "", "POST");
        $telefono = $req->getString("telefono", "", "POST");
        $giorno = $req->getInt("giorno", intval(date("j")), "POST");
        $mese = $req->getInt("mese", intval(date("n")), "POST");
        $anno = $req->getInt("anno", intval(date("Y")), "POST");
        $data = new \DateTime($anno."-".$mese."-".$giorno);
        if($session->isLogged())
            $dati = $session->getUser()->getDatiAnagrafici();
        else
            $dati = new M_DatiAnagrafici(0, $nome, $cognome, $telefono, $data);
        $magazzino = \Foundations\F_Magazzino::findClosestTo($addr);

        $subtotale = $carrello->getTotale()->getPrezzo();
        $spedizione = 0;
        $totale = $subtotale+$spedizione;

        $valuta = $session->getUserValuta()->getValuta();

        $magazzino->removeItems($carrello->getItems());

        $ordine = new M_Ordine(0, $carrello->getItems(), $pagamento, $addr, $dati, $magazzino, $subtotale, $spedizione, $totale, $valuta, new \DateTime(), new \DateTime(date("Y-m-d H:i:s", strtotime("+2 hours"))), "attesa pagamento");
        \Foundations\F_Ordine::save($ordine);
        \Foundations\F_Magazzino::save($magazzino);
        $session->emptyCart();
        return $ordine;
    }
	public function setItems(array $items){
		$this->items =  $items;
                $this->aggiornaPrezzi();
	}
	public function setPagamento(M_Pagamento $pagamento){
		$this->pagamento =  $pagamento;
	}
	public function setIdIndirizzo($indirizzo){
		$this->indirizzo =  $indirizzo;
                $this->aggiornaSpeseSpedizione();
	}
        public function setDatiAnagrafici($datiAnagrafici){
		$this->datiAnagrafici =  $datiAnagrafici;
	}
	public function setSubtotale( $subtotale){  // vedi se lo puoi mettere privato
		$this->subtotale =  $subtotale;
	}
    public function setSpeseSpedizione($speseSpedizione){   // vedi se lo puoi mettere privato
		$this->speseSpedizione =  $speseSpedizione;
	}
    public function setTotale($totale){ // vedi se lo puoi mettere privato
		$this->totale =  $totale;
	}
    public function setIdValuta($idValuta){
		$this->idValuta =  $idValuta;
	}
    public function setDataOrdine($dataOrdine){ // vedi se lo puoi mettere privato
		$this->dataOrdine =  $dataOrdine;
	}
    public function setDataConsegna($dataConsegna){ // vedi se lo puoi mettere privato
		$this->dataConsegna =  $dataConsegna;
	}
    public function setStato($stato){ // vedi se lo puoi mettere privato
		$this->stato =  $stato;
	}

    public function getItems(){
		return $this->items;
	}
    public function getPagamento(){   //non ci metto cosa ritorna, xke se non e settato il pagamento ritornera null.
		return clone $this->pagamento;
	}
    public function getIndirizzo() : \Models\M_Indirizzo{   //rstituisce un Model
		return clone $this->indirizzo;
	}
    public function getDatiAnagrafici() : \Models\M_DatiAnagrafici{
		return clone $this->datiAnagrafici;
	}
    public function getSubtotale(){
		return $this->subtotale;
	}
    public function getSpeseSpedizione(){
		return $this->speseSpedizione;
	}
    public function getTotale(){
		return $this->totale;
	}
    public function getIdValuta(){
		return $this->idValuta;
	}
    public function getDataOrdine(){
		return $this->dataOrdine;
	}
    public function getDataConsegna(){
		return $this->dataConsegna;
	}
    public function getMagazzino(){
		return clone $this->magazzino;
	}
    public function getStato(){
		return $this->stato;
	}
    public function getLink(){
		return $this->link;
	}

    public function addItems(array $items){
        foreach($items as $i) {   $this->items[] =  $i;    }
            $this->aggiornaPrezzi();
	}

    private function aggiornaPrezzi(){
        //TODO: da implementare
    }

    private function aggiornaSpeseSpedizione(){
        //TODO: da implementare
    }



}
