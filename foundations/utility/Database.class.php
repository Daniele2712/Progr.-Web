<?php
namespace Foundations;
use \mysqli as mysqli;
use \mysqli_result as mysqli_result;
use \mysqli_stmt as mysqli_stmt;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

/**
 * classe per la gestione del database
 */
class Database{
    /**
     * link al database
     *
     * @var    mysqli
     */
	private $connection;

    /**
     * inizializza la connessione al DBMS utilizzando i parametri del file di configurazione
     */
    public function __construct() {
        global $config;
        $this->connect( $config['mysql']['host'],
                        $config['mysql']['user'],
                        $config['mysql']['password'],
                        $config['mysql']['database'] );
    }

    /**
     * funzione che instaura la connessione al DBMS
     *
     * @param     string    $host        l'indirizzo del database server
     * @param     string    $user        l'username da usare per connetersi al DBMS
     * @param     string    $password    la password da usare per connetersi al DBMS
     * @param     string    $database    il nome del DB da usare
     * @throws    SQLException           in caso si verificasse un errore di connessione al DBMS
     * @return    mysqli                 oggetto che rappresenta la connessione al DBMS
     */
    private function connect(string $host, string $user, string $password, string $database){
        $this->connection = new mysqli($host,$user,$password,$database);
        if($this->connection->connect_errno)
            throw new \SQLException("Error Connecting", $this->connection->connect_errno, $this->connection->connect_error);
    }

    /**
     * funzione per chiudere la connessione al DBMS
     */
    public function close(){
        $this->connection->close();
    }

    /**
     * funzione che esegue una query
     *
     * @param     string    $query    la query da eseguire
     * @throws    SQLException        se non si è già connessi al DBMS
     * @throws    SQLException        se l'esecuzione della query fallisce
     * @return    mysqli_result       oggetto contenente il risultato della query
     */
    public function query(string $query): mysqli_result{
        if(!$this->connection)
            throw new \SQLException("Error Not Connected", "", "", 1);
        $r = $this->connection->query($query);
        if($r === FALSE)
            throw new \SQLException("Error Executing Query", $query, $this->error(), 4);
        return $r;
    }

    /**
     * funzione che restituisce l'ultimo id autogenerato
     *
     * @throws    SQLException  se non si è già connessi al DBMS
     * @return    int           id autogenerato
     */
    public function lastId(): int{
        if(!$this->connection)
            throw new \SQLException("Error Not Connected", "", "", 1);
        return $this->connection->insert_id;
    }

    /**
     * funzione che genera un prepared statement
     *
     * @param     string    $query    lo statement da preparare
     * @throws    SQLException        se non si è già connessi al DBMS
     * @throws    SQLException        se non si riesce a generare lo statement
     * @return    mysqli_stmt         il prepared statement generato
     */
    public function prepare(string $query): mysqli_stmt{
        if(!$this->connection)
            throw new \SQLException("Error Not Connected", "", "", 1);
        $r = $this->connection->prepare($query);
        if(!$r)
            throw new \SQLException("Error Prepared Statement", $query, $this->error(), 2);
        return $r;
    }

    /**
     * funzione che inizia una transazione
     * @throws    SQLException      se non si è già connessi al DBMS
     * @throws    SQLException      se non si riesce a iniziare una transazione
     */
    public function begin_transaction(){
        if(!$this->connection)
            throw new \SQLException("Error Not Connected", "", "", 1);
        if(!$this->connection->begin_transaction())
            throw new \SQLException("Error Begin Transaction", "", $this->error(), 5);
    }

    /**
     * funzione che salva le modifiche della transazione corrente sul DB
     *
     * @throws    SQLException      se non si è già connessi al DBMS
     * @throws    SQLException      se non si riesce ad eseguire il commit
     */
    public function commit(){
        if(!$this->connection)
            throw new \SQLException("Error Not Connected", "", "", 1);
        if(!$this->connection->commit())
            throw new \SQLException("Error Commit", "", $this->error(), 6);
    }

    /**
     * funzione che cancella le modifiche effettuate nella transazione corrente sul DB
     *
     * @throws    SQLException      se non si è già connessi al DBMS
     * @throws    SQLException      se non si riesce ad eseguire il rollback
     */
    public function rollback(){
        if(!$this->connection)
            throw new \SQLException("Error Not Connected", "", "", 1);
        if(!$this->connection->rollback())
            throw new \SQLException("Error Rollback", "", $this->error(), 7);
    }

    /**
     * funzione che restituisce la stringa dell'ultimo errore
     *
     * @throws    SQLException      se non si è già connessi al DBMS
     * @return    string            l'ultimo errore
     */
    public function error(): string{
        if(!$this->connection)
            throw new \SQLException("Error Not Connected", "", "", 1);
        return $this->connection->error;
    }
}
