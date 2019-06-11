<?php
namespace Controllers;
use \Views\Request as Request;
use \utenti\F_Dipendente as F_Dipendente;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}


class C_upload{
/*
\Singleton::Session()::isAdmin()            --verifica se l-utente loggato e' un amministratore
\Singleton::Session()::isAdminOrGestore()   --verifica se l-utente loggato e' un amministratore o un gestore
*/
public static function uploadProduct(Request $req){
  if(\Singleton::Session()::isAdminOrGestore()){ // se la richiesta la fa effettivamente l-amministratore o il gestore
  /*  Creo l'array con la sola immagine favorita, da mettere nel costruttore del modello del prodotto*/
  if($req->hasFavoriteImageUploaded()){
      $arrayFav=array();
     $favImg=$req->getOrderedFavoriteImage();
     $imgContent=file_get_contents($favImg['tmp_name']);
     $M_favImg=new \Models\M_Immagine(0,$favImg['name'],$favImg['size'],$favImg['type'], $imgContent);
     $arrayFav[]=clone $M_favImg;
  }else{
    echo "Non e' stata aggiunta la foto Favorita. Verra usata la todo di default.</br>";
    $defaultFoto=\Foundations\F_Immagine::getDefaultFoto();
    $arrayFav=array($defaultFoto);
  }

  /*  Creo l'array con tutte le other immagini, da mettere nel costruttore del modello del prodotto*/
  if($req->hasOtherImagesUploaded()){
    $arayOther=array();
    $otherImg=$req->getOrderedOtherImages();
    foreach($otherImg as $singleImage){
      $singleImageContent=file_get_contents($singleImage['tmp_name']);
      $M_singleImg=new \Models\M_Immagine(0,$singleImage['name'],$singleImage['size'],$singleImage['type'], $singleImageContent);
      $arrayOther[]=clone $M_singleImg;
    }
  }else{
    echo "Non sono state aggiunte altre foto.</br>";
    $arrayOther=array();
  }

  /*  Creo il modello del prodotto  */
  $nome=$req->getString('nome', NULL, 'POST');
  $info=$req->getString('info', NULL, 'POST');
  $descrizione=$req->getString('descrizione', NULL, 'POST');
  $id_categoria=$req->getString('categoria', NULL, 'POST');
  $cat=\Foundations\F_Categoria::find($id_categoria); if(!\Foundations\F_Categoria::seek(intval($id_categoria)) && $id_categoria!='NULL') {$tuttoOK=false; echo "Category $id_categoria do not exists.";}

  $prezzo=$req->getFloat('prezzo', NULL, 'POST');
  $idValuta=$req->getString('valuta', NULL, 'POST');
  $money=new \Models\M_Money($prezzo,$idValuta);
  $quantita=$req->getInt('quantita', NULL, 'POST');
  $magazzino=$req->getInt('magazzino', NULL, 'POST');   /*  Devo usare la sessione per impostare il magazzino dentro cui inserire i prodotti*/


  $newProdotto=new \Models\M_Prodotto(0, $nome, $info, $descrizione, $cat, $money);
  $newProdotto->setFotoPreferita($arrayFav[0]);   /*  Al modello del prodotto ci aggiungo la foto preferita   */
  foreach($arrayOther as $img) $newProdotto->addOtherFoto($img); /*  Al modello del prodotto ci aggiungo le altre foto    */

  $params=array('idMagazzino'=>$magazzino, 'quantita'=>$quantita);
  $insertedId=\Foundations\F_Prodotto::insert($newProdotto, $params);

  }
  else {\Foundations\Log::logMessage("Tentato accesso a uploadProduct riservata solo agli admin e ai gestori", $req);}
  return;
}

public static function uploadMagazzino(Request $req){
  if(\Singleton::Session()::isAdmin()){
   $citta=$req->getString('citta', NULL, 'POST');
   $cap=intval($req->getString('cap', NULL, 'POST'));
   $provincia=$req->getString('provincia', NULL, 'POST');
   $via=$req->getString('via', NULL, 'POST');
   $civico=$req->getString('civico', NULL, 'POST');

   $tuttoOK=TRUE;

   if(!$tuttoOK){
     echo "I parametri inseriti non sono validi ";
     return;
   }

   /* Verifica che i valori inseriti vadano BENE  */

   $comuneSelezionato=\Foundations\F_Comune::search($citta, $cap,$provincia);  //Controllo che la combinazione citta, cap e provincia sia presente nel db
   if(!$comuneSelezionato){
     echo "La combinazione '$citta' , '$cap' , '$provincia' non esiste.".PHP_EOL;
   }
   else{ //Se effettivamente la combinazione c'e nel database
     $indirizzo=\Foundations\F_Indirizzo::search($comuneSelezionato->getId(), $via, $civico);  //Cerco l'indirizzo che voglio usare
     if($indirizzo==NULL){   // cioe se non ha trovato nel BD il mio indirizzo
       $indirizzoTemp=new \Models\M_Indirizzo(-1, $comuneSelezionato, $via, $civico);  // creo un nuovo indirizzo temporaneo, con ID -1, solo per poter inserire quel indirizzo nel DB
       if(\Foundations\F_Indirizzo::insert($indirizzoTemp, array())) echo "Nuovo indirizzo inserito corretamente.</br>"; // e lo inserisco nel DB
       else echo "Errore inserimento indirizzo.</br>";  // oppure fallisco nel inserirlo nel DB
       $indirizzo=\Foundations\F_Indirizzo::search($comuneSelezionato->getId(), $via, $civico); // il mio indirizzo ha come id -1 quindi lo sovrascrivo con in altro indirizzo, uguale, ma con l-id giusto, preso dal DB
     }

     $newMagazzino= new \Models\M_Magazzino(-1, $indirizzo, array(), NULL, array());  //  ho usato -1 per i'id xke ho bisogno di un intero, tanto quando verra memorizzato nel db usera un id prograssivo. Qui creo il modello del magazzino che poi andro' ad aggingere nel DB
     if(\Foundations\F_Magazzino::insert($newMagazzino)) echo "Magazzino inserito correttamente.</br>"; // inserisco il magazzino nel DB
     else echo "Errore inserimento magazzino.</br>";    //oppure fallisco nel farlo
   }
  }
  else \Foundations\Log::logMessage("Tentato accesso a richiesta riservata solo agli admin", $req);
}

public static function uploadDipendente(Request $req, array $params=NULL){
  if(\Singleton::Session()::isAdminOrGestore()){
    $tuttoOK=TRUE;  // in caso qualcosa vada male lo imposto a FALSE e non faccio nemmeno i prossimi passi.

    /* req conosce i parametri della PSOT, li prendo per poi usarli per aggiungere tutto nel DB */
    $nome=$req->getString('nome', NULL, 'POST');
    $cognome=$req->getString('cognome', NULL, 'POST');
    $email=$req->getString('email', NULL, 'POST');
    $username=$req->getString('username', NULL, 'POST'); if(\Foundations\F_Utente::seekUsername($username)) {echo "Username already in use"; return;}
    $password=$req->getString('password', NULL, 'POST');
    if(isset($params['ruolo'])) $nomeRuolo=$params['ruolo']; else $nomeRuolo=$req->getString('ruoloDipendente', NULL, 'POST');
    if(strtolower($nomeRuolo)=='gestore' or strtolower($nomeRuolo)=='amministratore'){  /*  Se vuoi inserire un gestore o un amministratore devi essere admin*/
      if(!\Singleton::Session()::isAdmin()) {\Log::logMessage("Tentato inserimento di un gesore/amministratore da parte di utente che non e' gestore", $req); echo "Non hai i permessi per effettuare l'operazione"; return;}}
    $id_contratto=$req->getString('contrattoDipendente', NULL, 'POST');
    $floatStipendio=$req->getFloat('stipendioOrario', NULL, 'POST');
    $id_magazzino=$req->getString('magazzino', NULL, 'POST');


    //check if ruolo exists
    if(empty($nome) || empty($cognome) || empty($email) || empty($username) || empty($password) || empty($id_contratto) || empty($floatStipendio) || empty($id_magazzino)) $tuttoOK=false;

    if(!F_Dipendente::existsNomeRuolo($nomeRuolo)) $tuttoOK=FALSE;
    //check if id_contratto exists
    $nomeContratto=F_Dipendente::idToContratto($id_contratto);
    if(!$nomeContratto) $tuttoOK=FALSE;
    //check if id_magazzino existsIdRuolo
    if(!\Foundations\F_Magazzino::seek($id_magazzino)) $tuttoOK=FALSE;



    if(!$tuttoOK){  // se ci sono stati problemi mostro questo messaggio ed esco, altrimenti continuo.
      echo "I parametri inseriti non sono validi ";
      return;
    }
    else{ // se va tutto bene e passo tutti i controlli, faccio creo il dipendente e poi gli faccio l-upload
    // create modello dati datiAnagrafici
    $datiAna=new \Models\M_DatiAnagrafici(0 , $nome, $cognome, "0000", new \DateTime('1922-02-02'));  // adesso il modello ha id 0, ma appena lo metto nel db aggiornero l-id con quello presente nel db
    // create modello dipendente  (dipendente estende l-utente,  e per questo non devo creare prima l-utente, ma direttamente il dipendente)
    $stipendio=new \Models\M_Money($floatStipendio); // automaticamente lo mette in euro, potrei metterlo anche direttamtne nella creazione del dipendente
    $dipendente=new \Models\utenti\M_Dipendente(0, $datiAna, $email, $username,0, $nomeRuolo, $nomeContratto, new \DateTime(), 40 ,$stipendio, NULL, array() );
    // Upload that user to the database
    $risult=\Foundations\Utenti\F_Dipendente::insertDipendente($dipendente, md5($password),$id_magazzino);
    return $result;
    }
  }
  else {\Foundations\Log::logMessage("Tentato accesso a uploadDipendente riservata solo agli admin e ai gestori", $req);}
  return;
}

public static function uploadGestore(Request $req){
  if(\Singleton::Session()::isAdmin()){
  $params['ruolo']='gestore';   // impostando questa variabile forzo l-upload di un gestore, e la funzione uploadDipendenti non cerchera piu il ruolo, ma lo forzera a gestore
  self::uploadDipendente($req, $params);
  }
  else {\Foundations\Log::logMessage("Tentato accesso a uploadGestore riservata solo agli admin", $req);}
  return;
}

public static function uploadCategory(Request $req){
  if(\Singleton::Session()::isAdminOrGestore()){
   $categoria=$req->getString('categoria' , NULL , 'POST');
   $padre=$req->getString('padre' , NULL , 'POST');
   //if(empty($categoria)) {echo "Non hai inserito una categoria!<br>"; return;}
   if(empty($padre)) {$padre=NULL;}
   else{
     if(!\Foundations\F_Categoria::seekName($padre)) {echo "Il padre che hai inserito ('$padre') non esiste!<br>"; return;}
     else {$idPadre=\Foundations\F_Categoria::nameToId($padre);
            $padre=\Foundations\F_Categoria::find($idPadre);
          }
   }
   $newCategoria=new \Models\M_Categoria(0, $categoria, $padre); // Creo il modello del modello che voglio inserire nel DB
   $newId=\Foundations\F_Categoria::insert($newCategoria);
   echo "Nuova categoria inserita : $categoria (ID: $newId)";
  }
  else {\Foundations\Log::logMessage("Tentato accesso a uploadCategory riservata solo agli admin e ai gestori", $req);}
  return;
}

}
