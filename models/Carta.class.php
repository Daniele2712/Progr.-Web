<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Carta implements MetodoPagamento
{

    private $numeroCarta;
    private $nuemro3Cifre;
    private $nome;
    private $cognome;
    private $giornoNascita;
    private $meseNascita;
    private $annoNascita;
    private $dataScadenza;

  public function __construct(){
    prende le ocse dalle form e le mette dentro alle variabili
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
