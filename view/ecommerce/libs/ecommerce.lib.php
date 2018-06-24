<?php

/**
 * guestbook application library
 *
 */
class Ecommerce {

  // database object
  var $pdo = null;
  // smarty template object
  var $tpl = null;
  // error messages
  var $error = null;

  /* set database settings here! */
  // PDO database type
  var $dbtype = 'mysql';
  // PDO database name
  var $dbname = 'progr_web';
  // PDO database host
  var $dbhost = 'localhost';
  // PDO database username
  var $dbuser = 'root';
  // PDO database password
  var $dbpass = 'password';


  /**
  * class constructor
  */
  function __construct() {

    // instantiate the pdo object
      // questo che segue e il collegamento al database!
    try {
      $dsn = "{$this->dbtype}:host={$this->dbhost};dbname={$this->dbname}";
      //il $ dsn avra uesta forma   
      
      //$dsn="mysql:host=localhost;dbname=GUESTBOOK"
      
      $this->pdo =  new PDO($dsn,$this->dbuser,$this->dbpass);
    } catch (PDOException $e) {
      print "Error!: " . $e->getMessage();
      die();
    }	

    // instantiate the template object
    $this->tpl = new Ecommerce_Smarty;
    
    // Quindi sto tizio, dopo che e costruito ha tre variabili!
    //  1) $dsn         serve solo in funzione del this-> pdo, xke pdo e' il collegamento al DataBase
    //  2) $this->pdo   che sarebbe la connessione al database!
    //  3) $this->tpl   che sarebbe smarty(una classe che estende smarty) , che fa tante belle cose
    
   //in seguito infatti verra utilizzato spesso questo $this->tpl.... cioe il smarty engine fara delle cose :D
  }

  function displayMainPage(){
      
      $this->tpl->display('index.tpl');
      
  }
  
  function displaySpesa($arrayDiProdotti = array()){   //cioe gli devi passare un array di prodotti, quelli presi dal db
      $this->tpl->assign('prodotti_for_tpl', $arrayDiProdotti);
      $this->tpl->display('spesa.tpl');
      
  }
  
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
  
  
  function displayForm($formvars = array()) {

    // assign the form vars
    $this->tpl->assign('post',$formvars);
    // assign error message
    $this->tpl->assign('error', $this->error);
    $this->tpl->display('guestbook_form.tpl');

  }

  /**
  * fix up form data if necessary
  *
  * @param array $formvars the form variables
  */
  function mungeFormData(&$formvars) {  // attenzioneee questa trim ti elimina gli spazi solo alla fine e al inizio della stringa!
      

    // trim off excess whitespace
    $formvars['Name'] = trim($formvars['Name']);
    $formvars['Comment'] = trim($formvars['Comment']);

  }

  /**
  * test if form information is valid
  *
  * @param array $formvars the form variables
  */
  function isValidForm($formvars) {

    // reset error message
    $this->error = null;

    // test if "Name" is empty
    if(strlen($formvars['Name']) == 0) {
      $this->error = 'name_empty';
      return false; 
    }

    // test if "Comment" is empty
    if(strlen($formvars['Comment']) == 0) {
      $this->error = 'comment_empty';
      return false; 
    }

    // form passed validation
    return true;
  }

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

  /**
  * display the guestbook
  *
  * @param array $data the guestbook data
  */
  function displayBook($data = array()) {

    $this->tpl->assign('data', $data);
    $this->tpl->display('guestbook.tpl');        

  }
}

?>
