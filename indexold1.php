<?php

if( session_id() ){
    
    session_destroy();
    
}

session_start();


 $ApiKey = "77hgg0agiu8tmv";
 $SecretKey = "sOGst8qtbtypBV2M";

 $code = $_REQUEST['code'];
 $state = $_REQUEST['state'];


 echo $code;

 $redirectURL = "https://localhost/LinkedInApp/index.php";
 $url = "https://www.linkedin.com/uas/oauth2/accessToken?grant_type=authorization_code&code=".$code."&redirect_uri=".$redirectURL."&client_id=".$ApiKey."&client_secret=".$SecretKey;


?>
<html>
<head>
    <title>LinkedIn App</title>
</head>
<body>
     <form method="post" action=<?php echo $url; ?>>
            <input type="submit" value="Click" />
		</form>	
</body>
</html>

