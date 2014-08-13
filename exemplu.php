<?php 

include 'src/ServiceImpl.php';

session_name('linkedin');
session_start();
 

$serviceImpl = unserialize($_SESSION['service']);

// OAuth 2 Control Flow
if (isset($_GET['error'])) {
    // LinkedIn returned an error
    print $_GET['error'] . ': ' . $_GET['error_description'];
    exit;
} elseif (isset($_GET['code'])) {   
        $serviceImpl->getAccessToken();
} else { 
    if ((empty($_SESSION['expires_at'])) || (time() > $_SESSION['expires_at'])) {
        // Token has expired, clear the state
        $_SESSION = array();
    }
    if (empty($_SESSION['access_token'])) {
        // Start authorization process
        
        $serviceImpl->getAuthorizationCode();
    }
}
 
$_SESSION['service'] = serialize($serviceImpl);

/*http://api.linkedin.com/v1/people-search?school-name=Shermer%20High%20School

http://api.linkedin.com/v1/people-search? keywords=[space delimited keywords]& first-name=[first name]& last-name=[last name]& company-name=[company name]& current-company=[true|false]& title=[title]& current-title=[true|false]& school-name=[school name]& current-school=[true|false]& country-code=[country code]& postal-code=[postal code]& distance=[miles]& start=[number]& count=[1-25]&  facet=[facet code, values]& facets=[facet codes]&  sort=[connections|recommenders|distance|relevance]*/

// Congratulations! You have a valid token. Now fetch your profile 
$user = $serviceImpl->fetch('GET', '/v1/people-search?first-name=Erja&last-name=Eduard'); ?>


<html>
<head>
<body>
    <p><?php echo $user->firstName; ?></p>
</body>
</head>
</html>