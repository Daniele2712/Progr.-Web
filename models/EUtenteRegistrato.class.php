<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class EUtenteRegistrato extends EUtente{
    private $idRegistrato;
    private $pagamenti = array();
    private $indirizzi = array();
    private $carrelli = array();

    public function __construct(int $idDati=0, $nome, $cognome, $telefono, $nascita, $idUtente, $email, $username, $password, int $idRegistrato=0, array $pagamenti=array(), array $indirizzi=array(), array $carrelli=array(), string $email=""){
        parent::__construct($idDati, $nome, $cognome, $telefono, $nascita, $idUtente, $email, $username, $password);
        $this->idRegistrato = $idRegistrato;
        foreach($pagamenti as $p){
            $this->pagamenti[] = clone $p;
        }
        foreach($indirizzi as $i){
            $this->indirizzi[] = clone $i;
        }
        foreach($carrelli as $c){
            $this->carrelli[] = clone $c;
        }
        $this->email = $email;
    }
		public function login($user, $pass){
		
			$database= new FDatabase();
			if(isset($database))
			if(!isset($connection)){        //se non sono connesso
			    if(!connect()){  return false;} //xke non mi sono riuscito a connettere ...quindi finisce tutto qui          
			};
		
			//se arrivo fino a qui vuol dire che mi sono connesso
		
			$userAndHash=$connection->query("SELECT user, pass FROM USERS WHERE user = $user");  
			    //$myuser dovrebbe essere un array di 2 elementi, username e password -- $dbuser[0] e' il username, e $dbuser[1] e' il hash// uestonel ipotesi in cui nella tabella del db memorizzo user e hash
			    if(isset($userAndHashr))    //se ho trovato qualche ricorrenza(una)
			    {
			    if($userAndHash[1]==md5($pass)) {return true;}    //password e' giusta 
			    else return false;                            //xke password e sbagliata
			    }
			    else {return false;};  //xke username era sbagliata // non ha trovato il username nel database
      
    }
}
