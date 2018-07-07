<?php
namespace Foundations;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

/**
 * classe Foundation che gestisce la sessione
 */
class Session{
    private $cart;
    private $guestAddress;
    private $addressId;
    private $guestPayment;
    private $paymentId;
    /**
     * inizializza la sessione
     */
    public function __construct(){
        session_start();
    }

    /**
     * funzione che esegue il login
     *
     * @param   string    $username         stringa contentente la username
     * @param   string    $password         stringa contentente la password
     * @throws  InvalidArgumentException    se lo username è vuoto
     * @throws  InvalidArgumentException    se la password è vuota
     * @return  int                         id dell'utente
     */
    public function login(string $username, string $password):int{
        if($username === '')
            throw new \InvalidArgumentException("username input was empty");
        if($password === '')
            throw new \InvalidArgumentException("password input was empty");
        $_SESSION["userId"] = Utente::login($username,$password);
        return $_SESSION["userId"];
    }

    /**
     * funzione che esegue il logout, eliminando i dati di sessione e il file di sessione
     */
    public function logout(){
        session_unset();
        session_destroy();
    }

    /**
     * funzione che restituisce l'utente usato per il login
     *
     * @return    \Models\Utente    utente loggato
     */
    public function getUser(): \Models\Utente{
        return Utente::find($_SESSION["userId"]);
    }

    /**
     * funzione per controllare se l'utente si è già loggato
     *
     * @return    boolean    TRUE se è già loggato, FALSE altrimenti
     */
    public function isLogged(){
        return isset($_SESSION["userId"]) && $_SESSION["userId"]!==NULL;
    }

    public function getCart():\Models\Carrello{
        if($this->cart)
            return Carrello::find($this->cart);
        throw new \Exception("Error Cart not set", 1);
    }

    public function getAddr():\Models\Indirizzo{
        if($this->addressId)
            return Indirizzo::find($this->addressId);
        elseif($this->guestAddress)
            return clone $this->guestAddress;
        throw new \Exception("Error Address not set", 1);

    }

    public function setGuestAddress(\Models\Indirizzo $addr){
        $this->addressId = NULL;
        $this->guestAddress = clone $addr;
    }

    public function setUserAddress(int $id){
        $this->guestAddress = NULL;
        $this->addressId = $id;
    }

    public function setGuestPayment(\Models\Pagamento $payment){
        $this->paymentId = NULL;
        $this->guestPayment = clone $payment;
    }

    public function setUserPayment(int $id){
        $this->guestPayment = NULL;
        $this->paymentId = $id;
    }
}
