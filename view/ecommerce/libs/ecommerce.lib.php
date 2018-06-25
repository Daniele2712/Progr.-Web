<?php

/**
 * guestbook application library
 *
 */
class Ecommerce {

    //ANDREI: come ti dicevo nel controller questa la devi far fare all'entity

  function getArrayDiProdotti($filtro=NULL) {
      //devo implementare il fatto di prendere i prodotti solo del negozio piu vicino
      // oppure,, meglio, togliamo sta feature, e mettiamo che l indirizzo serve solo
      // x sapere se sta nel range delle consegne e sapere dove consegnare le cose
      try {
          //DEVO USARE IL FILTRO NELLA QUERRY X AVERE GLI ITEM NEL ORDINE CHE VOGLIO, E ANCHE CON LE CONDIZIONI CHE VOGLIO
      foreach($this->pdo->query("select * from prodotti") as $row)
      $rows[] = $row;
    } catch (PDOException $e) {
      print "Erroraaaaciiiooooo!: " . $e->getMessage();
      return "false";
    }
    return $rows;
  }




  /*  DA QUI IN POI SONO SOLO FUNZIONI CHE NON MI SERVONO, E CHE DEVO ADATTARE PER FARLE UTILI */
  //ANDREI: queste due finiranno in delle viste

  function displayForm($formvars = array()) {

    // assign the form vars
    $this->tpl->assign('post',$formvars);
    // assign error message
    $this->tpl->assign('error', $this->error);
    $this->tpl->display('guestbook_form.tpl');

  }

  /**
  * display the guestbook
  *
  * @param array $data the guestbook data
  */
  function displayBook($data = array()) {

    $this->tpl->assign('data', $data);
    $this->tpl->display('guestbook.tpl');

  }

//ANDREI: tutta sta roba la devi far fare alle entity

  /**
  * add a new guestbook entry
  *
  * @param array $formvars the form variables
  */
   function addEntry($formvars) {
    try {
      $rh = $this->pdo->prepare("insert into GUESTBOOK values(0,?,NOW(),?)");
      $rh->execute(array($formvars['Name'],$formvars['Comment']));
    } catch (PDOException $e) {
      print "Error!: " . $e->getMessage();
      return false;
    }
    return true;
  }

  /**
  * get the guestbook entries
  */
  function getEntries() {
    try {
      foreach($this->pdo->query(
        "select * from GUESTBOOK order by EntryDate DESC") as $row)
      $rows[] = $row;
    } catch (PDOException $e) {
      print "Error!: " . $e->getMessage();
      return false;
    }
    return $rows;
  }
}

?>
