<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Segnalazione extends Model{
    private $id;
    private $utente;
    private $titolo;
    private $topic;
    private $motivazione;
    private $messaggio;
    private $risposta;
    private $stato;
    private $prodotto;
    private $ordine;

    public function __construct(int $id = 0, Utente $utente, string $titolo = '', string $topic = '', string $motivazione = '', string $messaggio = '', string $risposta = '', int $stato = 0, Prodotto $prodotto, Ordine $ordine){
        $this->id = $id;
        $this->utente = clone $utente;
        $this->titolo = $titolo;
        $this->topic = $topic;
        $this->motivazione = $motivazione;
        $this->messaggio = $messaggio;
        $this->risposta = $risposta;
        $this->stato = $stato;
        $this-> = clone $prodotto;
        $this->ordine = clone $ordine;
    }
} 
