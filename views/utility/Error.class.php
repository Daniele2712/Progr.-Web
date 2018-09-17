<?php
namespace Views;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

/**
 * View che mostra gli errori
 */
class Error implements View{
    /**
     * flag: TRUE se è una risposta Restfull, FALSE altrimenti
     * @var    bool
     */
    private $rest = false;
    /**
     * numero e messaggio d'errore
     * @var    array
     */
    private $message = array("errorn"=>0, "error"=>"");
    /**
     * lista di messaggi d'errore comuni
     * @var    array
     */
    private $commonErrors = array(
        404 => "Resource Not Found",
        405 => "Method Not Allowed"
    );

    /**
     * risorse da aggiungere nell'head HTML, come script javascript e file css
     * @var    array
     */
    private $resources = array("js"=>array(),"css"=>array());

    /**
     * modello Utente da settare se loggato
     *
     * @var    \Models\Utente
     */
    protected $user = FALSE;

    public function isRest(bool $rest){
        $this->rest = $rest;
    }

    /**
     * metodo per mostrare un errore in output
     *
     * @param     int           $n        numero dell'errore
     * @param     string|null   $error    messaggio d'errore
     */
    public function error(int $n, string $error = NULL){
        $this->message["errorn"] = $n;
        if($error === null && array_key_exists($n, $this->commonErrors))
            $this->message["error"] = $this->commonErrors[$n];
        elseif($error != null)
            $this->message["error"] = $error;
        $this->render();
    }

    /**
     * metodo per inviare in output il messaggio d'errore sia per richieste Restfull che in HTML
     */
    public function render(){
        header('HTTP/1.1 '.$this->message["errorn"].' '.preg_replace("/[\n\r]/","",$this->message["error"]));
        if($this->rest){
            echo json_encode($this->message);
        }else{
            $smarty = \Singleton::Smarty();
            $this->addCSS("error/css/error.css");
            if(!$this->user){
                $smarty->assign('logged', 'false');
                $smarty->assign('templateLoginOrProfileIncludes', 'login/login.tpl');
                $this->addCSS("login/css/login.css");
                $this->addJS("login/js/login.js");
            }


            $resources_str = "";
            foreach($this->resources["css"] as $file)
                $resources_str .= "<link rel='stylesheet' type='text/css' href='/templates/contents/$file'/>";
            foreach($this->resources["js"] as $file)
                $resources_str .= "<script type='text/javascript' src='/templates/contents/$file'></script>";
            $smarty->assign("templateHeadIncludes", $resources_str);
            $smarty->assign("templateContentIncludes","error/message.tpl");
            $smarty->assign("message",$this->message);
            try{
                $smarty->assign("siteTitle",\Models\Settings::getSiteName());
            }catch(\Exception $e){}
            $smarty->display("layout.tpl");
        }
    }

    /**
     * metodo per aggiungere un file javascript nell'head HTML
     *
     * @param    string    $filename    percorso al file, meglio se assoluto
     */
    public function addJS(string $filename){
        if(array_search($filename, $this->resources["js"]) == FALSE)
            $this->resources["js"][] = $filename;
    }

    /**
     * metodo per aggiungere un file css nell'head HTML
     *
     * @param    string    $filename    percorso al file, meglio se assoluto
     */
    public function addCSS(string $filename){
        if(array_search($filename, $this->resources["css"]) == FALSE)
            $this->resources["css"][] = $filename;
    }

    /**
     * metodo per settare l'utente
     *
     * @param    \Models\Utente    $user    modello dell'utente
     */
    public function setUser(\Models\Utente $user){
        $this->user = $user;
        $smarty = \Singleton::Smarty();
        switch(get_class($user)){ // ricordo che  $user= \Singleton::Session()->getUser()
            case "Models\UtenteRegistrato":        // non so se serve aggiungere anche  || is_subclass_of($user,"\Models\UtenteRegistrato")
                $smarty->assign('logged', 'UtenteRegistrato');
                $smarty->assign('templateLoginOrProfileIncludes', 'profile/profile.tpl');
                $this->addCSS("profile/css/profile.css");
                $this->addJS("profile/js/profile.js");
                $smarty->assign('username', $user->getUsername());
                break;
            case "Models\Dipendente":
                $smarty->assign('logged', 'Gestore');
                $smarty->assign('templateLoginOrProfileIncludes', 'profile/profile.tpl');
                $this->addCSS("profile/css/profile.css");
                $this->addJS("profile/js/profile.js");
                $smarty->assign('username', $user->getUsername());
                break;
        }
    }

}
