<?php
namespace Models;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Carta extends Pagamento{
    private $idCarta;
    private $numeroCarta;
    private $cvv;
    private $nome;
    private $cognome;
    private $dataScadenza;

    public function __construct(int $idPagamento, int $idCarta, string $numCarta, int $cvv, string $nome, string $cognome, \DateTime $dataScadenza){
        parent::__construct($idPagamento);
        $this->idCarta = $idCarta;
        $this->numeroCarta = $numCarta;
        $this->cvv = $cvv;
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->dataScadenza = $dataScadenza;
    }


    private function verificaScadenza(){

    }

    private function verificaCredenziali(){

        // vede se i dati inviati sono nei range ammisibili, e toglie i caratteri illegali....
    }

    public function paga(){

        //non ho ancora la minima idea di come si faccia

    }

    public static function newPayment(Request $req):Pagamento{
        $numero = $req->getString("carta_num","","POST");
        $nome = $req->getString("carta_nome","","POST");
        $cognome = $req->getString("carta_cognome","","POST");
        $scadenza = new \DateTime();//$req->getString("carta_scadenza","","POST");
        $cvv = $req->getInt("carta_cvv",0,"POST");
        return new Carta(0, 0, $numero, $cvv, $nome, $cognome, $scadenza);
    }

    public function getIdCarta(): int{
        return $this->idCarta;
    }

    public function getNumero(): string{
        return $this->numeroCarta;
    }

    public function getNome(): string{
        return $this->nome;
    }

    public function getCognome(): string{
        return $this->cognome;
    }

    public function getCvv(): int{
        return $this->cvv;
    }

    public function getScadenza(): \DateTime{
        return clone $this->dataScadenza;
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
