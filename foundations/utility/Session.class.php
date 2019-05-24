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

    public static $session_time = 12000;
    private $new_session = FALSE;
    /**
     * inizializza la sessione
     */
    public function __construct(){
        session_start();
        if(isset($_SESSION["last_time"]) && $_SESSION["last_time"]+self::$session_time < time())
            session_unset();
        else{
            if(!isset($_SESSION["last_time"]))
                $this->new_session = TRUE;
            $_SESSION["last_time"] = time();
        }
    }

    public function timedOut(){
        return !isset($_SESSION["last_time"]);
    }

    public function isNew(){
        return $this->new_session;
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
        $_SESSION["userId"] = F_Utente::login($username,$password);       //dice al /foundation/utente di eseguira la metodo login(), che restituisce l-id della persona loggata
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
     * @return    \Models\M_Utente    utente loggato
     * @throws    Exception         se l'utente non è loggato
     */
    public function getUser(): \Models\M_Utente{
        if(!isset($_SESSION["userId"]) || !is_int($_SESSION["userId"]))
            throw new \Exception("User not Found", 5);
        $user = F_Utente::find($_SESSION["userId"]);
        if(method_exists($user, 'getCarrello')) $_SESSION["cartId"] = $user->getCarrello()->getId();        //A: solo se l-utente e' un utente registrato,e quindi ha un carrello,
         // altrimenti, ex se e' un gestore , non devo imposotare il cookie cartId, xke il gestore non ha un carrello
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

    public function getCart():\Models\M_Carrello{
        if(isset($_SESSION["cartId"]))
            return F_Carrello::find($_SESSION["cartId"]);
        elseif(isset($_SESSION["guestCart"]))
            return $_SESSION["guestCart"];
        elseif(isset($_SESSION["userId"])){             //lo userId ce l-hanno solo gli utenti registrati, i quali hanno anche un carrello come attributo, e la metodo getCarrello
            $cart = self::getUser()->getCarrello();
            $_SESSION["cartId"] = $cart->getId();
            return $cart;
        }else{
            $_SESSION["guestCart"] = new \Models\M_Carrello(0);
            return $_SESSION["guestCart"];
        }
    }



    public function getAddr():\Models\M_Indirizzo{
        if(array_key_exists("address",$_SESSION))
            return $_SESSION["address"];
        throw new \Exception("Error Address not set", 1);
    }

    public function getAddressesFull(){ //full x indicare che e compreso anhce l-indirizzo preferito

    }

    public function getOrder():\Models\M_Ordine{
        if(isset($_SESSION["orderId"]))
            return F_Ordine::find($_SESSION["orderId"]);
    }

    public function getMessage():string{
        if(isset($_SESSION["message"]))
            return $_SESSION["message"];
        return "";
    }

    public function getUserValuta():\Models\M_Money{
        if($this->isLogged())
            return $this->getUser()->getValuta();
        else
            return \Models\M_Money::EUR();
    }

    public function setGuestAddress(int $id_comune, string $via, string $civico, string $note){
        if($id_comune == 0 )
            throw new \ModelException("Error comune required", __CLASS__, array("id_comune"=>$id_comune), 0);
        elseif($via == "")
            throw new \ModelException("Error via required", __CLASS__, array("via"=>$via), 0);
        elseif($civico == "")
            throw new \ModelException("Error civico required", __CLASS__, array("civico"=>$civico), 0);

        $_SESSION["address"] = new \Models\M_Indirizzo(0,F_Comune::find($id_comune), $via, $civico, $note);
    }

    public function setUserAddress(\Models\M_Indirizzo $addr){
        $_SESSION["address"] = clone $addr;
    }

    public function setGuestCart(\Models\M_Carrello $c){
        $_SESSION["cartId"] = NULL;
        $_SESSION["guestCart"] = clone $c;
    }

    public function setUserCart(int $id){
        $_SESSION["guestCart"] = NULL;
        $_SESSION["cartId"] = $id;
    }

    public function setGuestPayment(\Models\M_Pagamento $payment){
        $_SESSION["paymentId"] = NULL;
        $_SESSION["guestPayment"] = $payment;
    }

    public function setUserPayment(int $id){
        $_SESSION["guestPayment"] = NULL;
        $_SESSION["paymentId"] = $id;
    }

    public function setOrder(int $id){
        $_SESSION["orderId"] = $id;
    }

    public function setMessage(string $msg = ""){
        $_SESSION["message"] = $msg;
    }


}
