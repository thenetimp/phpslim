<?php
 
namespace Security; 

use Hackerspace\User as User;
use Hackerspace\UserQuery as UserQuery;
 
class HttpXDigestAuth extends \Slim\Middleware
{

    /**
     * @var string
     */
    protected $realm;
 
    /**
     * Constructor
     *
     * @param   string  $realm      The HTTP Authentication realm
     */
    public function __construct($realm = 'Protected Area')
    {
        $this->realm = $realm;
    }

    /**
     * Deny Access
     *
     */   
    public function deny_access() {
        $res = $this->app->response();
        $res->status(401);
        $res->header('WWW-Authenticate-X', sprintf('Digest realm="%s" ,qop="auth",nonce="%s",opaque="%s"', 
            $this->realm, uniqid(), md5($this->realm)));
    }

    /**
     * Authenticate 
     *
     * @param   string  $username   The HTTP Authentication username
     * @param   string  $password   The HTTP Authentication password     
     *
     */
    public function authenticate($digestData) {

      global $user;
      $query = new UserQuery();
      $user = $query->getUserByEmailAddress($digestData['username']);

      // If no user than return false
      if(!$user) return false;

      // Get the a1 hash from the database table and run the algorithm for http digest.
      $a1 = $user->getPasswordHash();
      $a2 = md5($_SERVER['REQUEST_METHOD'].':'.$digestData['uri']);
      $validResponse = md5($a1 . ':' . $digestData['nonce'] . ':' . $digestData['nc'] . ':' . 
          $digestData['cnonce'] . ':' . $digestData['qop'] . ':' . $a2);

      // If the valid response is the same as the digest response.
      if($digestData['response'] == $validResponse)
      {
          return true;
      }

      // Return false since we didn't havea valid response
      return false;
    }


    /**
     * Call
     *
     * This method will check the HTTP request headers for previous authentication. If
     * the request has already authenticated, the next middleware is called. Otherwise,
     * a 401 Authentication Required response is returned to the client.
     */
    public function call()
    {
        $req = $this->app->request();
        $res = $this->app->response();
        $authDigest = $req->headers('PHP_AUTH_DIGEST');
        $headers = getallheaders();
        
        if(isset($headers['Authorization']))
        {
            $digestData = $this->http_digest_parse($headers['Authorization']);
        }
        
        // If we have the authdigest then parse 
        // it and try to authenticate the user.
        if(isset($digestData) && $digestData && $digestData['username'] != "" && $this->authenticate($digestData))
        {
           $this->next->call();
        } else {
            $this->deny_access();
        }
    }
    
    // function to parse the http auth header
    protected function http_digest_parse($txt)
    {
        // protect against missing data
        $needed_parts = array('nonce'=>1, 'nc'=>1, 'cnonce'=>1, 'qop'=>1, 'username'=>1, 'uri'=>1, 'response'=>1);
        $digestData = array();
        $keys = implode('', array_keys($needed_parts));
        $digestParts = explode(" ", $txt);

        // Remove the first element of the array and see if we should exit.
        if(array_shift($digestParts) != "Digest") return false;

        foreach ($digestParts as $dp) {
            list($key, $value) = explode("=", $dp);
            
            $value = rtrim($value, ',');
            $value = trim($value, '"');
            $digestData[$key] = $value;
        }
        return $digestData;
    }

        
}