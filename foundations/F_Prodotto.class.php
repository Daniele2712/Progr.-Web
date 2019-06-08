<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class F_Prodotto extends Foundation{
    protected static $table = "prodotti";

    public static function create(array $obj): Model{
        $DB = \Singleton::DB();
        $sql = "SELECT COALESCE(id_opzione,valori.valore) AS valore, filtri.nome, filtri.tipo
            FROM valori
            LEFT JOIN filtri ON filtri.id = id_filtro
            WHERE id_prodotto = ?";
        $p = $DB->prepare($sql);
        $p->bind_param("i",$obj["id"]);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $r = array();
        $res = $p->get_result();
        $p->close();
        if($res === FALSE)
            throw new \SQLException("Error Fetching Statement", $sql, $p->error, 4);
        else
            while ($row = $res->fetch_array(MYSQLI_ASSOC)){
                if($row["tipo"] === "multicheckbox"){
                    if(!array_key_exists($row["nome"], $r))
                        $r[$row["nome"]] = array();
                    $r[$row["nome"]][] = $row["valore"];
                }else
                    $r[$row["nome"]] = $row["valore"];
            }
        $fotoPreferita = \Foundations\F_Immagine::findFavouriteByProduct($obj["id"]);
        $foto = \Foundations\F_Immagine::findByProduct($obj["id"]);
        return new \Models\M_Prodotto($obj["id"], $obj["nome"], $obj["info"], $obj["descrizione"], F_Categoria::find($obj["id_categoria"]), new \Models\M_Money($obj["prezzo"], $obj["id_valuta"]), $r, $fotoPreferita, $foto);
    }

    public static function update(Model $prodotto, array $params = array()): int{
        $DB = \Singleton::DB();
        $sql = "UPDATE ".self::$table." SET nome=?, info=?, descrizione=?, id_categoria=?, prezzo=?, id_valuta=? WHERE id = ?";
        $p = $DB->prepare($sql);
        $money=$prodotto->getPrezzo();
        $categoriaid=$prodotto->getCategoriaId();
        $id = $prodotto->getId();
        $p->bind_param("sssiisi", $prodotto->getNome(), $prodotto->getInfo(), $prodotto->getDesrizione(), $categoriaid , $money->getPrezzo(), $money->getValuta(), $prodotto->getId());
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->close();
        return $id;
    }
        //TODO: ok qui ci sono vari errori, reimplementa save, non salvare direttamente le immagini, usa F_Immagine, e non salvare items_magazzino, fai il contrario, salva magazzino che salva items_magazzino, che salva prodotto
    public static function insert(Model $prodotto, array $params = array()): int{

      /*  Prima parte e' l-inserimento del prodotto */
      $DB = \Singleton::DB();
      $sql = "INSERT INTO ".self::$table." VALUES(NULL, ?, ?, ?, ? ,? ,?)";
      $p = $DB->prepare($sql);
      $money=$prodotto->getPrezzo();
      $categoriaid=$prodotto->getCategoriaId();
      $p->bind_param("sssiis", $prodotto->getNome(), $prodotto->getInfo(), $prodotto->getDescrizione(), $categoriaid , $money->getPrezzo(), $money->getValuta());
      if(!$p->execute())
          throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
          echo "SUCCESS creating product( ID " .$DB->lastId(). ").</br>";
      $p->close();
      $idInsertedProduct=$DB->lastId();
      $prodotto->setId($idInsertedProduct); /*  Qiomdo appena scopro l-id del prodotto, lo aggiorno, perche il mio modello aveva come id 0( perche prima di inserire il prodobbo nel db non posso sapere che id avra')*/

      /*  Seconda parte - devo collegare il prodotto appena inserito nella con il magazzino giusto */
      $sql = "INSERT INTO `items_magazzino` (`id_magazzino`, `id_prodotto`, `quantita`) VALUES  (?, ?, ?)";
      $p = $DB->prepare($sql);
      $p->bind_param("iii", $params['idMagazzino'], $prodotto->getId(), $params['quantita']);
      if($p->execute()) echo "SUCCESS linking product ".$prodotto->getNome()." (id ". $prodotto->getId()." ) and magazzino with id ".$params['idMagazzino']. " inside 'items_magazzino'</br>";
      else {echo "Error Linking product ".$prodotto->getNome()." (id ". $prodotto->getId()." ) and magazzino with id ".$params['idMagazzino']. " inside 'items_magazzino'</br>"; $tuttoOK=FALSE;}


      /*  Seconda parte e' l'inserimento della foto favorita  */
      $favImg=$prodotto->getFotoPreferita();
      $querry = $DB->prepare("INSERT INTO `immagini` (`id`,`nome`, `size`, `type`, `immagine`) VALUES  (NULL, ?, ?, ?,?)");
      $querry->bind_param("siss", $favImg->getName(), $favImg->getSize(), $favImg->getMIMEType(), $favImg->getImage());
      if($querry->execute()) {$lastFavImage = $DB->lastId(); echo "SUCCESS inserting favorite image (ID : $lastFavImage) of ". $prodotto->getNome() ."into table 'immagini'</br>";}
      else {echo "ERROR uploading $imgName into table 'immagini'</br>"; $tuttoOK=FALSE;}

      /*  e il linkaggio dell'immagineFavoria al prodotto  */
      $sql = "INSERT INTO `immagini_prodotti` (`id`, `id_immagine`, `id_prodotto`, `preferita`)  VALUES (NULL, ?, ?, 1);";
      $p = $DB->prepare($sql);
      $p->bind_param("ii", $lastFavImage, $prodotto->getId());
      if($querry->execute()) {echo "SUCCESS linking product ". $prodotto->getNome() . " to favorite image ( ID : ".$lastFavImage." ) inside 'immagini_prodotti'!</br>";}
      else {"ERROR linking product ". $prodotto->getNome() . " to its favorite image ( ID : ".$lastFavImage." ) inside 'immagini_prodotti'!</br>";  $tuttoOK=FALSE;}


      /*  Inserimento foto other  e i relativi linkaggi al prodotto*/
      foreach($prodotto->getOtherFoto() as $singleImage){
      /*  Inserimento della foto other  */
      $querry = $DB->prepare("INSERT INTO `immagini` (`id`,`nome`, `size`, `type`, `immagine`) VALUES  (NULL, ?, ?, ?,?)");
      $querry->bind_param("siss", $singleImage->getName(), $singleImage->getSize(), $singleImage->getMIMEType(), $singleImage->getImage());
      if($querry->execute()) {$lastImage = $DB->lastId(); echo "SUCCESS inserting image (ID : ".$lastImage. " ) for ".$prodotto->getNome(). " into table 'immagini'</br>";}
      else {echo "ERROR inserting image for ".$prodotto->getNome(). " into table 'immagini'</br>"; $tuttoOK=FALSE;}

      /*  e il relativo linkaggi al prodotto   */
      $sql = "INSERT INTO `immagini_prodotti` (`id`, `id_immagine`, `id_prodotto`, `preferita`)  VALUES (NULL, ?, ?, 0);";
      $p = $DB->prepare($sql);
      $p->bind_param("ii", $lastImage, $prodotto->getId());
      if($querry->execute()) {echo " SUCCESS linking image (ID : ".$lastImage. " ) to ".$prodotto->getNome(). " into table 'immagini_prodotti'!</br>";}
      else {" ERROR linking image (ID : ".$lastImage. " ) to ".$prodotto->getNome(). " into table 'immagini_prodotti'!</br>";  $tuttoOK=FALSE;}
      }
    }

    public static function getProdottiFiltrati($id_magazzino, $categoria, $id_categoria, $nome, $prezzo_min, $prezzo_max){        // !!! ATTENZIONE LA FUNZIONE SHOW DIPENDENTI DOVREBBE VERIFICARE PRIMA SE IN EFFETTI L-UTENTE CHE RICHIEDE DI VEDERE I PRODOTTI HA IL DIRITTO DI FARLO PER EVITARE CHE UN GESTORE VEDA PRODOTTI DI TUTTI I MAGAZZINI
        $rows=array();
        // {"id_prodotto":"2","nome_prodotto":"piselli","categoria_prodotto":"alimentari","descrizione_prodotto":"blabla","info_prodotto":"altro bla","prezzo_prodotto":"7.95","simbolo_valuta_prodotto":"&euro;","id_magazzino":"1","quantita_prodotto":"178"}
        //aggiungere eventuali controlli sul tipo di variabile che gli viene passato e possibili sql injection
        if($id_magazzino===null) $sql_id_magazzino="items_magazzino.id_magazzino LIKE '%'";
        else $sql_id_magazzino="items_magazzino.id_magazzino=$id_magazzino";        //possiible che devo trasformare il id in un nnumero??? con intval? Oppure i singoli apici....

        if($categoria===null) $sql_nome_categoria="categorie.nome LIKE '%'";
        else $sql_nome_categoria="categorie.nome='$categoria'";

        if($id_categoria===null) $sql_id_categoria="categorie.id LIKE '%'";
        else $sql_id_categoria="categorie.id='$id_categoria'";

        if($nome===null) $sql_nome_prodotto="prodotti.nome LIKE '%'";
        else $sql_nome_prodotto= "prodotti.nome LIKE '%$nome%'";

        if($prezzo_min===null) $sql_prezzo_min="prodotti.prezzo LIKE '%'";
        else $sql_prezzo_min = "prodotti.prezzo > $prezzo_min";

        if($prezzo_max===null) $sql_prezzo_max="prodotti.prezzo LIKE '%'";
        else $sql_prezzo_max="prodotti.prezzo < $prezzo_max";

        /* HO PROBLEMI A USARE LA PREPARED STATEMENT!!!  DEVO RISOLVERE PERCHE NON VOGLIO FARE TUTTO CON LA QUERRY*/
        /*
        $conn= \Singleton::DB();
        $stmt = $conn->prepare("SELECT prodotti.id as id_prodotto, prodotti.nome as nome_prodotto, categorie.nome as categoria_prodotto, prodotti.descrizione as descrizione_prodotto, prodotti.info as info_prodotto, prodotti.prezzo as prezzo_prodotto, valute.simbolo as simbolo_valuta_prodotto, items_magazzino.id_magazzino as id_magazzino, items_magazzino.quantita as quantita_prodotto FROM prodotti, categorie, items_magazzino, valute WHERE categorie.id=prodotti.id_categoria AND valute.id=prodotti.id_valuta AND items_magazzino.id_prodotto=prodotti.id AND ? AND ? AND ? AND ? AND ? AND ?");
        $stmt->bind_param("ssssss", $sql_id_magazzino, $sql_nome_categoria, $sql_id_categoria, $sql_nome_prodotto, $sql_prezzo_min, $sql_prezzo_max);
        $stmt->execute();
        $prodotti=$stmt->get_result();
        $stmt->close();
         while($r = $prodotti->fetch_assoc()) {$rows[] = $r;}
                    if(isset($rows)) echo json_encode($rows);
                    else self::setSuccess("empty");
        }
        */
        /*  SOLUZIONE CON LA QUERRY */
        $prodotti=\Singleton::DB()->query("SELECT prodotti.id as id_prodotto, prodotti.nome as nome_prodotto, categorie.nome as categoria_prodotto, prodotti.descrizione as descrizione_prodotto, prodotti.info as info_prodotto, prodotti.prezzo as prezzo_prodotto, valute.simbolo as simbolo_valuta_prodotto, items_magazzino.id_magazzino as id_magazzino, items_magazzino.quantita as quantita_prodotto FROM prodotti, categorie, items_magazzino, valute WHERE categorie.id=prodotti.id_categoria AND valute.id=prodotti.id_valuta AND items_magazzino.id_prodotto=prodotti.id AND $sql_id_magazzino AND $sql_nome_categoria AND $sql_id_categoria AND $sql_nome_prodotto AND $sql_prezzo_min AND $sql_prezzo_max");
        while($r = $prodotti->fetch_assoc()) {$rows[] = $r;}
                    return $rows;
    }
}
