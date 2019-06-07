<?php
namespace Models\Pagamenti;
use \Models\M_Pagamento as M_Pagamento;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class M_PayPal extends M_Pagamento{

    private $pagato = false;

    /** @var bool Indicates if the sandbox endpoint is used. */
    private static $use_sandbox = true;
    /** @var bool Indicates if the local certificates are used. */
    private static $use_local_certs = true;
    /** Production Postback URL */
    const VERIFY_URI = 'https://ipnpb.paypal.com/cgi-bin/webscr';
    /** Sandbox Postback URL */
    const SANDBOX_VERIFY_URI = 'https://ipnpb.sandbox.paypal.com/cgi-bin/webscr';
    const FORM_URI = 'https://www.paypal.com/cgi-bin/webscr';
    const SANDBOX_FORM_URI = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    /** Response from PayPal indicating validation was successful */
    const VALID = 'VERIFIED';
    /** Response from PayPal indicating validation failed */
    const INVALID = 'INVALID';

    public function __construct(int $id, int $idPaypal,string $numero = ""){
        parent::__construct($id);
        $this->idPaypal = $idPaypal;
        $this->numero = $numero;
    }

    public function paga(){

        //dovrebbe usare il sito della paypal e fare il pagamento la

    }
    /**
     * Sets the IPN verification to sandbox mode (for use when testing,
     * should not be enabled in production).
     * @return void
     */
    public static function useSandbox(){
        self::$use_sandbox = true;
    }
    /**
     * Sets curl to use php curl's built in certs (may be required in some
     * environments).
     * @return void
     */
    public function usePHPCerts(){
        self::$use_local_certs = false;
    }
    /**
     * Determine endpoint to post the verification data to.
     *
     * @return string
     */
    public function getPaypalUri(){
        if (self::$use_sandbox) {
            return self::SANDBOX_VERIFY_URI;
        } else {
            return self::VERIFY_URI;
        }
    }

    public function getPaypalFormUri(){
       if (self::$use_sandbox) {
           return self::SANDBOX_FORM_URI;
       } else {
           return self::FORM_URI;
       }
    }
    /**
     * Verification Function
     * Sends the incoming post data back to PayPal using the cURL library.
     *
     * @return bool
     * @throws Exception
     */
    public static function verifyIPN(Request $req){
        if($req->isEmpty())
            throw new \ModelException("Missing POST Data", __CLASS__, array(), 1);
        $raw_post_data = file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        foreach ($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if (count($keyval) == 2) {
                // Since we do not want the plus in the datetime string to be encoded to a space, we manually encode it.
                if ($keyval[0] === 'payment_date') {
                    if (substr_count($keyval[1], '+') === 1) {
                        $keyval[1] = str_replace('+', '%2B', $keyval[1]);
                    }
                }
                $myPost[$keyval[0]] = urldecode($keyval[1]);
            }
        }
        // Build the body of the verification post request, adding the _notify-validate command.
        $req = 'cmd=_notify-validate';
        $get_magic_quotes_exists = false;
        if (function_exists('get_magic_quotes_gpc')) {
            $get_magic_quotes_exists = true;
        }
        foreach ($myPost as $key => $value) {
            if ($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) {
                $value = urlencode(stripslashes($value));
            } else {
                $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }
        // Post the data back to PayPal, using curl. Throw exceptions if errors occur.
        $ch = curl_init(self::getPaypalUri());
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSLVERSION, 6);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        // This is often required if the server is missing a global cert bundle, or is using an outdated one.
        if (self::$use_local_certs) {
            curl_setopt($ch, CURLOPT_CAINFO, ROOT . "/libs/paypal/cacert.pem");
        }
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'User-Agent: PHP-IPN-Verification-Script',
            'Connection: Close',
        ));
        $res = curl_exec($ch);
        if ( ! ($res)) {
            $errno = curl_errno($ch);
            $errstr = curl_error($ch);
            curl_close($ch);
            throw new \ModelException("CURL error", __CLASS__, array($errno=>$errstr), 2);
        }
        $info = curl_getinfo($ch);
        $http_code = $info['http_code'];
        curl_close($ch);
        if ($http_code != 200)
            throw new \ModelException("PayPal responded with http code $http_code", __CLASS__, array('code'=>$http_code), 3);
        // Check if PayPal verifies the IPN data, and if so, return true.
        return $res === self::VALID;
    }

    public static function newPayment(Request $req): M_Pagamento{
        return new M_PayPal(0, 0);
    }

    public function getType(): string{
        return "PayPal";
    }

    public function getIdPaypal():int{
        return $this->idPaypal;
    }

    public function getNumero():string{
        return $this->numero;
    }
}
