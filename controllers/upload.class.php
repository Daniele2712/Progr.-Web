<?php
namespace Controllers;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}


class upload{
    public function uploadProduct(Request $req){

        /*
            i - integer
            d - double
            s - string
            b - BLOB
        */
        /*      INOLTRE DEVO AGGIUNGERE LA PARTE DEL BLOB! cosi ceh col prodotto inserisco anche la sua immagine*/

        /*       QUI devo trasformare prendere dalla richiesta tutte le info e metterle delle variabili che poi mettrro nelal bind param*/
        echo "<pre>";
        echo var_dump($req);
        echo "</pre>";

        /*  DEVO ANCHE FILTRARE STI VALORI x VEDERE SE VANNO BENE!  */
        $nome=[$_POST]["nome"];
        $descrizione=[$_POST]["descrizione"];
        $info=[$_POST]["info"];
        $id_categoria=[$_POST]["categoria"];
        $prezzo=[$_POST]["prezzo"];
        $valuta=[$_POST]["valuta"];
        $quantita=[$_POST]["quantita"]; /*  Con sta cosa della quantita, in realta devo modificare la tabbella che dice il nr di prodotti in un determinato magazzino*/
        $img=[$_FILE]["image"];

        $DB = Singleton::DB();
        $querry = $DB->prepare("INSERT INTO `prodotti` (`nome`, `info`, `descrizione`, `id_categoria`, `prezzo`, `valuta`) VALUES  (?, ?, ?,?,?,?)");
        $querry->bind_param("sssids", $nome, $info, $descrizione, $id_categoria,$prezzo,$valuta);
        var_dump ($querry->execute());
        return $querry->execute();

    }

     public function tellme(Request $req){

        echo "<pre>";
        echo var_dump($req);
        echo "</pre>";
        echo "Told YOU";
    }

}
