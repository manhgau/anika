<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'third_party/vendor/autoload.php';
use FacebookAds\Api;
use FacebookAds\Logger\CurlLogger;
use FacebookAds\Object\AdAccount;
use FacebookAds\Object\Campaign;
use FacebookAds\Object\Fields\CampaignFields;
use FacebookAds\Object\User;
use Facebook\Facebook; 

class Auth extends CI_Controller {

	public $me;
	public function __construct()
	{
		parent::__construct();
		$this->load->model('member_model');
		$this->me=null;
	}

	public function __jsonResponse($code=200, $msg='success', $data=[])
	{
        $this->result['code'] = $code;
        $this->result['msg'] = $msg;
        $this->result['data'] = $data;
        header('Content-Type: application/json');
        echo json_encode($this->result);
        exit();
	}

	public function index()
	{
		$accessToken = trim($this->input->get_post('accessToken'));
		if (! $accessToken) 
			$this->__jsonResponse(400, 'bad request');

		$fb = new \Facebook\Facebook([
		  'app_id' => config_item('FB_APP_ID'),
		  'app_secret' => config_item('FB_APP_SECRET_KEY'),
		  'default_graph_version' => 'v2.10',
		]);

		try {
			// Get the \Facebook\GraphNodes\GraphUser object for the current user.
			// If you provided a 'default_access_token', the '{access-token}' is optional.
			$response = $fb->get('/me?fields=id,name,email', $accessToken);

		} catch(\Facebook\Exceptions\FacebookResponseException $e) {
		  	// When Graph returns an error
			$msg= 'Graph returned an error: ' . $e->getMessage();
			$this->__jsonResponse(500, $msg);
		} catch(\Facebook\Exceptions\FacebookSDKException $e) {
		  	// When validation fails or other local issues
			$msg = 'Facebook SDK returned an error: ' . $e->getMessage();
			$this->__jsonResponse(500, $msg);
		}

		$me = $response->getGraphUser();
		$userLogin = $this->member_model->fbLogin($me->getId(), $me->getEmail(), $me->getName());
		
		if ($userLogin===false) {
			$this->__jsonResponse(500, 'Hệ thống bận');
		}

		# set session
		$userdata = $userLogin;
		$array = array(
			'user_login' => 1,
			'fb_id' => $me->getId(),
			'accessToken' => $accessToken,
			'user_session_id' => $me->getId() . '_' . time(),
		);

		session_regenerate_id(TRUE);
		$this->session->set_userdata( $array );
		$this->me = (object)$userLogin;
		$array['user_nav'] = $this->load->view('home/block/user-nav', ['me' => $userLogin], TRUE);
		$this->__jsonResponse(200, 'success', $array);

	}

}

/* End of file Auth.php */
/* Location: ./application/backend/controllers/Auth.php */