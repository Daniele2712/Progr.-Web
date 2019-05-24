<?php
namespace Views;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

/**
 * View che stampa dei dati in JSON
 */
class JSONView implements View{

    /**
     * variabile contenente i dati da stampare
     *
     * @var    mixed
     */
    protected $data;
    protected $error=NULL;      //forse non serve, ho visto che Mattia usa data['r']..magari a data['r'] posso associare un data['msg'] che dice quale  e il problema

    /**
     * costruttore che setta la variabile data con i dati passati, se presenti
     *
     * @param    mixed    $data    dati in input
     */
    public function __construct($data = NULL){
        if($data !== NULL)
            $this->data = $data;
    }

    /**
     * metodo per stampare i dati con codifica JSON
     */
    
    
    public function render(){
            echo json_encode($this->data);
    }
    
    public function setError($error,$other='NULL'){     //devo vedere ancora come fare sta cosa degli errore. Mi piacerebbe far gestire gli errori a questa view...
        switch($error){
    case 'fill_fields':
        http_response_code(400);
        echo '{
            "message":"You must fill all fields",
            "tip":"For help use the OPTIONS request"
            }';

    case 'expected_index':
        http_response_code(400);
        echo '{
            "message":"Expected index number after .../id/",
            "tip":"For help use the OPTIONS request"
            }';
        break;


    case 'expected_categoria':
        http_response_code(400);
        echo '{
            "message":"Expected categoria name after .../categoria/",
            "tip":"For help use the OPTIONS request"
            }';
        break;

    case 'no_parameters_after_indirizzi':
        http_response_code(400);
        echo '{
            "message":"NO parameters were expected. The URL must end in .../indirizzi",
            "tip":"For help use the OPTIONS request"
            }';
        break;

    case 'no_parameters_after_categorie':
        http_response_code(400);
        echo '{
            "message":"NO parameters were expected. The URL must end in .../categorie",
            "tip":"For help use the OPTIONS request"
            }';
        break;

    case 'wrong_url':
        http_response_code(400);
        echo '{
            "message":"The URL inserted is in the wrong format",
            "tip":"For help use the OPTIONS request"
            }';
        break;

    case 'delete_more_params':
        http_response_code(400);
        echo '{
            "message":"Not enought parameters. Expected 2 parameters",
            "tip":"For help use the OPTIONS request"
            }';
        break;

    case 'delete_less_params':
        http_response_code(400);
        echo '{
            "message":"Too many parameters. Expected only 2 parameters",
            "tip":"For help use the OPTIONS request"
            }';
        break;

    case 'is_inside_basket':
        http_response_code(400);
        echo '{
            "message":"Cannot delete product with id '.$other.' becaust it is inside a basket",
            "tip":"For help use the OPTIONS request"
            }';
        break;

    case 'prodotto_not_exists':
        http_response_code(400);
        echo '{
            "message":"Product with id '.$other.' does not exist",
            "tip":"For help use the OPTIONS request"
            }';
        break;

    case 'quantita_prodotto_errata':
        http_response_code(400);
        echo '{
            "message":"The quantity of product with id'.$other.' is invalid (negative, zero, or we don-t have enought products in the store).",
            "tip":"For help use the OPTIONS request"
            }';
        break;

    case 'indirizzo_not_exists':
        http_response_code(400);
        echo '{
            "message":"Indirizzo with id '.$other.' does not exist",
            "tip":"For help use the OPTIONS request"
            }';
        break;

    case 'magazzino_not_empty':
        http_response_code(400);
        echo '{
            "message":"Magazzino '.$other.'. is not empty. You can delte a magazzino only if it-s empty",
            "tip":"For help use the OPTIONS request"
            }';
        break;

    case 'magazzino_not_exists':
        http_response_code(400);
        echo '{
            "message":"Magazzino with id '.$other.' does not exist",
            "tip":"For help use the OPTIONS request"
            }';
        break;

    case 'categoria_not_exists':
        http_response_code(400);
        echo '{
            "message":"Categoria '.$other.' does not exist",
            "tip":"For help use the OPTIONS request"
            }';
        break;

    case 'id_categoria_not_exists':
        http_response_code(400);
        echo '{
            "message":"Categoria with id '.$other.' does not exist",
            "tip":"For help use the OPTIONS request"
            }';
        break;

    case 'only_one_parameter':
        http_response_code(400);
        echo '{
            "message":"Expected only 1 parameter",
            "tip":"For help use the OPTIONS request"
            }';
        break;

    case 'immage':
        http_response_code(500);
        echo '{
            "message":"ERROR deleting immage associated with product '.$other.'. Aborted the deletion of item with id '.$other.'",
            "tip":"For help use the OPTIONS request"
            }';
        break;

    case 'prod_but_immage_cancelled':
        http_response_code(500);
        echo '{
            "message":"ERROR deleting product with id '.$other.'" but his immage from table `immagini` was already deleted",
            "tip":"For help use the OPTIONS request"
            }';
        break;

    case 'error_deleting_indirizzo':
        http_response_code(500);
        echo '{
            "message":"ERROR deleting indirizzo with id '.$other.'",
            "tip":"For help use the OPTIONS request"
            }';
        break;

    case 'error_deleting_magazzino':
        http_response_code(500);
        echo '{
            "message":"ERROR deleting magazzino with id '.$other.'",
            "tip":"For help use the OPTIONS request"
            }';
        break;

    case 'error_deleting_categoria':
        http_response_code(500);
        echo '{
            "message":"ERROR deleting categoria with id '.$other.'",
            "tip":"For help use the OPTIONS request"
            }';
        break;

    case 'sql':
        http_response_code(500);
        echo '{
            "message":"ERROR (sql)",
            "tip":"For help use the OPTIONS request"
            }';
        break;

        case 'gestore_inesistente':
        http_response_code(400);
        echo '{
            "message":"Id of gestore does not exist.",
            "tip":"For help use the OPTIONS request"
            }';
        break;

        case 'indirizzo_inesistente':
        http_response_code(400);
        echo '{
            "message":"Id of indirizzo does not exist.",
            "tip":"For help use the OPTIONS request"
            }';
        break;

    case 'categoria_esistente':
        http_response_code(400);
        echo '{
            "message":"This category already exists.",
            "tip":"For help use the OPTIONS request"
            }';
        break;
    case 'is_not_float':
        http_response_code(400);
        echo '{
            "message":"Expected a parameter to be float, insted recived '.$other.'",
            "tip":"For help use the OPTIONS request"
            }';
        break;
    case 'is_not_valut':
        http_response_code(400);
        echo '{
            "message":"Expected a parameter to be float, insted recived '.$other.'",
            "tip":"For help use the OPTIONS request"
            }';
        break;

    case 'is_not_int':
        http_response_code(400);
        echo '{
            "message":"Expected a parameter to be an integer, insted recived '.$other.'",
            "tip":"For help use the OPTIONS request"
            }';
        break;
    case 'provincia_lunga':
        http_response_code(400);
        echo '{
            "message":"Provincia is too long. It must be maximum 2 character. Found provincia '.$other.',
            "tip":"For help use the OPTIONS request"
            }';
        break;

    case 'indirizzo_binded':
        http_response_code(400);
        echo '{
            "message":"The id '.$other.' that you are trying to delete is binded to a magazzino",
            "tip":"For help use the OPTIONS request"
            }';
        break;

    case 'non_loggato':
        http_response_code(400);
        echo '{
            "message":"You must log in to do the operation requested"
            }';
        break;

     case 'inexistent_code':
        http_response_code(400);
        echo '{
            "message":"The code you asked for does not exist"
            }';
        break;

    case 'expected_parameter_in_url':
        http_response_code(400);
        echo '{
            "message":"Expected a valid parameter in the URL"
            }';
        break;




    /*  Non dovrebbe mai essere chiamato default xke sono io che faccio le chiamate  a setError e sono io che scelgo quale e il parametro*/
    default:
        http_response_code(502);
        echo '{
            "tip":"For help use the OPTIONS request"
            }';
        break;

    }
    }
}
