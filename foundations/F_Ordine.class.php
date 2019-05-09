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

    public static function save(Model $ordine){
        F_Pagamento::save($ordine->getPagamento());
        F_Indirizzo::save($ordine->getIndirizzo());
        F_DatiAnagrafici::save($ordine->getDatiAnagrafici());

        //salvo anche il magazzino perchè è cambiato il numero di prodotti disponibili con l'ordine
        F_Magazzino::save($ordine->getMagazzino());

        return parent::save($ordine);
    }

    public static function insert(Model $ordine): int{
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

    public static function update(Model $ordine){   // magari lo posso usare x aggiungere un PAGAMENTO algi ordini che non ce l-hnno, xke di default non ce l'hanno

    }
}
