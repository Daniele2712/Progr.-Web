<?php
namespace Views;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

/**
 * classe Request, rappresenta la richiesta del client
 */
class Request{
    /**
     * controller richiesto
     * @var    string
     */
    private $controller;
    /**
     * azione richiesta
     * @var    string
     */
    private $action;
    /**
     * url senza parametri
     * @var    string
     */
    private $base_url;
    /**
     * parametri aggiuntivi della URI
     * @var    array
     */
    private $params = array();
    /**
     * flag: TRUE se è una richiesta Restfull, FALSE altrimenti
     * @var    bool
     */
    private $rest = FALSE;
    /**
     * flag: TRUE se il body della richiesta (POST) è vuoto
     * @var    bool
     */
    private $empty = TRUE;
    /**
     * metodo della richiesta
     * @var    string
     */
    private $superGlobal;
    /**
     * variabili globali della richiesta
     * @var    array
     */
    private $globals = array();
    /**
     * analizza la richiesta e setta i parametri
     */
    public function __construct(){

        global $config;

        $this->controller = "Controllers\\".$config['default']['controller'];
        $this->action = $config['default']['action'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        $pos = strpos($uri,'?');                                        // posizione alla quale iniziano i parametri, percio' il ?
        $params = explode("/",$pos===FALSE?$uri:substr($uri,0,$pos));
        array_shift($params);

        if(count($params)>0 && $params[0]=="api"){
            $this->rest = true;
            $this->base_url = array_shift($params).'/';   //cosi mi sbarazzo del pezzo in cima "api"
            $c = array_shift($params);
            $this->base_url .= $c.'/';
            $this->controller = "Controllers\\Api\\C_$c";
            $this->action = "default";
        }elseif(count($params)>0 && $params[0]!==""){
            $c = array_shift($params);
            $this->base_url = "/$c/";
            $this->controller = "Controllers\\C_$c";
            $this->action = "default";
        }
        if($this->rest)
            $this->action = strtolower($this->method);
        elseif(count($params)>0 && $params[0]!==""){
            $this->action = array_shift($params);
            $this->base_url .= $this->action;
        }
        $this->params = $params;

        $array = array('_POST', '_GET', '_REQUEST', '_SERVER', '_ENV', '_FILES');
        $this->empty = count($_POST) > 0;
        foreach ($GLOBALS as $key=>$value)
            if(array_search($key,$array,TRUE)!==FALSE)
                $this->globals[$key] = $value;
        $this->globals["_COOKIE"] = $GLOBALS["_COOKIE"];  //Non posso cancellare i cookie altrimenti le sessioni non funzionano
        foreach ($GLOBALS as $key=>$value)
            if(array_search($key,$array,TRUE)!==FALSE)
                unset($GLOBALS[$key]);                    //Gli altri li cancello, così non ci si può accedere direttamente

        //echo "CONTROLLER: $this->controller   ACTION: $this->action   METHOD: $this->method ";
    }

    public function getOtherParams(){
        return $this->params;
    }

    public function getMethod():string{
        return $this->method;
    }

    public function getController():string{
        return $this->controller;
    }

    public function getAction():string{
        return $this->action;
    }

    public function isRest():bool{
        return $this->rest;
    }

    public function isEmpty():bool{
        return $this->empty;
    }

    /*  Funzioni che mi servono per uploadare prodotti  */
    public function learn(){        //TODO: brutto, trova un modo per evitarlo
      return $this->globals;
    }

                                        //TODO: ste cose non sono al posto giusto falle fare a M_Immagine
    public function hasFavoriteImageUploaded(){ /*  verifica se e stata uploadata un immagine come immagine favorita*/
      if(!empty($this->globals['_FILES']['favoriteImage']['name'])) return true;
      else return false;
    }
    public function getOrderedFavoriteImage(){  /*  restituisce un array con i 4 campi che descrivono l-imamgine*/
        return array('name'=>$this->globals['_FILES']['favoriteImage']['name'],'type'=>$this->globals['_FILES']['favoriteImage']['type'],'tmp_name'=> $this->globals['_FILES']['favoriteImage']['tmp_name'],'size'=>$this->globals['_FILES']['favoriteImage']['size']);
    }

    public function hasOtherImagesUploaded(){ /*  verifica se e stata uploadata ALMENO un immagine nella categoria Other(cioe non favorita)*/
      if(!empty($this->globals['_FILES']['otherImages']['name'][0])) return true;
      else return false;
    }
    public function getOrderedOtherImages(){ /*  restituisce un array di array. ogni array figlio contiene 4 campi che descrivono un immagine other. La dimension del araru padre e; il numero di foto uploadata come other */
      $orderedImages= array();
      for($i=0; $i<sizeof($this->globals['_FILES']['otherImages']['name']); $i++)
      {
        $orderedImages[]=array('name'=>$this->globals['_FILES']['otherImages']['name'][$i],'type'=>$this->globals['_FILES']['otherImages']['type'][$i],'tmp_name'=> $this->globals['_FILES']['otherImages']['tmp_name'][$i],'size'=>$this->globals['_FILES']['otherImages']['size'][$i] );
      }
      return $orderedImages;
    }



  /*  FINE Funzioni che mi servono per uploadare prodotti  */



    public function getImgLocation(){
        return $this->globals['_FILES']['image']['tmp_name'];
    }

     public function getImgSize(){
        return $this->globals['_FILES']['image']['size'];
    }

    public function getImgType(){
        return $this->globals['_FILES']['image']['type'];
    }

    public function getImgName(){
        return $this->globals['_FILES']['image']['name'];
    }

    public function getBaseURL(){
        return $this->base_url;
    }

    public function getServerName(){
        return $this->globals['_SERVER']['SERVER_NAME'];
    }
    /**
     * restituisce un parametro di tipo intero
     *
     * @param     string|int    $name           il nome o la posizione del parametro
     * @param     int|null      $default        valore di default del parametro
     * @param     string        $superGlobal    array superglobale in cui cercare il parametro
     * @return    int                           il parametro richiesto
     */
    public function getInt($name='',int $default=NULL,string $superGlobal='GET'): int{
        return $this->getParam($name,'int',$default,$superGlobal);
    }

    /**
     * restituisce un parametro di tipo booleano
     *
     * @param     string|int    $name           il nome o la posizione del parametro
     * @param     bool|null      $default        valore di default del parametro
     * @param     string        $superGlobal    array superglobale in cui cercare il parametro
     * @return    int                           il parametro richiesto
     */
    public function getBool($name='',bool $default=NULL,string $superGlobal='GET'): int{
        return $this->getParam($name,'bool',$default,$superGlobal);
    }

    /**
     * restituisce un parametro di tipo float
     *
     * @param     string|int    $name           il nome o la posizione del parametro
     * @param     float|null    $default        valore di default del parametro
     * @param     string        $superGlobal    array superglobale in cui cercare il parametro
     * @return    float                         il parametro richiesto
     */
    public function getFloat($name='',float $default=NULL,string $superGlobal='GET'): float{
        return $this->getParam($name,'float',$default,$superGlobal);
    }

    /**
     * restituisce un parametro di tipo string
     *
     * @param     string|int    $name           il nome o la posizione del parametro
     * @param     string|null   $default        valore di default del parametro
     * @param     string        $superGlobal    array superglobale in cui cercare il parametro
     * @return    string                        il parametro richiesto
     */
    public function getString($name='',string $default=NULL,string $superGlobal='GET'): string{
        return $this->getParam($name,'string',$default,$superGlobal);
    }

    /**
     * restituisce un parametro di tipo array
     *
     * @param     string|int    $name           il nome del parametro
     * @param     string|null   $default        valore di default del parametro
     * @param     string        $superGlobal    array superglobale in cui cercare il parametro
     * @return    string                        il parametro richiesto
     */
    public function getArray($name='',array $default=NULL,string $superGlobal='GET'): array{
        return $this->getParam($name,'array',$default,$superGlobal);
    }

    /**
     * restituisce un parametro di tipo array o object da un parametro JSON
     *
     * @param     string|int    $name           il nome o la posizione del parametro
     * @param     object|array  $default        valore di default del parametro
     * @param     string        $superGlobal    array superglobale in cui cercare il parametro
     * @return    object|array                  il parametro richiesto
     */
    public function getJSON($name='',$default=NULL,string $superGlobal='GET'){
        return $this->getParam($name,'json',$default,$superGlobal);
    }

    /**
     * metodo che restituisce il token CSRF preso dai cookie del client
     *
     * @return    string    token CSRF
     */
    public function getCSRF():string{
        return $this->getParam("CSRF", "string", "", "COOKIE");
    }

    /**
     * restituisce un parametro eventualmente effettuando un filtro sul tipo
     *
     * @param     string|int    $name           il nome o la posizione del parametro
     * @param     string        $filter         il tipo di filtro da applicare
     * @param     mixed         $default        valore di default del parametro
     * @param     string        $superGlobal    array superglobale in cui cercare il parametro
     * @return    mixed                         il parametro richiesto
     */
    public function getParam($name='',string $filter='All',$default=NULL,string $superGlobal='GET'){
        $filter=strtolower($filter);
		if($default==NULL)
			switch($filter){
				case 'all':
					$default=NULL;
					break;
				case 'isset':
					$default=false;
					break;
				case 'int':
				case 'checkbox':
					$default=0;
					break;
				case 'bool':
					$default=False;
					break;
				case 'float':
					$default=0.0;
					break;
				case 'string':
					$default='';
					break;
				case 'date':
					$default=new \DateTime();
					break;
                case 'array':
                    $default=array();
                    break;
                case 'json':
                    $default=false;
                    break;
				default:
					$default=NULL;
					break;
			}
		if($name!==''&&strtolower($filter)!="json"){
			switch($superGlobal){
				case 'POST':
					if(isset($this->globals['_POST'][$name])&&$this->globals['_POST'][$name]!='undefined')
						$tmp=$this->globals['_POST'][$name];
					else
						return $default;
					break;
				case 'GET':
                    if(is_int($name) && count($this->params) > $name)
                        $tmp = $this->params[$name];
					elseif(isset($this->globals['_GET'][$name])&&$this->globals['_GET'][$name]!='undefined')
						$tmp=$this->globals['_GET'][$name];
					else
						return $default;
					break;
				case 'REQUEST':
                    if(is_int($name) && count($this->params) > $name)
                        $tmp = $this->params[$name];
					elseif(isset($this->globals['_REQUEST'][$name])&&$this->globals['_REQUEST'][$name]!='undefined')
						$tmp=$this->globals['_REQUEST'][$name];
					else
						return $default;
					break;
				case 'FILE':
					if(isset($this->globals['_FILE'][$name])&&$this->globals['_FILE']!='undefined')
						$tmp=$this->globals['_FILE'][$name];
					else
						return $default;
					break;
				case 'COOKIE':
					if(isset($this->globals['_COOKIE'][$name])&&$this->globals['_COOKIE']!='undefined')
						$tmp=$this->globals['_COOKIE'][$name];
					else
						return $default;
					break;
				case 'SERVER':
					if(isset($this->globals['_SERVER'][$name])&&$this->globals['_SERVER']!='undefined')
						$tmp=$this->globals['_SERVER'][$name];
					else
						return $default;
					break;
				default:
					return $default;
					break;
			}
		}elseif(strtolower($filter)!="json")
			return $default;
		switch($filter){
			case 'all':
				return $tmp;
				break;
			case 'isset':
				return true;
				break;
			case 'checkbox':
				if($tmp=="on")
					return 1;
				else
					return $default;
				break;
			case 'int':
				if(is_int($tmp))
					return $tmp;
				elseif(is_numeric($tmp)&&$tmp==strval((int)$tmp))
					return (int)($tmp);
				else
					return $default;
				break;
			case 'bool':
				if(is_bool($tmp))
					return $tmp;
				elseif(strtolower(strval($tmp))=='true'||(int)$tmp==1)
					return true;
				elseif(strtolower(strval($tmp))=='false'||(int)$tmp==0)
					return false;
				else
					return $default;
				break;
			case 'float':
				$tmp=str_replace(",",".",$tmp);
				if(is_float($tmp))
					return $tmp;
				elseif(is_numeric($tmp)||is_numeric(floatval($tmp)))
					return floatval($tmp);
				else
					return $default;
				break;
			case 'date':
				/*if(preg_match("/^[0-9]*[\\s].[A-Za-z]*[\\s].[0-9]*$/",$tmp))
					return DataMeseInTestoConverter(($tmp));
				if(preg_match("/^[0-9]*[\\s\\-\\\].[0-9]*[\\s\\-\\\].[0-9]*$/",$tmp))
					return DataDaItaToDataBase($tmp);
				else*/
					return $default;
				break;
			case 'string':
				if(is_string($tmp))
					return htmlentities($tmp);
				elseif(empty($tmp))
					return $default;
				break;
            case 'array':
                if(is_array($tmp))
                    return $tmp;
                else
                    return $default;
                break;
            case 'json':
				$tmp=file_get_contents("php://input");
				if(is_string($tmp)){
					$ret=json_decode($tmp,true);
					if(json_last_error())
						return $default;
					elseif(!is_object($ret)&&!is_array($ret))
						return $default;
					else
						return $ret;
				}else
					return $default;
                break;
            default:
				return $default;
				break;
		}
	}
}
