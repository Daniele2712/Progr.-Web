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
        if($_SESSION["cartId"])
            return Carrello::find($_SESSION["cartId"]);
        elseif($_SESSION["guestCart"])
            return $_SESSION["guestCart"];
        elseif($_SESSION["userId"]){
            $cart = self::getUser()->getCarrello();
            $_SESSION["cartId"] = $cart->getId();
            return $cart;
        }else{
            $_SESSION["guestCart"] = new \Models\Carrello(0);
            return $_SESSION["guestCart"];
        }
    }

    public function getAddr():\Models\Indirizzo{
        if($_SESSION["addressId"])
            return Indirizzo::find($_SESSION["addressId"]);
        elseif($_SESSION["guestAddress"])
            return clone $_SESSION["guestAddress"];
        throw new \Exception("Error Address not set", 1);

    }

    public function setGuestAddress(\Models\Indirizzo $addr){
        $_SESSION["addressId"] = NULL;
        $_SESSION["guestAddress"] = clone $addr;
    }

    public function setUserAddress(int $id){
        $_SESSION["guestAddress"] = NULL;
        $_SESSION["addressId"] = $id;
    }

    public function setGuestCart(\Models\Carrello $addr){
        $_SESSION["cartId"] = NULL;
        $_SESSION["guestCart"] = clone $addr;
    }

    public function setUserCart(int $id){
        $_SESSION["guestCart"] = NULL;
        $_SESSION["cartId"] = $id;
    }

    public function setGuestPayment(\Models\Pagamento $payment){
        $_SESSION["paymentId"] = NULL;
        $_SESSION["guestPayment"] = clone $payment;
    }

    public function setUserPayment(int $id){
        $_SESSION["guestPayment"] = NULL;
        $_SESSION["paymentId"] = $id;
    }
}
