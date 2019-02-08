<?php
namespace Controllers;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}


class upload{
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
        $magazzino=1;   /*  Devo usare la sessione per impostare il magazzino dentro cui inserire i prodotti*/
        $tuttoOK=TRUE;  // in caso qualcosa vada male lo imposto a FALSE e non faccio nemmeno i prossimi passi.


        if(!self::category_exists(intval($id_categoria)) && $id_categoria!='NULL') {$tuttoOK=false; echo "Category $id_categoria do not exists.";}

      /*            Inserimento prodotto        */
        if($tuttoOK)
        {
        $DB = \Singleton::DB();
        if($id_categoria!='NULL') $id_categoria!="'".$id_categoria."'";
        $querry = $DB->prepare("INSERT INTO `prodotti` (`nome`, `info`, `descrizione`, `id_categoria`, `prezzo`, `valuta`) VALUES ('$nome', '$info', '$descrizione',$id_categoria,'$prezzo','$valuta')");
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
