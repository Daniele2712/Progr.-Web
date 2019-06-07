<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class F_Ordine extends Foundation{
    protected static $table = "ordini";

    public static function findByCode($code) : \Models\F_Ordine{      // ancora da verificare
        $DB = \Singleton::DB();
        $sql = "SELECT id_ordine FROM ordini_non_registrati WHERE code=?";
        $p=$DB->prepare($sql);
        $p->bind_param("s",$code);

        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);


        $id_ord = $p->get_result()->fetch_assoc()['id_ordine'];
        $p->close();
        return self::find($id_ord);
    }


    public static function codeExists($code) : bool{
        $DB = \Singleton::DB();
        $sql = "SELECT id_ordine FROM ordini_non_registrati WHERE code=?";
        $p=$DB->prepare($sql);
        $p->bind_param("s",$code);

        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        if($p->get_result()->num_rows>0){return true;}
        else{return false;}
    }


    public static function findByUserId($userId){       //ritorna array di Model\Ordini

        //!!!!!!!!  PRIMA VERIFICA SE ESISTE VERAMENTE L-UTENTE     !!!!!!!

        $id_dati_anagrafici= F_Utente::find($userId)->getDatiAnagrafici()->getId();

        $DB = \Singleton::DB();
        $sql = "SELECT * FROM ordini WHERE id_dati_anagrafici=?";
        $p=$DB->prepare($sql);
        $p->bind_param("s",$userId);

        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $ris = $p->get_result();
        $ordini=array();
        while($row = $ris->fetch_array(MYSQLI_ASSOC))
        {
            $ordini[]=self::create($row);
        }

        return $ordini;
    }

    public static function save(Model $ordine, array $params = array()){
        F_Pagamento::save($ordine->getPagamento());
        F_Indirizzo::save($ordine->getIndirizzo());
        F_DatiAnagrafici::save($ordine->getDatiAnagrafici());

        //salvo anche il magazzino perchè è cambiato il numero di prodotti disponibili con l'ordine
        F_Magazzino::save($ordine->getMagazzino());

        return parent::save($ordine);
    }

    public static function insert(Model $ordine, array $params = array()): int{
        /*  1) inserire nella tabbella ordini il mio ordine     */
        //tabbella ordini e fatta cosi   id 	id_pagamento 	id_indirizzo 	id_dati_anagrafici 	subtotale 	spese_spedizione 	totale 	id_valuta 	data_ordine 	data_consegna
        $DB = \Singleton::DB();
        //da aggiungere il metodo di pagamento
        $idPag = $ordine->getPagamento()->getId();
        $idInd = $ordine->getIndirizzo()->getId();
        $idDati = $ordine->getDatiAnagrafici()->getId();
        $sub = $ordine->getSubtotale();
        $sped = $ordine->getSpeseSpedizione();
        $tot = $ordine->getTotale();
        $idVal = $ordine->getIdValuta();
        $dataOrd = $ordine->getDataOrdine();
        $strOrd = $dataOrd->format('Y-m-d H:i:s');
        $dataCons = $ordine->getDataConsegna();
        if($dataCons === NULL)
            $strCons = NULL;
        else
            $strCons = $dataCons->format('Y-m-d H:i:s');
        $idMag = $ordine->getMagazzino()->getId();
        $stato = $ordine->getStato();

        $sql = "INSERT INTO ".self::$table." VALUES(NULL, ? , ? , ? , ? , ? , ? , ? , ? , ? , ?, ?);";
        $p = $DB->prepare($sql);
        $p->bind_param("iiidddissis", $idPag, $idInd, $idDati ,$sub ,$sped , $tot, $idVal, $strOrd , $strCons, $idMag, $stato);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->close();

        $idUltimoOrdine=$DB->lastId();

        /*  1) inserire nella tabbella items_ordine i miei item    */
        /*  lla tabbella items_ordine e' fatta cosi             id 	id_ordine 	id_prodotto 	prezzo 	id_valuta 	quantita */

        $items = $ordine->getItems();
        $DB = \Singleton::DB();
        $p = $DB->prepare("INSERT INTO items_ordine VALUES(NULL, ? , ? , ? , ?)");

        foreach($items as $item){
            $idOrd = $idUltimoOrdine;
            $idProd = $item->getProdotto()->getId();
            $pre = $item->getTotale()->getPrezzo();
            $idValut = $ordine->getIdValuta();  //immagino che la valuta che l-utente vuole usare sia quella usata nel ordine, xke quando fai un ordine, scegli anche la valuta...forse..
            $qua = $item->getQuantita();

            $p->bind_param("iidi", $idOrd, $idProd, $pre ,$qua);
            if(!$p->execute())
                throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        }
        $p->close();

        return  $idUltimoOrdine;  // ti rida solo l-ultimo id inserito nella tabbella Ordini (e non items_oridne!)
    }

    public static function create(array $row): Model{
        $indirizzo = F_Indirizzo::find($row['id_indirizzo']);
        $datiAnagrafici = F_DatiAnagrafici::find($row['id_dati_anagrafici']);
        $magazzino = F_Magazzino::find($row["id_magazzino"]);

        $DB = \Singleton::DB();
        $sql = "SELECT * FROM items_ordine WHERE id_ordine=?";
        $p=$DB->prepare($sql);
        $orderId=$row['id'];
        $p->bind_param("s",$orderId);

        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $ris = $p->get_result();
        $items=array();
        while($riga = $ris->fetch_array(MYSQLI_ASSOC)){
            $idProd=$riga['id_prodotto'];
            $prod= F_Prodotto::find($idProd);
            $prezzo=$riga['prezzo'];
            $money=new \Models\M_Money($prezzo, $row['id_valuta']);
            $quant=$riga['quantita'];
            $items[]=new \Models\M_Item($prod, $money, $quant);
        }

        mysqli_free_result($ris);       // non so se e' indispensabile, pero nel dubbio..
        $p->close();

        $subtotale = $row['subtotale'];
        $spese_spedizione = $row['spese_spedizione'];
        $totale = $row['totale'];
        $id_valuta = $row['id_valuta'];
        $data_ordine = new \DateTime($row['data_ordine']);
        $data_consegna = new \DateTime($row['data_consegna']);
        $stato = $row['stato'];

        $ordine = new \Models\M_Ordine($orderId, $items, $indirizzo, $datiAnagrafici, $magazzino, $subtotale, $spese_spedizione, $totale, $id_valuta, $data_ordine, $data_consegna, $stato);    // aggiungere anche gli altri campi , e poi manca la parte del pagamento....
       return $ordine;
    }

    public static function orderDetailsToJson($idOrdine){
        $ordine= F_Ordine::find($idOrdine);
        $arrayOrderDetails['id']=$ordine->getId();
        if($ordine->getPagamento()!==null) $arrayOrderDetails['id_pagamento']=$ordine->getPagamento()->getId();
        else $arrayOrderDetails['id_pagamento']=null;
        $arrayOrderDetails['id_indirizzo']=$ordine->getIndirizzo()->getId();
        $arrayOrderDetails['id_dati_anagrafici']=$ordine->getDatiAnagrafici()->getId();
        $arrayOrderDetails['subtotale']=$ordine->getSubtotale();
        $arrayOrderDetails['spese_spedizione']=$ordine->getSpeseSpedizione();
        $arrayOrderDetails['totale']=$ordine->getTotale();
        $arrayOrderDetails['data_ordine']=$ordine->getDataOrdine()->format("d/m/Y - H:i");
        $arrayOrderDetails['data_consegna']=$ordine->getDataConsegna()->format("d/m/Y - H:i");
        $arrayOrderDetails['stato']=$ordine->getStato();

        return json_encode($arrayOrderDetails);
    }

    public static function itemsOfOrderJson($idOrdine){
        $ordine=F_Ordine::find($idOrdine);
        $items=$ordine->getItems();
        $itemsArray=array();
        foreach($items as $item){
            $row['prodotto']=$item->getProdotto()->getNome();
            $row['info']=$item->getProdotto()->getNome();
            $row['descrizione']=$item->getProdotto()->getNome();
            $row['prezzo']=$item->getTotale()->getPrezzo();
            $row['id_valuta']=$item->getTotale()->getValuta();
            $row['quantita']=$item->getQuantita();
            //poi se mi serviranno altri valori si possono aggiungere con altre $row['quello che mi serve']=...
            $itemsArray[]= $row;
        }
        return json_encode($itemsArray);
    }

    public static function update(Model $ordine, array $params = array()){   // magari lo posso usare x aggiungere un PAGAMENTO algi ordini che non ce l-hnno, xke di default non ce l'hanno

    }

    public static function getOrdiniFiltrati($idMagzzino, $idOrdine, $code){        // !!! ATTENZIONE LA FUNZIONE SHOW DIPENDENTI DOVREBBE VERIFICARE PRIMA SE IN EFFETTI L-UTENTE CHE RICHIEDE DI VEDERE I PRODOTTI HA IL DIRITTO DI FARLO PER EVITARE CHE UN GESTORE VEDA PRODOTTI DI TUTTI I MAGAZZINI
            $rows=array();

            /*  DA MODOIFICARE PER PERMETTERE IL FILTRAGGIO DEGLI ORDINI ATTRAVERSO TUTTE E 3 LE Variabili magazzino, id e code   */

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

    public static function getOrdiniByIdMagazzino($idMagzzino){ // Funziona
            $rows=array();
            /*
            $rows sara fatto in questo modo
             *
             * id_ordine
             * id_tipo_pagamento
             * tipo_pagamento
             * cap_indirizzo_ordine
             * nome_indirizzo_ordine
             * provincia_indirizzo_ordine
             * via_indirizzo_ordine
             * civico_indirizzo_ordine
             * nome_utente_ordine
             * cognome_utente_ordine
             * subtotale_ordine
             * spedizione_ordine
             * totale_ordine
             * simbolo_valuta_ordine
             * data_ordine
             * consegna_ordine
             *
             */
            $conn= \Singleton::DB();
            $stmt = $conn->prepare("SELECT ordini.id as id_ordine, ordini.id_pagamento as id_tipo_pagamento, pagamenti.tipo as tipo_pagamento, comuni.CAP as cap_indirizzo_ordine, comuni.nome as nome_indirizzo_ordine, comuni.provincia as provincia_indirizzo_ordine, indirizzi.via as via_indirizzo_ordine, indirizzi.civico as civico_indirizzo_ordine, dati_anagrafici.nome as nome_utente_ordine, dati_anagrafici.cognome as cognome_utente_ordine, ordini.subtotale as subtotale_ordine, ordini.spese_spedizione as spedizione_ordine, ordini.totale as totale_ordine, valute.simbolo as simbolo_valuta_ordine, ordini.data_ordine as data_ordine, ordini.data_consegna as consegna_ordine FROM ordini,indirizzi,comuni,valute,dati_anagrafici,pagamenti WHERE ordini.id_dati_anagrafici=dati_anagrafici.id AND ordini.id_pagamento=pagamenti.id AND ordini.id_indirizzo=indirizzi.id AND comuni.id=indirizzi.id_comune AND ordini.id_valuta=valute.id AND ordini.id_magazzino=?");
            $stmt->bind_param("i", $idMagzzino);
            $stmt->execute();
            $ordini=$stmt->get_result();
            $stmt->close();
            while($r = $ordini->fetch_assoc()) {$rows[] = $r;}
            return $rows;
    }

}
