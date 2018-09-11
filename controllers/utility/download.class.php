<?php
namespace Controllers;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class download implements Controller{
    
    public function image(Request $req){
        //come primo parametro dopo il controller e l-azione, riceve in imput l-id di una immagine, e ti restituisce l-immagine
        
        //pprima mi prendo la foto dla database
        $idProdotto=$req->getOtherParams()[0];
        $query="SELECT immagine FROM immagini, immagini_prodotti WHERE immagini_prodotti.id_immagine=immagini.id AND immagini_prodotti.id_prodotto='$idProdotto'";
        $tizio=\Singleton::DB();
        $tizioPreparato=$tizio->prepare($query);
        $tizioPreparato->execute();
        $tizioPreparato->bind_result($img);
        $tizioPreparato->fetch();
        $tizioPreparato->close();
        
        // poi me la carico su un file
        
        $myfile = fopen("./temp/image_for_product_$idProdotto", "w") or die("Unable to open file!");
        fwrite($myfile, $img);
        fclose($myfile);
        
        
        //poi la mostro dal file
        header('Content-Type: image/png');
        readfile("./temp/image_for_product_$idProdotto");   //le immagini si trovano nel folder temp. Non ancora implemento il fatto che si deve svuotare di tanto in tanto...
        //header("Content-Length: " . sizeof($img));
        //$response="<img src=data:image/gif;base64," . $this->base64encodeImages($img)."></img>";
        //echo($img);
        
        //echo "<img src=data:image/gif;base64," . $this->base64encodeImages($img)."></img>";
        
        
    }
    
    
    public function base64encodeImages($var){
        return base64_encode($var);
    }
    
    public function default(Request $req){
        echo "azione di default, cioe soltanto mostro questa scritta";
    }
    
    
    
    
    
    
    }
?>
