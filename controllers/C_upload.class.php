<?php
namespace Controllers;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}


class C_upload{
    /*          DEVI FILTRARE GLI INPUT X EVITARE SQL INJECTION E ROBA SIMILE*/
                    //DA aggiornare l-upload, per prendere in considerazione la parte dell-immagine preferita, e del size, e altre cose

    public static function uploadProduct(Request $req){

        /*  DEVO ANCHE FILTRARE STI VALORI x VEDERE SE VANNO BENE!  */
        /*  LO FARO IN SEGUITO                                      */

        /* req conosce i parametri della PSOT, li prendo per poi usarli per aggiungere tutto nel DB */
        $nome=$req->getString('nome', NULL, 'POST');
        $descrizione=$req->getString('descrizione', NULL, 'POST');
        $info=$req->getString('info', NULL, 'POST');
        $id_categoria=$req->getString('categoria', NULL, 'POST');
        $prezzo=$req->getFloat('prezzo', NULL, 'POST');
        $valuta=$req->getString('valuta', NULL, 'POST');
        $quantita=$req->getInt('quantita', NULL, 'POST');
        $magazzino=$req->getInt('magazzino', NULL, 'POST');   /*  Devo usare la sessione per impostare il magazzino dentro cui inserire i prodotti*/
        $tuttoOK=TRUE;  // in caso qualcosa vada male lo imposto a FALSE e non faccio nemmeno i prossimi passi.


        if(!self::category_exists(intval($id_categoria)) && $id_categoria!='NULL') {$tuttoOK=false; echo "Category $id_categoria do not exists.";}

      /*            Inserimento prodotto        */
        if($tuttoOK)
        {
        $DB = \Singleton::DB();
        if($id_categoria!='NULL') $id_categoria!="'".$id_categoria."'";
        $querry = $DB->prepare("INSERT INTO `prodotti` (`nome`, `info`, `descrizione`, `id_categoria`, `prezzo`, `id_valuta`) VALUES ('$nome', '$info', '$descrizione',$id_categoria,'$prezzo','$valuta')");
        if($querry->execute()) {$last_prodotto = $DB->lastId(); echo "SUCCESS inserting product $nome (id $last_prodotto) into table 'prodotti'</br>";}
        else {echo "ERROR uploading prodotto $nome"; $tuttoOK=FALSE;}
        }
        /*  devo metter un contorllo che fa in modo che se l-inserimento del prodotto oppure del immagine non va a buon fine, NON deve essere fatto nemmeno  */
        /*  l'inserimento nella tabbella imamgini_prodotti, che puo essere comunque fatta, a prescindere dal esito delle prime due, ma darebbe risultati sbagliati */
        /*  cioe collega un prodotto alla foto sbagliata  */


         /*         Inserimento immagine        */
        if($tuttoOK)
        {
        $file_location=$req->getImgLocation();  // mezza specie di controllo x vedere se riesce a capire che qualcuno ha messo un immagine
        if(isset($file_location))
        {
        $imgName=$req->getImgName();
        $imgType=$req->getImgType();
        $mediumBlob=file_get_contents($file_location);
        $querry = $DB->prepare("INSERT INTO `immagini` (`id`,`nome`, `size`, `type`, `immagine`) VALUES  (NULL, ?, 'img size', ?,?)");
        $querry->bind_param("sss", $imgName, $imgType, $mediumBlob);

        if($querry->execute()) {$last_image = $DB->lastId(); echo "SUCCESS inserting image $imgName (id $last_image) into table 'immagini'</br>";}
        else {echo "ERROR uploading $imgName into table 'immagini'</br>"; $tuttoOK=FALSE;}
        }
        else {echo "ERROR finding the image! </br>"; $tuttoOK=FALSE;}
        }


        /*          Inserimento in immagini_prodotti        */
        if($tuttoOK)
        {
        if($dbresponse=$DB->query("INSERT INTO `immagini_prodotti` (`id`, `id_immagine`, `id_prodotto`)  VALUES (NULL, $last_image, $last_prodotto);")) echo " SUCCESS linking image $imgName (id $last_image) and prouct $nome (id $last_prodotto) inside 'immagini_prodotti'!</br>";
        else {" immagini_prodotto NON inserito con successo! ";  $tuttoOK=FALSE;}
        }

        /*  Ora devo collegare il prodotto appena inserito con la tabbella che sa in che */
        if($tuttoOK)
        {
        $querry = $DB->prepare("INSERT INTO `items_magazzino` (`id_magazzino`, `id_prodotto`, `quantita`) VALUES  (?, ?, ?)");
        $querry->bind_param("iii", $magazzino, $last_prodotto, $quantita);
        if($querry->execute()) echo "SUCCESS linking product $nome (id $last_prodotto) and magazzino with id $magazzino inside 'items_magazzino'</br>";
        else {echo "Error Linking $nome(id $last_prodotto) into to magazzino $magazzino)"; $tuttoOK=FALSE;}
        }
    }

    public static function uploadDipendente(Request $req){

        /*  DEVO ANCHE FILTRARE STI VALORI x VEDERE SE VANNO BENE!  */
        /*  LO FARO IN SEGUITO                                      */

        /* req conosce i parametri della PSOT, li prendo per poi usarli per aggiungere tutto nel DB */
        $nome=$req->getString('nome', NULL, 'POST');
        $cognome=$req->getString('cognome', NULL, 'POST');
        $id_ruolo=$req->getString('ruoloDipendente', NULL, 'POST');
        $id_contratto=$req->getString('contrattoDipendente', NULL, 'POST');
        $stipendio=$req->getFloat('stipendioOrario', NULL, 'POST');
        $id_magazzino=$req->getString('magazzino', NULL, 'POST');
        $tuttoOK=TRUE;  // in caso qualcosa vada male lo imposto a FALSE e non faccio nemmeno i prossimi passi.


        /*  Verifica che:       se qualcosa va male imposto tuttoOK=FALSE;
         *  id_ruolo esiste
         *  colui che inserisce il ruolo ha il permesso di farlo(un gestore non puo inserire un amministratore)
         *  il magazzino in cui si vuole inserire il dipendente e sotto il controllo del gestore
         */

      /*            Inserimento dipendente        */
        if($tuttoOK)
        {
        $DB = \Singleton::DB();
        echo "Successfully updated dipendenti.<br/>";
        echo "$nome $cognome was added to the list<br/><br/>";
        echo "(PS. ancora da implementare)";
        }
    }

    public static function uploadMagazzino(Request $req){
      if(!\Singleton::Session()->isLogged() ){ // Se la richiesta la fa un utente NON loggato
        \Foundations\Log::logMessage("!Non Authorized Request! Non logged User tried to access admin function(uploadMagazzino)!",$req);
        header('Location: '."http://".$req->getServerName());
      }
      elseif(\Singleton::Session()->getUser()->getRuolo() != "Amministratore") // Se la richiesta la fa un utente loggato ma che non e' amministratore
      {
           $badUserId=\Singleton::Session()->getUser()->getId();
           \Foundations\Log::logMessage("!Non Authorized Request! User(ID=$badUserId) tried to access admin function(uploadMagazzino)!",$req);
           header('Location: '."http://".$req->getServerName());
     }
     else{   // se la richiesta la fa effettivamente l-amministratore che ha il permesso di farla
       $citta=$req->getString('citta', NULL, 'POST');
       $cap=intval($req->getString('cap', NULL, 'POST'));
       $provincia=$req->getString('provincia', NULL, 'POST');
       $via=$req->getString('via', NULL, 'POST');
       $civico=$req->getString('civico', NULL, 'POST');

       /* Verifica che i valori inseriti vadano BENE  */

       $comuneSelezionato=\Foundations\F_Comune::search($citta, $cap,$provincia);  //Controllo che la combinazione citta, cap e provincia sia presente nel db
       if(!$comuneSelezionato){
         echo "La combinazione '$citta' , '$cap' , '$provincia' non esiste.";
       }
       else{ //Se effettivamente la combinazione c'e nel database
         $indirizzo=\Foundations\F_Indirizzo::search($comuneSelezionato->getId(), $via, $civico);  //Cerco l'indirizzo che voglio usare
         if($indirizzo==NULL){   // cioe se non ha trovato nel BD il mio indirizzo
           $indirizzoTemp=new \Models\M_Indirizzo(-1, $comuneSelezionato, $via, $civico, "noteeee");  // creo un nuovo indirizzo temporaneo, con ID -1, solo per poter inserire quel indirizzo nel DB
           if(\Foundations\F_Indirizzo::insert($indirizzoTemp, array())) echo "Nuovo indirizzo inserito corretamente"; // e lo inserisco nel DB
           else echo "Errore inserimento indirizzo.";  // oppure fallisco nel inserirlo nel DB
           $indirizzo=\Foundations\F_Indirizzo::search($comuneSelezionato->getId(), $via, $civico); // il mio indirizzo ha come id -1 quindi lo sovrascrivo con in altro indirizzo, uguale, ma con l-id giusto, preso dal DB
         }

         $newMagazzino= new \Models\M_Magazzino(-1, $indirizzo, array(), NULL, array());  //  ho usato -1 per i'id xke ho bisogno di un intero, tanto quando verra memorizzato nel db usera un id prograssivo. Qui creo il modello del magazzino che poi andro' ad aggingere nel DB
         if(\Foundations\F_Magazzino::insert($newMagazzino)) echo "Magazzino inserito correttamente."; // inserisco il magazzino nel DB
         else echo "Errore inserimento magazzino.";    //oppure fallisco nel farlo
       }
    }
  }

    public static function uploadGestore(Request $req){

        /*  DEVO ANCHE FILTRARE STI VALORI x VEDERE SE VANNO BENE!  */
        /*  LO FARO IN SEGUITO                                      */

        /* req conosce i parametri della PSOT, li prendo per poi usarli per aggiungere tutto nel DB */
        $nome=$req->getString('nome', NULL, 'POST');
        $cognome=$req->getString('cognome', NULL, 'POST');
        $id_ruolo=$req->getString('ruoloDipendente', NULL, 'POST');
        $id_contratto=$req->getString('contrattoDipendente', NULL, 'POST');
        $stipendio=$req->getFloat('stipendioOrario', NULL, 'POST');
        $id_magazzino=$req->getString('magazzino', NULL, 'POST');
        $tuttoOK=TRUE;  // in caso qualcosa vada male lo imposto a FALSE e non faccio nemmeno i prossimi passi.


        /*  Verifica che:       se qualcosa va male imposto tuttoOK=FALSE;
         *  id_ruolo esiste
         *  colui che inserisce il ruolo ha il permesso di farlo(un gestore non puo inserire un amministratore)
         *  il magazzino in cui si vuole inserire il dipendente e sotto il controllo del gestore
         */

      /*            Inserimento dipendente        */
        if($tuttoOK)
        {
        $DB = \Singleton::DB();
        echo "Successfully updated gestori.<br/>";
        echo "$nome $cognome was added to the list<br/><br/>";
        echo "(PS. ancora da implementare)";
        }
    }



    public static function saveProduct(Request $req){

        /*  Per ora non serve, ma se in un futuro dovremmo salvare dei file sul server (quindi non nel database) questa ci puo essere utile  */

$target_dir = "/tmp/phptemp/";
$file_name=$req->getImgName();
$target_file = $target_dir.$file_name;
echo "file di arrivo $target_file";
$uploadOk = 1;

if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($req->getImgSize() > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
$imageFileType=$req->getImgType();
if($imageFileType != "image/jpeg" && $imageFileType != "image/png" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($req->getImgLocation(), $target_file)) {
        echo "The file $file_name has been uploaded.";
    } else {
        echo "else ----Sorry, there was an error uploading your file.";
    }
}

    }

     public static function uploadCategory(Request $req){
         $DB=\Singleton::DB();
         $categoria=$req->getString('categoria' , NULL , 'POST');
         $padre=$req->getString('padre' , NULL , 'POST');

     if(strtolower($padre)=='null')
     {
          if($DB->query("INSERT INTO `categorie` (`nome`, `padre`) VALUES ('$categoria' , NULL);")) echo " Categoria $categoria aggiornata!";
          else " Non e possibile aggiungere la categoria ";
     }
     else{
         $esistePadre=mysqli_fetch_array($DB->query("SELECT count(*) FROM `categorie` WHERE nome='$padre';"))[0];
         if($esistePadre!=0){
           $idPadre=mysqli_fetch_array($DB->query("SELECT id FROM `categorie` WHERE nome='$padre';"))[0];
           if($DB->query("INSERT INTO `categorie` (`nome`, `padre`) VALUES ('$categoria' , '$idPadre');")) echo " Categoria aggiornata!";
            else " Non e possibile aggiungere la categoria ";
         }
         else{ echo "PADRE NON ESISTE! </br> Se desideri aggiungere una categoria senza padre, aggiungi il valore 'NULL' nel riquadro padre";}
        }
     }



    private function category_exists($id){
        $dbresponse=\Singleton::DB()->query("SELECT COUNT(*) as result FROM `categorie` WHERE id=$id;");
        while($r = mysqli_fetch_assoc($dbresponse)) {$rows[] = $r; }
        $categoriesFound=$rows[0]['result'];
        if($categoriesFound!=0) return true;
        else return false;
    }
}
