<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Paypal implements Pagamento
{

    private $pagato = false;
    private $email="";  // pero se usiamo le api di paypal, penso che non ci dobbiamo ricordare noi email e pass
    private $pass="";// pero se usiamo le api di paypal, penso che non ci dobbiamo ricordare noi email e pass
  public function __construct(){}

    public function paga(){

        //dovrebbe usare il sito della paypal e fare il pagamento la

    }
}
