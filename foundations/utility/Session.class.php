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
     * metodo che esegue il login
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
        $_SESSION["userId"] = Utente::login($username,$password);       //dice al /foundation/utente di eseguira la metodo login(), che restituisce l-id della persona loggata
        return $_SESSION["userId"];
    }

    /**
     * metodo che esegue il logout, eliminando i dati di sessione e il file di sessione
     */
    public function logout(){
        session_unset();
        session_destroy();
    }

    /**
     * metodo che genera un token CSRF, se non esiste, e lo restituisce
     *
     * @return    int    token CSRF
     */
    public function getCSRF():string{
        if(empty($_SESSION['token']))
            $_SESSION['token'] = bin2hex(random_bytes(32));
        return $_SESSION['token'];
    }

    /**
     * metodo che controlla la validità di un token CSRF, se è valido viene generato un nuovo token
     *
     * @param     int     $token    token da verificare
     * @return    bool              TRUE se il token è valido, FALSE altrimenti
     */
    public function checkCSRF(string $token):bool{
        if(hash_equals($token, $_SESSION['token'])){           //hash_equals è resistente agli attacchi time based
            $_SESSION['token'] = bin2hex(random_bytes(32));
            return true;
        }else
            return false;
    }

    /**
     * metodo che restituisce l'utente usato per il login
     *
     * @return    \Models\Utente    utente loggato
     * @throws    Exception         se l'utente non è loggato
     */
    public function getUser(): \Models\Utente{
        if(!isset($_SESSION["userId"]) || !is_int($_SESSION["userId"]))
            throw new \Exception("User not Found", 5);
        $user = Utente::find($_SESSION["userId"]);
        $_SESSION["cartId"] = $user->getCarrello()->getId();
        return $user;
    }

    /**
     * metodo per controllare se l'utente si è già loggato
     *
     * @return    boolean    TRUE se è già loggato, FALSE altrimenti
     */
    public function isLogged(){
        return isset($_SESSION["userId"]) && $_SESSION["userId"]!==NULL;
    }

    public function getCart():\Models\Carrello{
        if(isset($_SESSION["cartId"]))
            return Carrello::find($_SESSION["cartId"]);
        elseif(isset($_SESSION["guestCart"]))
            return $_SESSION["guestCart"];
        elseif(isset($_SESSION["userId"])){             //lo userId ce l-hanno solo gli utenti registrati, i quali hanno anche un carrello come attributo, e la metodo getCarrello
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
        throw new \Exception("Error Address not set", 1);

    }

    public function getOrder():\Models\Ordine{
        if(isset($_SESSION["orderId"]))
            return Ordine::find($_SESSION["orderId"]);
    }

    public function setGuestAddress(int $id_comune, string $via, string $civico, string $note){
        $addr = new \Models\Indirizzo(0,\Foundations\Comune::find($id_comune), $via, $civico, $note);
        $_SESSION["addressId"] = \Foundations\Indirizzo::save($addr);
    }

    public function setUserAddress(int $id){
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

    public function setOrder(int $id){
        $_SESSION["orderId"] = $id;
    }


}
