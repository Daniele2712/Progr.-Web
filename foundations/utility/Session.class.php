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
        return $_SESSION["userId"]!==NULL;
    }
}
