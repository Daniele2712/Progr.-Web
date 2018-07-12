<?php
namespace Controllers;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}


class upload{
    public function uploadProduct(Request $req){
        
        /*  DEVO ANCHE FILTRARE STI VALORI x VEDERE SE VANNO BENE!  */
        /*  LO FARO IN SEGUITO                                      */            
        
        /* req conosce i parametri della PSOT, li prendo per poi usarli per aggiungere tutto nel DB */
        $nome=$req->getString('nome', NULL, 'POST');
        $descrizione=$req->getString('descrizione', NULL, 'POST');
        $info=$req->getString('info', NULL, 'POST');
        $id_categoria=$req->getString('categoria', NULL, 'POST');
        $prezzo=$req->getFloat('prezzo', NULL, 'POST');
        $valuta=$req->getString('valuta', NULL, 'POST');
        $quantita=$req->getInt('quantita', NULL, 'POST'); /*  Con sta cosa della quantita, in realta devo modificare la tabbella che dice il nr di prodotti in un determinato magazzino*/
        
      /*            Inserimento prodotto        */
        
        $DB = \Singleton::DB();
        $querry = $DB->prepare("INSERT INTO `prodotti` (`nome`, `info`, `descrizione`, `id_categoria`, `prezzo`, `valuta`) VALUES  (?, ?, ?,?,?,?)");
        $querry->bind_param("sssids", $nome, $info, $descrizione, $id_categoria,$prezzo,$valuta);
        if($querry->execute()) echo "Upload of $nome into table 'prodotti' successful </br>";
        else echo "Error uploading prodotto";
        
        /*  devo metter un contorllo che fa in modo che se l-inserimento del prodotto oppure del immagine non va a buon fine, NON deve essere fatto nemmeno  */
        /*  l'inserimento nella tabbella imamgini_prodotti, che puo essere comunque fatta, a prescindere dal esito delle prime due, ma darebbe risultati sbagliati */
        /*  cioe collega un prodotto alla foto sbagliata  */
        
         /*         Inserimento immagine        */
        
        $file_location=$req->getImgLocation();  // mezza specie di controllo x vedere se riesce a capire che qualcuno ha messo un immagine
        if(isset($file_location))
        {
        $imgName=$req->getImgName();
        $imgType=$req->getImgType();
        $mediumBlob=file_get_contents($file_location);
        $querry = $DB->prepare("INSERT INTO `immagini` (`id`,`nome`, `size`, `type`, `immagine`) VALUES  (NULL, ?, 'img size', ?,?)");
        $querry->bind_param("sss", $imgName, $imgType, $mediumBlob);
        if($querry->execute()) echo "Upload of $imgName into table 'immagini' successful</br>";
        else echo "Error uploading of $imgName into table 'immagini'";
        }
        else {echo "Non trovo l'immagine! </br>";}
        
        /*          Inserimento in immagini_prodotti        */
        $dbresponse=$DB->query("SELECT COUNT(*) FROM `immagini`;"); // prendo l'ultimo id inserito nella tabbella immagini
        $id_immagine=mysqli_fetch_array($dbresponse)[0];    // la risposta , dopo essere fetchata, sara un array di un solo elemento, qindi prendo il 1o elemento
        
        $dbresponse=$DB->query("SELECT COUNT(*) FROM `prodotti`;"); // prendo l'ultimo id inserito nella tabbella prodotti
        $id_prodotto=mysqli_fetch_array($dbresponse)[0];    // la risposta , dopo essere fetchata, sara un array di un solo elemento, qindi prendo il 1o elemento
        //$id_prodotto=$DB->query("SELECT count(*) FROM 'prodptti;");
        
        if($dbresponse=$DB->query("INSERT INTO `immagini_prodotti` (`id`, `id_immagine`, `id_prodotto`)  VALUES (NULL, $id_immagine, $id_prodotto);")) echo " immagini_prodotti aggiornata!";
        else " immagini_prodotto NON inserito con successo! ";   
    }
    
    public function saveProduct(Request $req){
        
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
}
