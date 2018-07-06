<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class BitCoin implements MetodoPagamento
{

    private $publicKey="";
    private $paymentDone=false;
    //altri eventuali parametri che non so

  public function __construct(){

    public function paga(){
        //non so come potrebbe funzionare
        //potrebbbe usare un altra funzione, che va a prendere un link che rappresenta a chi deve mandare i soldi e quanti sono, e l'utente usa questi dati, generati sul momento per pagare. Dopo gli arrivera qualche conferma che magari attiva un altra funzione di questa classe e imposta il parametro pagato a vero
    };

      private function paymentWasDone(){
          $paymentDone=true;
      }

      //altre eventuali funzioni
}
