<?php 

    $url = "https://www.linkedin.com/uas/oauth2/authorization?response_type=code&client_id=77hgg0agiu8tmv&scope=r_fullprofile&state=DCEEFWF45453sdffef424&redirect_uri=https://localhost/LinkedInApp/linkedin.php";
   
  header("Location: $url");
exit();

?>