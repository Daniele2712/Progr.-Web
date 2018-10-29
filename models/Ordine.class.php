<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Ordine extends Model{     /*  Chiedi a mattia: devo mettere INDIRIZZO e DATI ANAGRAFICI oppure IdIdIndirizzo e IdDatiAnagrafici? */
	//Attributi
    private $items= array();    // array di items
    private $pagamento;         // modello del pagamento
    private $indirizzo;         // modello indirizzo 
    private $datiAnagrafici;    // modello datiAnagrafici
    private $subtotale;
    private $speseSpedizione;
    private $totale;
    private $idValuta;          // la valuta e contenuta anche nel pagamento...quindi...o teniamo l'uno o l-altro?
    private $dataOrdine;
    private $dataConsegna;
    private $stato;
    //Costruttori
    public function __construct($id, array $items,Indirizzo $indirizzo, DatiAnagrafici $datiAnagrafici, $subtotale=0, $speseSpedizione=0, $totale=0, $idValuta=1, $dataOrdine=null, $dataConsegna=null,$stato="Non ancora niente(model)")
            { 
        $this->id=$id;
    	$this->items =  $items;                 // $items e' un array di Item
        $this->indirizzo = clone $indirizzo;
	$this->datiAnagrafici = clone $datiAnagrafici;
        $this->subtotale=$subtotale;
        $this->speseSpedizione=$speseSpedizione;
        $this->totale=$totale;
        $this->idValuta=$idValuta;
        if(isset($dataOrdine) && is_a($dataOrdine, 'DateTime')) $this->dataOrdine=$dataOrdine;      //la parte con is_a DateTime serve x identificare le volte in cui non gli passi la data e si mette in automatico a nonSettato, che e una stringa, e non un datetime
                else $this->dataOrdine= null;
        if(isset($dataConsegna) && is_a($dataConsegna, 'DateTime')) $this->dataConsegna=$dataConsegna;
                else $this->dataConsegna= null;
        $this->stato=$stato;
            }
	//Metodi
	public function setItems(array $items){
		$this->items =  $items;
                $this->aggiornaPrezzi();
	}
	public function setPagamento(Pagamento $pagamento){
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
		return $this->pagamento;
	}
        public function getIndirizzo() : \Models\Indirizzo{   //rstituisce un Model
		return $this->indirizzo;
	}
        public function getDatiAnagrafici() : \Models\DatiAnagrafici{
		return $this->datiAnagrafici;
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
        public function getStato(){ 
		return $this->stato;
	}
        
        public function addItems(array $items){
            foreach($items as $i) {   $this->items[] =  $i;    }
                $this->aggiornaPrezzi();
	}
        
        private function aggiornaPrezzi(){
            //da implementare
        }
        
        private function aggiornaSpeseSpedizione(){
            //da implementare
        }
        
        
        
}
