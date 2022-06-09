<?php 
// require_once APPPATH .'/third_party/vendor/autoload.php';
require_once(APPPATH . '/libraries/Google/autoload.php');

class Google {
	protected $CI;
	protected $client;

	public function __construct(){
		$this->CI =& get_instance();
        $this->CI->load->library('session');
        $this->CI->config->load('google_config');
        $this->client = new Google_Client();
		$this->client->setClientId($this->CI->config->item('google_client_id'));
		$this->client->setClientSecret($this->CI->config->item('google_client_secret'));
		$this->client->setRedirectUri($this->CI->config->item('google_redirect_url'));
		$this->client->setScopes(array(
			"https://www.googleapis.com/auth/plus.login",
			"https://www.googleapis.com/auth/plus.me",
			"https://www.googleapis.com/auth/userinfo.email",
			"https://www.googleapis.com/auth/userinfo.profile"
			)
		);
  

	}

	public function get_login_url(){
		return  $this->client->createAuthUrl();

	}

	public function validate($access_token){	
		
		
		// create Client Request to access Google API
		$client = new Google_Client();
		$client->setClientId($this->CI->config->item('google_client_id'));
		$client->setClientSecret($this->CI->config->item('google_client_secret'));
		$client->setRedirectUri($this->CI->config->item('google_redirect_url'));
		$client->addScope([
			"https://www.googleapis.com/auth/userinfo.email",
			"https://www.googleapis.com/auth/userinfo.profile"
		]);
		
		// authenticate code from Google OAuth Flow
		// $token = $client->fetchAccessTokenWithAuthCode('eyJhbGciOiJSUzI1NiIsImtpZCI6IjQ4NmYxNjQ4MjAwNWEyY2RhZjI2ZDkyMTQwMThkMDI5Y2E0NmZiNTYiLCJ0eXAiOiJKV1QifQ.eyJpc3MiOiJodHRwczovL2FjY291bnRzLmdvb2dsZS5jb20iLCJhenAiOiI2NTYwODM5ODgwNzItb21yOW5yYW9oNGZybmJkbzNwMzE4dW50azVxYjg4MjIuYXBwcy5nb29nbGV1c2VyY29udGVudC5jb20iLCJhdWQiOiI2NTYwODM5ODgwNzItb21yOW5yYW9oNGZybmJkbzNwMzE4dW50azVxYjg4MjIuYXBwcy5nb29nbGV1c2VyY29udGVudC5jb20iLCJzdWIiOiIxMTY4MTgyODgxNDY0NjY2MjYyMzQiLCJlbWFpbCI6ImRvYW50aGVhbmgxNzJ0YkBnbWFpbC5jb20iLCJlbWFpbF92ZXJpZmllZCI6dHJ1ZSwiYXRfaGFzaCI6IkwtVVg5VTBRQ19nd0ZIS0pKMS1wanciLCJub25jZSI6Ikl2bXlfa0NhSnZ3WU5BZUQzQnpQSEs0NmtKYk9DU29aUkx0ZFhBdVotWHMiLCJuYW1lIjoiVGjhur8gQW5oIMSQb8OgbiIsInBpY3R1cmUiOiJodHRwczovL2xoMy5nb29nbGV1c2VyY29udGVudC5jb20vYS0vQU9oMTRHak5sZFZkZHdTaTRheDV0RjAweHFUOVF4c3o4aVl3eGNkUTRQclAxUT1zOTYtYyIsImdpdmVuX25hbWUiOiJUaOG6vyBBbmgiLCJmYW1pbHlfbmFtZSI6IsSQb8OgbiIsImxvY2FsZSI6InZpIiwiaWF0IjoxNjUzMzc5MzMyLCJleHAiOjE2NTMzODI5MzJ9.b5U-AqZ5BKz_TBJAdx93-DL_4BZFxaPtcuLcp8Z_2OfNhU8y4vHoEjOYEklHaUf3Taa_SN74CNFmDNZqL5JnC0gr0wBWye2l3Cva95CrPmMU1wa9XPXqE8tpB2yk9luGC-eCXpDHjWlqZEp_I0Alz_29raWa7hkCFkkz3fCKjsaL-93xSYy2lV0-HkkyGBtXpai9Df1N3eAw6oyWz2QfbACyUEaoWvVLqoIWMXXPR9-8D5MUef9ZNsU0NTpoMKtOpYhDkOtItACmuopJSY6EcgU5SwZB1F7w9xpopa0NO4Cq0EAON2OtVJdN9xwj_w_M8-d-b53TvEQZs9Y0rmVGYA');
		// exit($token);	
		$token = array(
			"access_token" => "ya29.a0ARrdaM8B6iPNygJSCljgzXTZPqWBb4nrYIAftCgn86ZNg9t5eMyAArhL1OVwlfQVF0Xe34VvKBOxnx0k7RtVxAoeFc9pK_jvbegMYdIS99yOqYBp3RqYf9RLpVmLk1qvtSlxoYvwzCcMByZxK52g1KWQEvEh",
			// "refresh_token" => "1//04-kHvWShXx60CgYIARAAGAQSNwF-L9IrGg-B2BaMScln-r01mfVZEPznjJCZ5KfW5nsIGJekXvl94YI5wsAVKvur9PYkhMkHt9k"
		);

		$json_token = json_encode($token);
		//var_dump($json_token);die;

		$client->setAccessToken($json_token);
		//var_dump($client);die;
		// get profile info
		$google_oauth = new Google_Service_Oauth2($client);
		$google_account_info = $google_oauth->userinfo->get();
		echo $email =  $google_account_info->email;
		echo $name =  $google_account_info->name;
		exit();



		if ($access_token) {
		   exit($this->client->authenticate($access_token));
		  //$_SESSION['access_token'] = $this->client->getAccessToken();
		//   $access_token = $this->client->getAccessToken($access_token);

		 }
		if (isset($access_token) && $access_token) {
		  $client->setAccessToken($access_token);
		  $plus = new Google_Service_Plus($client);
			$person = $plus->people->get('me');
			$info['id']=$person['id'];
			$info['email']=$person['emails'][0]['value'];
			$info['email']=$person['phone'][0]['value'];
			$info['name']=$person['displayName'];
			$info['link']=$person['url'];
			$info['profile_pic']=substr($person['image']['url'],0,strpos($person['image']['url'],"?sz=50")) . '?sz=800';

		   return  $info;
		}


	}

}