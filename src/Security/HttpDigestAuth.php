<?php
 
namespace Security; 

use Hackerspace\User as User;
use Hackerspace\UserQuery as UserQuery;
 
class HttpDigestAuth extends \Slim\Middleware
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
        $res->header('WWW-Authenticate', sprintf('Digest realm="%s" ,qop="auth",nonce="%s",opaque="%s"', 
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

        // $2a$10$3a6e9fdc6ff518125982fuDYwUHkEJokgXKKHTjxMN80j.41hwmVK
        // $a1 = md5($digestData['username'] . ':' . $this->realm . ':' . 'testing12345');

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
        $digestData = $this->http_digest_parse($authDigest);
        
        // If we have the authdigest then parse 
        // it and try to authenticate the user.
        if($digestData && $this->authenticate($digestData))
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
        $keys = implode('|', array_keys($needed_parts));

        preg_match_all('@(' . $keys . ')=(?:([\'"])([^\2]+?)\2|([^\s,]+))@', $txt, $matches, PREG_SET_ORDER);

        foreach ($matches as $m) {
            $digestData[$m[1]] = $m[3] ? $m[3] : $m[4];
            unset($needed_parts[$m[1]]);
        }

        return $needed_parts ? false : $digestData;
    }

        
}