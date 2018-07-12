<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Carta implements MetodoPagamento
{
    private $idCarta;
    private $numeroCarta;
    private $pvc;
    private $nome;
    private $cognome;
    private $meseScadenza
    private $annoScadenza;

  public function __construct(int $idCarta, string $numCarta, int $pvc, string $nome, string $cognome,
  int $meseScadenza, int $annoScadenza){
      parent::__construct($idPagamento);
      $this->$idCarta;
      $this->numeroCarta = $numCarta;
      $this->pvc = $pvc;
      $this->nome = $nome;
      $this->cognome = $cognome;
      $this->meseScadenza = $meseScadenza;
      $this->annoScadenza = $annoScadenza;
      }

    private function verificaScadenza(){

    }

    private verificaCredenziali(){

        // vede se i dati inviati sono nei range ammisibili, e toglie i caratteri illegali....
    }

    public function paga(){

        //non ho ancora la minima idea di come si faccia

    }

/*

il tizio mettere sti dati

<form action="SimulatePayPalServer.php" method="post" name="paypal" id="paypal">
    <input  name="nome" placeholder="nome">
    <input  name="cognome" placeholder="cognome">
    <input  type= name="altro" placeholder="altro">
    <form action="/action_page.php">
      Birthday:
      <input type="date" name="bday">


    <input  name="creditCardNumber" placeholder="creditCardNumber">
    <input  name="threeDigit" placeholder="threeDigit">
    <input type="submit" value="Send">
</form>



*/



}
