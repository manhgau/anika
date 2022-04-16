<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH . 'third_party/vendor/autoload.php';
use Facebook\Facebook; 
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Apiv1 extends CI_Controller {

	private $me;
	const HASH_SECRET = 'AzdtB98#gWFbNA?6*ceQGUg*MJf9G8C6';
	private $request;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('member_model');
		$this->load->model('postrequest_model');
		$this->load->model('pointload_model');
		$this->load->model('pointrefund_model');
		$this->load->model('realnews_model');

		$reqType = strtolower($this->input->server('REQUEST_METHOD'));
		if ($reqType === 'post') {
			$this->request = json_decode(file_get_contents('php://input'), true);
		}
		elseif ($reqType === 'get') {
			$this->request = $this->input->get();
		}
		else
			$this->__jsonResponse(404, 'bad_request');

		// if ($this->router->fetch_method()=='getKey') {
		// 	$this->getKey();
		// }

		// # giới hạn thời gian theo múi giờ, chênh lệch 12 tiếng
		// $reqTime = intval($this->request['uxtime']);
		// if (abs(time() - $reqTime) > 12*60*60)
		// 	$this->__jsonResponse(404, 'bad_request');

		// $requestKey = trim(@$this->request['reqkey']);
		
		// ### hashkey = md5(secret_key + unixtime + ip_address)
		// $checkReqKey = md5(self::HASH_SECRET . @$this->request['uxtime'] . $this->input->server('REMOTE_ADDR'));

		// if (!$requestKey || $requestKey!=$checkReqKey) {
		// 	$this->__jsonResponse(400, 'bad_request');
		// }

		// if (@$this->request['fb_id']) {
		// 	$this->me = $this->member_model->get_by(['fb_id'=>$this->request['fb_id']], true);
		// 	$this->me->session_id = $this->me->fb_id . '_' . strtotime($this->me->last_login);
		// }
		// else
		// 	$this->me = null;

	}

	private function assignToken()
	{
		$key = "example_key";
		$payload = array(
			"iss" => base_url(),
			"aud" => base_url(),
			"1356999524" => 1356999524,
			"nbf" => 1357000000
		);
		return $jwt = JWT::encode($payload, $key, 'HS256');
	}

	private function verifyToken()
	{
		$key = "example_key";
		$payload = array(
			"iss" => base_url(),
			"aud" => base_url(),
			"1356999524" => 1356999524,
			"nbf" => 1357000000
		);
		return $jwt = JWT::encode($payload, $key, 'HS256');
	}

	public function getKey()
	{
		$uxtime= time();
		$ip = $this->input->server('REMOTE_ADDR');
		$data = ['uxtime' => $uxtime, 'ip' => $ip, 'key' => md5(self::HASH_SECRET . $uxtime . $ip)];
		$this->__jsonResponse(200, 'ok', $data);
		
	}

	public function postLogout()
	{
		if (! $this->me) 
			$this->__jsonResponse(400, 'bad_request');

		$this->__jsonResponse(200, 'success');
	}

	public function postLogin()
	{
		$accessToken = trim($this->request['accessToken']);
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
			// $msg= 'Graph returned an error: ' . $e->getMessage();
			$this->__jsonResponse(400, $e->getMessage());
		
		} catch(\Facebook\Exceptions\FacebookSDKException $e) {
		  	// When validation fails or other local issues
			// $msg = 'Facebook SDK returned an error: ' . $e->getMessage();
			$this->__jsonResponse(500, $e->getMessage());
		}

		$me = $response->getGraphUser();
		$userLogin = $this->member_model->fbLogin($me->getId(), $me->getEmail(), $me->getName());
		
		if ($userLogin===false) {
			$this->__jsonResponse(500, 'system_busy');
		}

		$user = $this->member_model->getMemberByFbId($me->getId());
		$user->session_id = $me->getId() . '_' . strtotime($user->last_login);
		$user->ip_address = $this->input->server('REMOTE_ADDR');

		$this->__jsonResponse(200, 'success', $user);
	}

	public function getNews()
	{
		$code = $this->request['code'];
		$news = toArray($this->realnews_model->getPublicNewsByCode($code));
		if (! $news) 
			$this->__jsonResponse(404, 'news_not_exist');

		# nếu user chưa đăng nhập, hoặc chưa mua bài viết thì ẩn bớt thông tin
		$hidenInfo = false;
		if (!$this->me || !$this->realnews_model->checkNewsBought($news['id'], $this->me->id, $this->me->session_id)) {
			$hidenInfo = true;
		}

		if ($hidenInfo) 
			$news = $this->realnews_model->newsUnBoughtFilter($news);

		$this->__jsonResponse(200, 'success', ['news' => $news]);
	}

	public function getListNews()
	{
		$list = $this->realnews_model->getListNews($this->request);
		$this->__jsonResponse(200, 'success', $list);
	}

	public function postNewsRequest()
	{
		if (! $this->me)
			$this->__jsonResponse(401, 'not_login');

		$url = $this->request['url'];
		$point = intval($this->request['point']);
		$title = cleanInputString($this->request['title']);
		$owner_phone = cleanInputString($this->request['owner_phone']);
		$owner_name = cleanInputString($this->request['owner_name']);
		$address = cleanInputString($this->request['address']);
		$details = json_encode($this->request);
		
		$result = $this->postrequest_model->addRequest( intval($this->me->id), $title, $url, $point, $owner_phone, $owner_name, $address, $details );
		if ($result=='success') {
			$this->me->point -= $point;
			$this->__jsonResponse(200, 'success_and_wait_to_approve', ['me' => $this->me]);
		}
		else
			$this->__jsonResponse(500, $result, []);
	}

	public function postBuyNews()
	{
		if (! $this->me)
			$this->__jsonResponse(401, lang('not_login'));

		$code = $this->request['code'];
		$news = toArray($this->realnews_model->getPublicNewsByCode($code));
		
		if (! $news) 
			$this->__jsonResponse(404, 'news_not_exist');
		
		# check bought
		if ($this->me && $this->realnews_model->checkNewsBought($news['id'], $this->me->id, $this->me->session_id)) {
			$this->__jsonResponse(200, 'success', ['news' => $news, 'me' => $this->me]);
		}

		if ($this->me->point < $news['point']) 
			$this->__jsonResponse(400, 'your_point_not_enough');

		if ($this->pointload_model->processBuyNews($news['code'], intval($this->me->id), intval($news['point']), intval($news['member_id']))) {
			$this->me->point = intval($this->me->point) - intval($news['point']);
			
			$this->db->insert('member_news', ['news_id' => $news['id'], 'member_id'=>$this->me->id, 'point' => $news['point'], 'session_id' => $this->me->session_id]);

			$this->__jsonResponse(200, 'success', ['news' => $news, 'me' => $this->me]);
		}
		else
			$this->__jsonResponse(500, 'system_busy', []);
	}

	public function postRefundRequest()
	{
		if (! $this->me)
			$this->__jsonResponse(401, lang('not_login'));

		$url = $this->request['url'];
		$code = trim($this->request['code']);
		$note = cleanInputString($this->request['note']);

		$result = $this->pointrefund_model->addRequest( intval($this->me->id), $code, $url, $note ); 
		
		if ($result=='success') 
			$this->__jsonResponse(200, 'success');
		elseif ($result=='system_busy') 
			$this->__jsonResponse(500, 'system_busy');
		else
			$this->__jsonResponse(400, $result);
	}

	public function getProvince()
	{
		$this->request['type'] = 'province';
		$this->request['parent_id'] = 0;
		$this->getListLocationByPrarent();
	}

	public function getDistrict()
	{
		$this->request['type'] = 'district';
		$this->request['parent_id'] = $this->request['province_id'];
		$this->getListLocationByPrarent();
	}

	public function getListLocationByPrarent()
	{
		$parentId = $this->request['parent_id'];
		$type = $this->request['type'];
		$allowType = ['country', 'region', 'province', 'district', 'ward'];
		$locName = [
			'country'=>'Quốc gia', 
			'region' => 'Vùng miền', 
			'province' => 'Tỉnh/thành', 
			'district' => 'Quận/huyện', 
			'ward' => 'Xã/phường'
		];

		if ( ! in_array($type, $allowType)) 
			$this->__jsonResponse(400, 'Yêu cầu không hợp lệ');

		if ($type=='region') 
		{
			$this->load->model('region_model');
			$location = $this->region_model->getRegionByCountry(VIETNAM);
		}
		elseif ($type=='province') 
			$location = $this->location_model->getProvince();
		elseif ($type=='district') 
			$location = $this->location_model->getDistrictByProvince($parentId);
		elseif ($type=='ward') 
			$location = $this->location_model->getWardByDistrict($parentId);

		if ($location) 
		{
			$data[] = [
				'id'=>'', 
				'name'=>'--- Chọn '.$locName[$type].' ---'
			];
			foreach ($location as $key => $value) 
			{
				$data[] = [
					'id' => $value->id,
					'name' => $value->name
				];
			}
			$this->__jsonResponse(200, 'success', $data);
		}
		else
			$this->__jsonResponse(200, 'data empty', NULL);
	}

	public function appInit()
	{
		$data = [];
		$data['enable_src'] = 0;
		$data['user_ip'] = $this->input->server('REMOTE_ADDR');
		$data['service_type'] = $this->realnews_model->getService();
		$data['type'] = $this->realnews_model->getType();
		$data['news_status'] = $this->realnews_model->getStatus();
		$prices = $this->realnews_model->publishPrice();
		foreach ($prices as $key => $value) {
			$data['publish_price'][$value] = $value . ' ' . lang('point');
		}
		$this->__jsonResponse(200, 'success', $data);
	}

	public function __jsonResponse($code=200, $msg='success', $data=[])
	{
        $result['code'] = $code;
        $result['msg'] = (lang($msg)) ? lang($msg) : $msg;
        $result['data'] = ($data) ? $data : null;
        header('Content-Type: application/json');
        echo json_encode($result);
        exit();
	}

	public function checkSalePhone()
	{
		$check = isNotSalePhone($this->request['phone']);
		$this->__jsonResponse(($check=='success') ? 200 : 400, $check);
	}

}

/* End of file Apiv1.php */
/* Location: ./application/backend/controllers/Apiv1.php */