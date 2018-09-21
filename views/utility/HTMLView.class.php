<?php
namespace Views;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

/**
 * classe astratta delle Views HTML
 */
abstract class HTMLView implements View{    /* la view ha solo la funzione render() */
    /**
     * riferimento all'istanza di Smarty
     * @var    Smarty
     */
    protected $smarty;
    /**
     * nome del layout da usare
     * @var    string
     */
    protected $layout = "default";
    /**
     * contenuto da mostrare nel layout
     * @var    string
     */
    protected $content = "empty";

    /**
     * risorse da aggiungere nell'head HTML, come script javascript e file css
     * @var    array
     */
    private $resources = array("js"=>array(),"css"=>array());

    /**
     * acquisisce un riferimento all'istanza di Smarty
     */
    public function __construct(){
        $this->smarty = \Singleton::Smarty();
    }

    /**
     * invia in output la pagina HTML
     */
    public function render(){
        $this->HTMLRender();
        $settings = \Singleton::Settings();
        $session = \Singleton::Session();
        if($session->isLogged())
            $this->setUser($session->getUser());
        else{
            $this->smarty->assign('logged', 'false');
            $this->smarty->assign('templateLoginOrProfileIncludes', 'login/login.tpl');
            $this->addCSS("login/css/login.css");
            $this->addJS("login/js/login.js");
        }
        $this->smarty->assign("siteTitle",$settings->getSiteName());
        global $config;
        $this->smarty->assign("homeLink","/".$config['default']['controller']."/".$config['default']['action']);
        $this->smarty->assign("templateContentIncludes",$this->content.".tpl");

        $resources_str = "";
        foreach($this->resources["css"] as $file)
            $resources_str .= "<link rel='stylesheet' type='text/css' href='/templates/contents/$file'/>";
        foreach($this->resources["js"] as $file)
            $resources_str .= "<script type='text/javascript' src='/templates/contents/$file'></script>";
        $this->smarty->assign("templateHeadIncludes", $resources_str);
        $this->smarty->display($this->layout.".tpl");
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
        switch(get_class($user)){ // ricordo che  $user= \Singleton::Session()->getUser()
            case "Models\UtenteRegistrato":        // non so se serve aggiungere anche  || is_subclass_of($user,"\Models\UtenteRegistrato")
                $this->smarty->assign('logged', 'UtenteRegistrato');
                $this->smarty->assign('templateLoginOrProfileIncludes', 'profile/profile.tpl');
                $this->addCSS("profile/css/profile.css");
                $this->addJS("profile/js/profile.js");
                $this->smarty->assign('username', $user->getUsername());
                break;
            case "Models\Gestore":
                $this->smarty->assign('logged', 'Gestore');
                $this->smarty->assign('templateLoginOrProfileIncludes', 'profile/profile.tpl');
                $this->addCSS("profile/css/profile.css");
                $this->addJS("profile/js/profile.js");
                $this->smarty->assign('username', $user->getUsername());
                break;
        }
    }

    public function setCSRF(string $token){
        setcookie("CSRF", $token, 0, "/", "", FALSE, TRUE);
    }

    /**
     * metodo per effettuare modifiche prima del render effettivo
     */
    public function HTMLRender(){}
}
