<?php
include 'Service.php';

class ServiceImpl implements Service{
    
    private $API_KEY;
    private $API_SECRET;
    private $REDIRECT_URI;
    private $SCOPE;
    
    function __construct(){
        
        $this->API_KEY = "77hgg0agiu8tmv";
        $this->API_SECRET = "sOGst8qtbtypBV2M";
        $this->REDIRECT_URI = "https://localhost/LinkedInApp/linkedin.php";
        $this->SCOPE = "r_fullprofile r_network";
    }
    
    
    
    /*
        Trying to connect through LinkedIn Api
    */
    public function getAuthorizationCode() {
    $params = array('response_type' => 'code',
                    'client_id' => $this->$API_KEY,
                    'scope' => $this->$SCOPE,
                    'state' => uniqid('', true), // unique long string
                    'redirect_uri' => $this->$REDIRECT_URI,
              );
 
    // Authentication request
    $url = 'https://www.linkedin.com/uas/oauth2/authorization?' . http_build_query($params);
     
    // Needed to identify request when it returns to us
    $_SESSION['state'] = $params['state'];
 
    // Redirect user to authenticate
    header("Location: $url");
    exit;
}
    
    
    /*
    
        Retrieve access token in order to use LinkedIn Api
    
    */
    public function getAccessToken() {
    $params = array('grant_type' => 'authorization_code',
                    'client_id' => $this->API_KEY,
                    'client_secret' => $this->API_SECRET,
                    'code' => $_GET['code'],
                    'redirect_uri' => $this->REDIRECT_URI,
              );
     
        
    // Access Token request
    $url = 'https://www.linkedin.com/uas/oauth2/accessToken?' . http_build_query($params);
     
    // Tell streams to make a POST request
    $context = stream_context_create(
                    array('http' => 
                        array('method' => 'POST',
                        )
                    )
                );
 
    // Retrieve access token information
    $response = file_get_contents($url, false, $context);
 
    // Native PHP object, please
    $token = json_decode($response);
 
    // Store access token and expiration time
    $_SESSION['access_token'] = $token->access_token; // guard this! 
    $_SESSION['expires_in']   = $token->expires_in; // relative time (in seconds)
    $_SESSION['expires_at']   = time() + $_SESSION['expires_in']; // absolute time
     
    return true;
    }
    
    
    /*
        Fetch from json list
    */
    public function fetch($method, $resource, $body = '') {
    $params = array('oauth2_access_token' => $_SESSION['access_token'],
                    'format' => 'json',
              );
        
 
     
    // Need to use HTTPS
    $url = 'https://api.linkedin.com' . $resource . '?' . http_build_query($params);
        
    echo $url;    

    // Tell streams to make a (GET, POST, PUT, or DELETE) request
    $context = stream_context_create(
                    array('http' => 
                        array('method' => $method,
                        )
                    )
                );
 
 
    // Hocus Pocus
    $response = file_get_contents($url, false, $context);
 
    
   // echo $response;
    // Native PHP object, please
    return json_decode($response);
    }
    
    
    public function fetchSearch($method, $resource, $body = ''){
        
         $params = array('oauth2_access_token' => $_SESSION['access_token'],
                    'format' => 'json',
              );
     
    // Need to use HTTPS
   $url = 'https://api.linkedin.com' . $resource . '&' . http_build_query($params);
        
        
        echo $url;
    // Tell streams to make a (GET, POST, PUT, or DELETE) request
    $context = stream_context_create(
                    array('http' => 
                        array('method' => $method,
                        )
                    )
                );
 
 
    // Hocus Pocus
    $response = file_get_contents($url, false, $context);
 
    
   // echo $response;
    // Native PHP object, please
    return json_decode($response);
        
    }
    
    
    
    
    
    
}

?>