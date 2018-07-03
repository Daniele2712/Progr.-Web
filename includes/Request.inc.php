<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Request{
    private $controller;
    private $action;
    private $params = array();
    private $rest = false;
    private $method;

    public function __construct(){
        global $config;
        $this->controller = $config['default']['controller'];
        $this->action = $config['default']['action'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        $pos = strpos($uri,'?');
        $params = explode("/",$pos===FALSE?$uri:substr($uri,0,$pos));
        array_shift($params);

        if(count($params)>0 && $params[0]=="api"){
            $this->rest = true;
            array_shift($params);
        }
        if(count($params)>0 && $params[0]!=="")
            $this->controller = "C".array_shift($params);
        if($this->rest)
            $this->action = strtolower($this->method);
        elseif(count($params)>0 && $params[0]!=="")
            $this->action = array_shift($params);
        $this->params = $params;
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

    public function getInt($name='',$default=NULL,$method='REQUEST'){
        return $this->getParam($name,'int',$default,$method);
    }

    public function getFloat($name='',$default=NULL,$method='REQUEST'){
        return $this->getParam($name,'float',$default,$method);
    }

    public function getString($name='',$default=NULL,$method='REQUEST'){
        return $this->getParam($name,'string',$default,$method);
    }

    public function getJSON($name='',$default=NULL,$method='REQUEST'){
        return $this->getParam($name,'json',$default,$method);
    }

    public function getParam($name='',$filter='All',$default=NULL,$method='REQUEST'){
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
					$default=new Date();
					break;
                case 'json':
                    $default=false;
                    break;
				default:
					$default=NULL;
					break;
			}
		if($name!=''&&strtolower($filter)!="json"){
			switch($method){
				case 'POST':
					if(isset($GLOBALS['_POST'][$name])&&$GLOBALS['_POST'][$name]!='undefined')
						$tmp=$GLOBALS['_POST'][$name];
					else
						return $default;
					break;
				case 'GET':
                    if(is_int($name) && count($this->param) > $name)
                        $tmp = $this->param[$name];
					elseif(isset($GLOBALS['_GET'][$name])&&$GLOBALS['_GET'][$name]!='undefined')
						$tmp=$GLOBALS['_GET'][$name];
					else
						return $default;
					break;
				case 'REQUEST':
                    if(is_int($name) && count($this->param) > $name)
                        $tmp = $this->param[$name];
					else if(isset($GLOBALS['_REQUEST'][$name])&&$GLOBALS['_REQUEST'][$name]!='undefined')
						$tmp=$GLOBALS['_REQUEST'][$name];
					else
						return $default;
					break;
				case 'FILE':
					if(isset($GLOBALS['_FILE'][$name])&&$GLOBALS['_FILE']!='undefined')
						$tmp=$GLOBALS['_FILE'][$name];
					else
						return $default;
					break;
				case 'COOKIE':
					if(isset($GLOBALS['_COOKIE'][$name])&&$GLOBALS['_COOKIE']!='undefined')
						$tmp=$GLOBALS['_COOKIE'][$name];
					else
						return $default;
					break;
				case 'SERVER':
					if(isset($GLOBALS['_SERVER'][$name])&&$GLOBALS['_SERVER']!='undefined')
						$tmp=$GLOBALS['_SERVER'][$name];
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
					return $tmp;
				elseif(empty($tmp))
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
