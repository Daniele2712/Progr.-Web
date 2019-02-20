<?php
namespace Controllers;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class checkout implements Controller{

public static function displayCheckout(Request $req){
    $session=\Singleton::Session();
    
        $v = new \Views\Checkout();
        $v->addCart($session->getCart());   // la view ha bisogno del carrello x mostrare gli item sull adestra dello schermo,appunto nel carrelo
        $v->setHtmlValuta($session->getUser()->getIdValuta());    //sara la view che dovra trovarsi il simbolo della valuta a partire dal ID
        $v->setDatiSpedizione($session->getUser()->getDatiAnagrafici(), \Foundations\Indirizzo::getIndirizzoPreferitoOfUserId($session->getUser()->getId()));
        $v->render();
    }
    
    
    
    public static function pagamentoMastercard(Request $req){
        $pagamentoAndatoABuonFine=true;
        
        // qui va fatta la verifica x vedere se il pagamento e andato a buon fine
        
        if($pagamentoAndatoABuonFine){
            // Questa prima parte salva l'ordine nel DB
            $session=\Singleton::Session();
            $cart=$session->getCart();
            
            $id=$session->getUser()->getId();
            $items=$cart->getItems();
            $indirizzo=\Foundations\Indirizzo::getIndirizzoPreferitoOfUserId($session->getUser()->getId());
            $datiAnagrafici=$session->getUser()->getDatiAnagrafici();
            $idValuta=$session->getUser()->getIdValuta();
            $subtotale=new \Models\Money($cart->getTotale()->getPrezzo($idValuta),$idValuta);
            $IndirizzoMagazzino= \Foundations\Magazzino::find(1)->getIndirizzo();      // DA CAMBIARE       DA CAMBIARE         DA CAMBIARE         DA CAMBIARE   per ora va bene ma se avremo diversi magazzini, dobbiamo fare in modo che ci colleghiamo al magazzino piu vicino
            $IndirizzoUtente= \Foundations\Indirizzo::getIndirizzoPreferitoOfUserId($id);          
            $speseSpedizione= \Foundations\Indirizzo::calcolaSpeseSpedizione($IndirizzoMagazzino, $IndirizzoUtente , $idValuta);    // questa funzione calcola il costo della spedizione, basato sulla distanza tra i due indirizzi
            $totale=\Models\Money::add($subtotale, $speseSpedizione, $idValuta);    //subtotale e speseSpedizione gia dovrebbero essere nelal valuta del utente, pero per sicurezza lo verifico anche nella funzione add
            $dataOrdine=new \DateTime('now');
            $dataConsegna=new \DateTime('now + 4 hours');    //magari posso usare altre funzioni che calcolano l'arrivo..ma per ora basta cosi
            
            $ordine=new \Models\Ordine($id, $items, $indirizzo, $datiAnagrafici, $subtotale->getPrezzo(), $speseSpedizione->getPrezzo(), $totale->getPrezzo(), $idValuta, $dataOrdine, $dataConsegna);
            \Foundations\Ordine::insert($ordine);
            
            
            //Questa seconda parte svuota il carrello del utente loggato
            $idCart=$session->getCart()->getId();
            \Foundations\Carrello::svuotaCarrello($idCart);
            
            
            
            
            echo "Pagamento andato a buon fine";
            echo "Ho inserito l-ordine nel elenco dei tuoi ordini";
            echo "Devo ancora svuotare il carrello";
        /*$session=\Singleton::Session();
        $v = new \Views\Pagamento();
        $v->setBuonFine();
        $v->render();*/
        }
        else{
            echo "Pagamento Fallito";
        }
    }
    
    
    
    

 public static function default(Request $req){
     echo "azione di defaiult del controllore checkout";
 }
}


?>
