<?php
require APPPATH . 'third_party/google-api-php-client/src/Google/autoload.php';
class Google extends Google_Client {
    
    public function __construct($params=array())
    {
        parent::__construct();
    }
    
}