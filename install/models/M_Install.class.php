<?php
namespace Install\Models;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}
/* TODO: qui ricordati di controllare se esiste già il file includes/config.inc.php per ritornare un errore di installazione già avvenuta
    poi carichi le variabili e controlli se si colega al db, se carica il dump del db e per creare il primo utente
    se vuoi puoi usare anche ajax per controllare che le credenziali di accesso al db siano corrette prima di inviare tutto il form
*/

class M_Install extends Model{
    //Attributi

	//Costruttori
	public function __construct(int $id){
		$this->id = $id;
	}
}
