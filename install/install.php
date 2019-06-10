<?php
$originalIndex='originalIndex.php';
$configurationFile='../includes/config.inc.php';
$dbFile='progr_web.sql';

$DBname=$_POST['DBname'];
$DBhost=$_POST['DBhost'];
$DBusername=$_POST['DBusername'];
$DBpassword=$_POST['DBpassword'];

if(empty($DBname) OR empty($DBhost) OR empty($DBusername)) {echo "DB name, DB username oppure DB host sono vuoti ";return;}
//connection to the database
try {
  $db = new PDO("mysql:host=$DBhost;", $DBusername, $DBpassword); // tentativo di connessione al dbms (default: mysql)
  $db->beginTransaction(); // inizia la transazione

  $query = 'DROP DATABASE IF EXISTS ' . $DBname . ';
            CREATE DATABASE ' . $DBname . ' ;
            USE ' . $DBname . ';'; // costruisce il database

  $query = $query . file_get_contents($dbFile); // crea la querruy con la creazione del db
  $db->exec($query);
  $db->commit();
  $db=null;
  echo "SUCCESS connectiong to DataBase.</br>";
  } catch (PDOException $e){
        echo "FAILED connectiong to DataBase Invalid credentials.</br>";
        return ;
  }


/*  Aggiornamento del file config   */
$configs="\$config['mysql']['database'] = '$DBname';
\$config['mysql']['host'] = '$DBhost';
\$config['mysql']['user'] = '$DBusername';
\$config['mysql']['password'] = '$DBpassword';";

if(file_put_contents($configurationFile, $configs, FILE_APPEND)) echo "SUCCESS updating Config File.</br>"; /*  Aggiunge al file di configurazione le impostazioni per collegarsi al DB*/
else {echo "FAILED to update config file. Please insert the configuration parameters inside $configurationFile by hand.</br>"; return;}


/*  Ultima cosa che devo fare e' modificare il contenuto di index.php e mettergli il vero contenuto*/
file_put_contents('../index.php',file_get_contents($originalIndex));

/*  Ora cancello la cartella di istallazione perche non serve piu   */
if(!is_dir('../install')) {echo "Cannot find install directory! </br>";}
else{
  echo "Deleting install folder...</br>";
  deleteDirectory('../install');
  if(is_dir('../install')) echo "FAILED deleting install folder, please remove it by hand;</br>";
  else echo "SUCCESS deleting install folder.</br>";
}


/*  e per ultima redirezionare l'utente*/
$serverName=$_SERVER['HTTP_HOST'];
header("Location: $serverName");

/*  Funzione per calcellare la directory  */
function deleteDirectory($dir) {
    if (!file_exists($dir)) {
        return true;
    }

    if (!is_dir($dir)) {
        return unlink($dir);
    }

    foreach (scandir($dir) as $item) {
        if ($item == '.' || $item == '..') {
            continue;
        }

        if (!deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
            return false;
        }

    }

    return rmdir($dir);
}
?>
