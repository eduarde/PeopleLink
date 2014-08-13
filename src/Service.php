<?php

interface Service{
    
    public function getAccessToken();
    public function getAuthorizationCode();
    public function fetch($method, $resource, $body = '');
    
    
}
?>