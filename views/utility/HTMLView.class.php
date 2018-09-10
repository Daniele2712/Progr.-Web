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
     * modello Utente da settare se loggato
     *
     * @var    \Models\Utente
     */
    protected $user = FALSE;

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

        if(!$this->user){
            $this->smarty->assign('logged', 'false');
            $this->smarty->assign('templateLoginOrProfileIncludes', 'login/login.tpl');
            $this->addCSS("login/css/login.css");
            $this->addJS("login/js/login.js");
        }

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
        $this->user = $user;
        if(is_subclass_of($user,"\Models\UtenteRegistrato")){
            $this->smarty->assign('logged', 'utente');
            $this->smarty->assign('templateLoginOrProfileIncludes', 'profile/profile.tpl');
            $this->addCSS("profile/css/profile.css");
            $this->addJS("profile/js/profile.js");
        }
    }

    /**
     * metodo per effettuare modifiche prima del render effettivo
     */
    public function HTMLRender(){}
}
