<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

defined('BASEPATH') OR exit('No direct script access allowed');
class apiApp extends CI_Controller {

	private $me;
	const HASH_SECRET = 'AzdtB98#gWFbNA?6*ceQGUg*MJf9G8C6';
	private $request;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('member_model');
		$this->load->model('products_model');
		$this->load->model('banner_model');
		$this->load->model('post_model');
		$this->load->model('notification_model');
		$this->load->model('init_model');
		$this->load->model('partner_model');
		$this->load->model('fieldActivity_model');
		$this->load->library('keyemail');	
		$this->load->library('my_phpmailer');
		$this->load->library('facebook');
		$this->load->library('google');

		$reqType = strtolower($this->input->server('REQUEST_METHOD'));
		if ($reqType === 'post') {
			$this->request = json_decode(file_get_contents('php://input'), true);
		}
		elseif ($reqType === 'get') {
			$this->request = $this->input->get();
		}
		else
			$this->__jsonResponse(404, 'bad_request');
    }


	private function __getProfilebyToken($token)
	{
		$key = 'ManhGau@UET@2022%$#*)(++';
		try {
			$decoded = JWT::decode($token, new Key($key, 'HS256'));
			return $decoded;
		} catch (Exception $e) { // Also tried JwtException
				return  $e->getMessage();
		}
	}
	private function __returnToken($member)
	{
				$time=time();
				$key = 'ManhGau@UET@2022%$#*)(++';
				$payload = [
					'id'  				=> $member->id,
					'url_fb' 			=> $member->url_fb,
					'exp' 				=> $time + 60*5
				];
				$payload_refresh = [
					'id'  				=> $member->id,
					'url_fb' 			=> $member->url_fb,
					'exp' 				=> $time + 30*60*60*24
				];
		
			$access_token = JWT::encode($payload, $key, 'HS256');
			$refresh_token = JWT::encode($payload_refresh, $key, 'HS256');
			return 	array(
				'access_token'   => $access_token,
				'refresh_token'   => $refresh_token,
			);	
	}
	
	private function __jsonResponse($code=200, $msg='success', $data=[])
	{
        $result['code'] = $code;
        $result['msg'] = (lang($msg)) ? lang($msg) : $msg;
        $result['data'] = ($data) ? $data : null;
        header('Content-Type: application/json');
        echo json_encode($result);
        exit();
	}
	
	public function listBanner()
	{
		$limit  = (int)isset($_GET['limit'])? intval($_GET['limit']) : 10;		
		$page  = (int)isset($_GET['page'])? intval($_GET['page']) : 1;  
		if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;
        $type = isset($_GET['type'])? intval($_GET['type']) : null;
		$data = [
        	'pagination' => [
        		'page' => $page,
        		'limit' => $limit,
        		'prev' => ($page>1) ? $page-1 : 1,
        		'next' => false 
        	]
        ];
		if (!$type){
			$this->__jsonResponse(400, 'input_not_valid');
        }
        $rs = $this->banner_model->get_list_banners($offset, $limit ,$type);	
		if (!$rs) 
		$this->__jsonResponse(404, 'notfound', $data);	
		if(is_array($rs) && count($rs) > 0){
			foreach($rs as $key => $item){
				
				$item->image = getImageUrl($item->image);
				unset($item->order);
				$rs[$key] = $item;
			}
		}		
		$data['list'] = $rs;
		$data['pagination']['next'] = (count($rs)==$limit) ? $page+1 : false;
		$this->__jsonResponse(200, 'success',$data);      
	}
	
	public function appInit()
	{
		$sliders = $this->banner_model->get_list_banners(0, 3 ,1);
		if(is_array($sliders) && count($sliders) > 0) {
			foreach($sliders as $key => $item){
				$item->image = getImageUrl($item->image);
				$sliders[$key] = $item;
				unset($item->order);
			}
		}
		$data = $this->init_model->get_app_init();
		if(is_array($data) && count($data) > 0) {
			foreach($data as $key => $item){				
				$settings[$item->name] =$item->value;	
			}
		} 

		$settings['logo_start'] = getImageUrl($settings['logo_start']);
		$settings['logo_in_app'] = getImageUrl($settings['logo_in_app']);
		$data = [
			'siteOptions' => $settings,
			'slider' => $sliders
		];

		$this->__jsonResponse(200, 'success', $data);
	}
	
	public function listPartner() {
		$limit  = (int)isset($_GET['limit'])? intval($_GET['limit']) : 10;		
		$page  = (int)isset($_GET['page'])? intval($_GET['page']) : 1; 
		if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;
		$data = [
        	'pagination' => [
        		'page' => $page,
        		'limit' => $limit,
        		'prev' => ($page>1) ? $page-1 : 1,
        		'next' => false 
        	]
        ];

		$rs = $this->partner_model->get_list_partner($offset, $limit);
		if (!$rs) 
		$this->__jsonResponse(404, 'notfound', $data);	
		if(is_array($rs) && count($rs) > 0){
			foreach($rs as $key => $item){
				$item->image = getImageUrl($item->image);
				unset($item->content);
				unset($item->description);
				$rs[$key] = $item;
			}
		}
		$data['list'] = $rs;
		$data['pagination']['next'] = (count($rs)==$limit) ? $page+1 : false;
		$this->__jsonResponse(200, 'success',$data);    
	}
	
	public function detailPartner() {				
		$id = isset($_GET['id'])?$_GET['id']:null;
		if(!$id){
			$this->__jsonResponse(400, 'input_not_valid');
		}
		$partner = $this->partner_model->get_detail_partner($id);
		if(!$partner){
			$this->__jsonResponse(404, 'notfound');
		}
		$partner->image = getImageUrl($partner->image);
		$this->__jsonResponse(200, 'success', $partner);
	}
	
	public function listPost() {
		$limit  = (int)isset($_GET['limit'])? intval($_GET['limit']) : 10;		
		$page  = (int)isset($_GET['page'])? intval($_GET['page']) : 1;  
		if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;
		$data = [
        	'pagination' => [
        		'page' => $page,
        		'limit' => $limit,
        		'prev' => ($page>1) ? $page-1 : 1,
        		'next' => false 
        	]
        ];
        $category_id = isset($_GET['category_id'])? intval($_GET['category_id']) : null;
		$is_hot = isset($_GET['is_hot'])?intval($_GET['is_hot']):null;
		
		if (!$category_id)
			$this->__jsonResponse(400, 'input_not_valid');
		$get_category = $this->post_model->get_category($category_id, true);
		if (!$get_category)
			$this->__jsonResponse(400, 'bad_request', $data);

		$data['category'] = $get_category;
        $rs = $this->post_model->list_post($offset, $limit, $category_id, $is_hot);	
		if (!$rs) 
		$this->__jsonResponse(404, 'notfound', $data);				
		if(is_array($rs) && count($rs) > 0){
			foreach($rs as $key => $item){
				$item->thumbnail = getImageUrl($item->thumbnail);
				unset($item->meta_description);
				unset($item->description);
				unset($item->content);
				$rs[$key] = $item;
			}
		}		
		$data['list'] = $rs;
		$data['pagination']['next'] = (count($rs)==$limit) ? $page+1 : false;
		$this->__jsonResponse(200, 'success',$data);  

	}
	
	public function detailPost() {				
		$id = isset($_GET['id'])?intval($_GET['id']):null;
		if(!$id)
		$this->__jsonResponse(400, 'input_not_valid',[]);
		$post = $this->post_model->detail_post($id);
		if(!$post)
			$this->__jsonResponse(404, 'not_found');	
		$post->thumbnail = getImageUrl($post->thumbnail);
		unset($post->news_id);
		unset($post->term_order);
		$this->__jsonResponse(200, 'success', $post);
	}
	
	public function listProducts() {
		$limit  = (int)isset($_GET['limit'])? intval($_GET['limit']) : 10;		
		$page  = (int)isset($_GET['page'])? intval($_GET['page']) : 1;  
		if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;
        $category_id = isset($_GET['category_id'])? intval($_GET['category_id']) : null;
        $data = [
        	'pagination' => [
        		'page' => $page,
        		'limit' => $limit,
        		'prev' => ($page>1) ? $page-1 : 1,
        		'next' => false 
        	]
        ];
		
		if (!$category_id)
			$this->__jsonResponse(400, 'input_not_valid');

		$category = $this->products_model->get_category($category_id, true);
		$category->image = getImageUrl($category->image);
		if (!$category)
			$this->__jsonResponse(400, 'bad_request', $data);

		$data['category'] = $category;

        $rs = $this->products_model->get_list_products($limit, $offset, $category_id);	
        if (!$rs) 
			$this->__jsonResponse(404, 'notfound', $data);

		if(is_array($rs) && count($rs) > 0){
			foreach($rs as $key => $item) {
				$item->status_name = lang($item->status);
				$item->thumbnail = getImageUrl($item->thumbnail);
				$item->category_name = $category->title;
				unset($item->content);
				$rs[$key] = $item;
			}
		}
		
		$data['list'] = $rs;
		$data['pagination']['next'] = (count($rs)==$limit) ? $page+1 : false;
		$this->__jsonResponse(200, 'success',$data);
	}

	public function detailProduct() {
		$id = isset($_GET['id'])?intval($_GET['id']):null;
		if (! $id) 
			$this->__jsonResponse(400, 'input_not_valid',[]);

		$product = $this->products_model->get_detail_product($id);
		if(!$product)
			$this->__jsonResponse(404, 'not_found');	

		$product->status_name = lang($product->status);
		$product->thumbnail = getImageUrl($product->thumbnail);
		$this->__jsonResponse(200, 'success', $product);		
	}

	public function fieldActivity(){
		$limit  = (int)isset($_GET['limit'])? intval($_GET['limit']) : 10;		
		$page  = (int)isset($_GET['page'])? intval($_GET['page']) : 1;  
		if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;
		$data = [
        	'pagination' => [
        		'page' => $page,
        		'limit' => $limit,
        		'prev' => ($page>1) ? $page-1 : 1,
        		'next' => false 
        	]
        ];
		$rs = $this->fieldActivity_model->get_list_field($offset, $limit);
		if (!$rs) 
		$this->__jsonResponse(404, 'notfound', $data);	
		if(is_array($rs) && count($rs) > 0){
			foreach($rs as $key => $item){
				$item->image = getImageUrl($item->image);
				unset($item->status);
				$rs[$key] = $item;
			}
		}
		$data['list'] = $rs;
		$data['pagination']['next'] = (count($rs)==$limit) ? $page+1 : false;
		$this->__jsonResponse(200, 'success',$data);   
	}

	public function categoryProducts(){
		$limit  = (int)isset($_GET['limit'])? intval($_GET['limit']) : 10;		
		$page  = (int)isset($_GET['page'])? intval($_GET['page']) : 1;  
		if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;
		$data = [
        	'pagination' => [
        		'page' => $page,
        		'limit' => $limit,
        		'prev' => ($page>1) ? $page-1 : 1,
        		'next' => false 
        	]
        ];
		$rs = $this->products_model->get_list_category_products($offset, $limit);
		if (!$rs) 
		$this->__jsonResponse(404, 'notfound', $data);	
		if(is_array($rs) && count($rs) > 0){
			foreach($rs as $key => $item){
				$item->image = getImageUrl($item->image);
				unset($item->status);
				$rs[$key] = $item;
			}
		}
		$data['list'] = $rs;
		$data['pagination']['next'] = (count($rs)==$limit) ? $page+1 : false;
		$this->__jsonResponse(200, 'success',$data);   
	}

	public function  getProfile()
	{
		$access_token = isset($_GET['access_token'])?$_GET['access_token']:"";
		if(!$access_token){
			$this->__jsonResponse(400, 'input_not_valid',[]);
		}
		$data_profile = $this->__getProfilebyToken($access_token);
		if($data_profile =='Expired token' ){
			$this->__jsonResponse(405, 'token_expires');
		}
		if($data_profile =='Signature verification failed' ){
			$this->__jsonResponse(406, 'token_false');
		}
		$id = $data_profile->id;
		if(!$id){
			$this->__jsonResponse(404, 'not_found');
		}
		$profile = $this->member_model->get_detail_member($id);
		$profile->avatar = getImageUrl($profile->avatar);
		if(!$profile)
			$this->__jsonResponse(404, 'not_found');
		$this->__jsonResponse(200, 'success', $profile);

	}

	public function updateProfile(){
		$access_token = isset($_GET['access_token'])?$_GET['access_token']:"";
		if(!$access_token){
			$this->__jsonResponse(400, 'input_not_valid',[]);
		}
		$data_profile = $this->__getProfilebyToken($access_token);
		if($data_profile =='Expired token' ){
			$this->__jsonResponse(405, 'token_expires');
		}
		if($data_profile =='Signature verification failed' ){
			$this->__jsonResponse(406, 'token_false');
		}
		$id = $data_profile->id;
		if(!$id){
			$this->__jsonResponse(404, 'not_found');
		}
		$profile = array();
        $profile['fullname'] = $this->request['fullname'];
        $profile['email'] 	= $this->request['email'];
        $profile['phone'] 	= $this->request['phone'];
        $profile['addres'] 	= $this->request['addres'];
		if(!empty( $profile['email']) && !empty( $profile['phone'])  && !empty( $profile['fullname']) && !empty( $profile['addres'])){
			$rs= $this->member_model->update_profile($profile,$id);
			if($rs['code'] == 1){
				$data = $this->member_model->get_detail_member($id);
				$this->__jsonResponse(200, 'success', $data);
			}
			if($rs['code'] == 2){
				$this->__jsonResponse(404,'trouble',[]);
			}
			if($rs['code'] == 3){
				$this->__jsonResponse(500,'phone_and_email_already',[]);
			}
		}
		$this->__jsonResponse(400,$this->lang->line('request'),[]);
		
	}

	public function loginForm(){
		$memberData = array();
        $memberData['email'] = $this->request['email'];
        $memberData['phone'] = $this->request['phone'];
        $memberData['password'] = $this->request['password'];	
		if(!empty($memberData['password']) && (!empty($memberData['email']) || !empty( $memberData['phone'])) ){			
			$rs= $this->member_model->do_login($memberData);
			if($rs['code'] == 1){
				$member= $this->member_model->get_detail_member($rs['data']);
				$token = $this->__returnToken($member);		
			$data = [
				'profile'	=> $member,
				'token' 	=> $token,
			];
			$this->__jsonResponse(200,'OK',$data);
			}
			if($rs['code'] == 2){
				$this->__jsonResponse(404,"password_incorrect",[]);	
			}
			if($rs['code'] == 3){
				$this->__jsonResponse(500,"not_found",[]);				
			}
		}
		$this->__jsonResponse(400,"request",[]);
	}

	public function registrationForm(){			
		$memberData = array();
        $memberData['email'] 			= $this->request['email'];
        $memberData['phone'] 			= $this->request['phone'];
        $memberData['password'] 		= password_hash($this->request['password'], PASSWORD_DEFAULT);
        $memberData['department_id'] 	= isset($this->request['department_id'])?$this->request['department_id']:"";
		$password_confirm = $this->request['password_confirm'];
		if(!empty( $memberData['email']) && !empty( $memberData['phone']) && !empty($memberData['password']) && !empty($password_confirm)){
			if(password_verify($password_confirm, $memberData['password'])){
				$do_registration= $this->member_model->do_registration($memberData);
				if($do_registration){
					if($do_registration == 1){
						$this->__jsonResponse(401,"request_already",[]);
					}else{
						$member= $this->member_model->get_detail_member($do_registration);
						$token = $this->__returnToken($member);		
						$data = [
							'profile'	=> $member,
							'token' 	=> $token,
						];
						$this->__jsonResponse(200,'OK',$data);
					}
				}else{
					$this->__jsonResponse(404,'trouble',[]);
				}
			}else{
				$this->__jsonResponse(404,'password_incorrect',[]);
			}
		}else{
			$this->__jsonResponse(400,'request',[]);
		}
	}

	public function authFacebook(){
		$token = $_GET['token'];
		$type = $_GET['type'];
		$key  = (int)isset($_GET['key'])? intval($_GET['key']):0;
		if($key >2)
			$this->__jsonResponse(400,"input_not_valid");
		if($token && $type == 'facebook'){
		// 		$userData = array(); 
		// 		$userData['fb_id']    		= '12345977';
		// 		$userData['email']        	= 'lilmoi090978@gmail.com';
		// 		$userData['phone']        	= '04937336';
		// 		$first_name    	= 'Nguyễn';
		// 		$last_name    	= 'Mạnh';
		// 		$userData['fullname']       =  $first_name ." ".$last_name;
		// 	$rs = $this->member_model->auth_facebook($userData,$key );
		// 	if($rs['code']== 1){
		// 		$member = $this->member_model->get_detail_member($rs['data']);
		// 		$token = $this->__returnToken($member);		
		// 		$data = [
		// 			'profile'	=> $member,
		// 			'token' 	=> $token,
		// 		];
		// 			$this->__jsonResponse(200,"success",$data);
		// 	}

		// 	if($rs['code']== 2){
		// 		$this->__jsonResponse(400,"request_already");
		// 	}

		// 	if($rs['code'] == 3 && in_array($key, ['1','2'])){
		// 		if($key == 1){
		// 			$rs = $this->member_model->update_id($userData);
		// 			if($rs['code'] == 1)
		// 			$member = $this->member_model->get_detail_member($rs['data']);
		// 			$token = $this->__returnToken($member);		
		// 			$data = [
		// 				'profile'	=> $member,
		// 				'token' 	=> $token,
		// 			];
		// 				$this->__jsonResponse(200,"success",$data);
		// 		$this->__jsonResponse(404, 'notfound');

		// 		}
		// 		if($key == 2){
		// 			$this->__jsonResponse(400,"an_error_has_occurred");
		// 		}
		//    }

		//    if($rs['code'] == 3){
		// 		$this->__jsonResponse(500,"synchronizing_documents");
		//    }
			/* Authenticate user with facebook */
			// if($this->facebook->is_authenticated()){ 
			/* Get user info from facebook */
				$fbUser = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,link,gender,picture', $token); 
				var_dump($fbUser);die;
				/* Preparing data for database insertion */
				// $userData['oauth_provider'] = 'facebook'; 
				$userData['fb_id']    = !empty($fbUser['id'])?$fbUser['id']:'';; 
				$userData['first_name']    = !empty($fbUser['first_name'])?$fbUser['first_name']:''; 
				$userData['last_name']    = !empty($fbUser['last_name'])?$fbUser['last_name']:''; 
				$userData['email']        = !empty($fbUser['email'])?$fbUser['email']:'';

				$rs = $this->member_model->auth_facebook($userData);
				if($rs['code']== 1){
					$member = $this->member_model->get_detail_member($rs['data']);
					$token = $this->__returnToken($member);		
					$data = [
						'profile'	=> $member,
						'token' 	=> $token,
					];
					$this->__jsonResponse(200,"success",$data);
				}
				if($rs['code']== 2){
					$this->__jsonResponse(400,"request_already");
				}

				if($rs['code'] == 3 && in_array($key, ['1','2'])){
					if($key == 1){
						$rs = $this->member_model->update_id($userData);
						if($rs['code'] == 1)
						$member = $this->member_model->get_detail_member($rs['data']);
						$token = $this->__returnToken($member);		
						$data = [
							'profile'	=> $member,
							'token' 	=> $token,
						];
							$this->__jsonResponse(200,"success",$data);
					$this->__jsonResponse(404, 'notfound');

					}
					if($key == 2){
						$this->__jsonResponse(400,"an_error_has_occurred");
					}
				}

				if($rs['code'] == 3){
						$this->__jsonResponse(500,"synchronizing_documents");
				}
		// }
		// $this->__jsonResponse(404, 'notfound');
	}  
	$this->__jsonResponse(400, 'input_not_valid');
}

	public function authGoogle(){
		$token = $_GET['token'];
		$type = $_GET['type'];
		$key  = isset($_Get['key'])?$_Get['key']:0;
		if($token && $type == 'google'){
			$google_data=$this->google->validate($token);
			$data_gg=array(
					'gg_id'=>$google_data['id'],
					'name'=>$google_data['name'],
					'email'=>$google_data['email'],
					'phone'=>$google_data['phone'],
					// 'source'=>'google',
					// 'profile_pic'=>$google_data['profile_pic'],
					// 'link'=>$google_data['link'],
					// 'sess_logged_in'=>1
					);	
			var_dump($data_gg);die;   
		}
		$this->__jsonResponse(400, 'input_not_valid');
	}

	public function verificationCodes(){
		$email_post = $this->request['email'];
		if(!$email_post)
			$this->__jsonResponse(400,'request',[]);
		$rs = $this->member_model->check_email($email_post);
		if (!$rs){
			$this->__jsonResponse(404,'Do_not_exist',[]);
		}
		$key = $this->keyemail::instanceMethodOne();
		if(!$key){
			$this->__jsonResponse(500,'Do_not_exist',[]);
		}
		$data=$this->member_model->update_key_email($email_post,$key);
		if($data == TRUE){
			$email =$email_post;
			$name = $rs->fullname;
			$title = "Password Verification";
			$body = $key;
			$htmlContent = true;
			if ($this->my_phpmailer->send_mail($email, $name, $title, $body, $htmlContent)) {
				$this->__jsonResponse(200,'success');
			}			
		}
	}

	public function updatePassword(){
		$key				=(int) $this->request['key'];
		$password			= password_hash($this->request['password'], PASSWORD_DEFAULT);
		$password_confirm	= $this->request['password_confirm'];
		if(!empty($key) && !empty($password) && !empty($password_confirm)){
			$rs = $this->member_model->update_password($password,$key,$password_confirm);
			if( $rs == 1){
				$this->__jsonResponse(200, 'success');
			}
			if( $rs == 2){
				$this->__jsonResponse(404, 'an_error_has_occurred');
			}
			if( $rs == 3){
				$this->__jsonResponse(404, 'password_incorrect');
			}
			if( $rs == 4){
				$this->__jsonResponse(500, 'confirm_expiration_code');
			}
		}
		$this->__jsonResponse(400, 'input_not_valid');
	}

	public function listNotification(){
		$access_token = isset($_GET['access_token'])?$_GET['access_token']:"";
		if(!$access_token){
			$this->__jsonResponse(400, 'input_not_valid',[]);
		}
		$data_profile = $this->__getProfilebyToken($access_token);
		if($data_profile =='Expired token' ){
			$this->__jsonResponse(405, 'token_expires');
		}
		if($data_profile =='Signature verification failed' ){
			$this->__jsonResponse(406, 'token_false');
		}
		$member_id = $data_profile->id;
		if(!$member_id){
			$this->__jsonResponse(404, 'not_found');
		}
		$type = isset($_GET['type'])?$_GET['type']:null;
		$is_read = isset($_GET['is_read'])?$_GET['is_read']:null;
		$limit  = (int)isset($_GET['limit'])? intval($_GET['limit']) : 10;		
		$page  = (int)isset($_GET['page'])? intval($_GET['page']) : 1;  
		if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;
		$data = [
        	'pagination' => [
        		'page' => $page,
        		'limit' => $limit,
        		'prev' => ($page>1) ? $page-1 : 1,
        		'next' => false 
        	]
        ];
		$rs = $this->notification_model->list_notification($offset, $limit , $member_id, $is_read, $type);
		if(!$rs)
			$this->__jsonResponse(404, 'notfound');
		if(is_array($rs) && count($rs) > 0){
			foreach($rs as $key => $item){
				$item->type_name = lang($item->type);
				if($item->type == 'thong_bao_khuyen_mai')
					$item->image = getImageUrl('mdi_sale.png');
				if($item->type == 'thong_bao_he_thong')
					$item->image = getImageUrl('ant-design_notification-outlined.png');
				$rs[$key] = $item;
			}
		}
		$count= $this->notification_model->count_unread_notifications($member_id);
		$data['count'] = $count;
		$data['list'] = $rs;
		$data['pagination']['next'] = (count($rs)==$limit) ? $page+1 : false;
		$this->__jsonResponse(200, 'success',$data);
	}

	public function detailNotification(){
		$id = isset($_GET['id'])?intval($_GET['id']):null;
		if (! $id) 
			$this->__jsonResponse(400, 'input_not_valid',[]);
		$access_token = isset($_GET['access_token'])?$_GET['access_token']:"";
		if(!$access_token){
			$this->__jsonResponse(400, 'input_not_valid',[]);
		}
		$data_profile = $this->__getProfilebyToken($access_token);
		if($data_profile =='Expired token' ){
			$this->__jsonResponse(405, 'token_expires');
		}
		if($data_profile =='Signature verification failed' ){
			$this->__jsonResponse(406, 'token_false');
		}
		$member_id = $data_profile->id;
		if(!$member_id){
			$this->__jsonResponse(404, 'not_found');
		}
		$notify = $this->notification_model->detail_notification( $id, $member_id);

		if(!$notify)
			$this->__jsonResponse(404, 'notfound');
		$notify->type_name = lang($notify->type);
		$data = [];
		$data['detail_notification'] = $notify;
		$count= $this->notification_model->count_unread_notifications($member_id);
		$data['count'] = $count;
	$this->__jsonResponse(200, 'success', $data);		
}
	public function refreshToken(){
		$refresh_token = isset($_GET['refresh_token'])?$_GET['refresh_token']:"";
		if(!$refresh_token){
			$this->__jsonResponse(400, 'input_not_valid',[]);
		}
		$data = $this->__getProfilebyToken($refresh_token);
		if($data =='Expired token' ){
			$this->__jsonResponse(401, 'token_expires_and_login');
		}
		if($data =='Signature verification failed' ){
			$this->__jsonResponse(406, 'token_false');
		}
		$token = $this->__returnToken($data);		
		$this->__jsonResponse(200,'OK',$token);
	}


	public function changePassword(){
		$access_token = isset($_GET['access_token'])?$_GET['access_token']:"";
		if(!$access_token){
			$this->__jsonResponse(400, 'input_not_valid',[]);
		}
		$data_profile = $this->__getProfilebyToken($access_token);
		if($data_profile =='Expired token' ){
			$this->__jsonResponse(405, 'token_expires');
		}
		if($data_profile =='Signature verification failed' ){
			$this->__jsonResponse(406, 'token_false');
		}
		$member_id = $data_profile->id;
		if(!$member_id)
		$this->__jsonResponse(404, 'not_found');
		$data = array();
		$data['id']                   			=$member_id;
		$data['password_old']	 				= $this->request['password_old'];
		$data['password'] 						= password_hash($this->request['password'], PASSWORD_DEFAULT);
		$data['password_confirm'] 				= $this->request['password_confirm'];
		if(password_verify($data['password_old'], $data['password'])){
			$this->__jsonResponse(500,'used_password');
		}
		$change_password = $this->member_model->change_password($data);
		if($change_password['code']==1)
			$this->__jsonResponse(200,'success');
		if($change_password['code']==2)
			$this->__jsonResponse(404,'password_incorrect');
		if($change_password['code']==3)
			$this->__jsonResponse(400,'an_error_has_occurred');

	}

	function changeAvatar(){
		$access_token = isset($_GET['access_token'])?$_GET['access_token']:"";
		if(!$access_token){
			$this->__jsonResponse(400, 'input_not_valid',[]);
		}
		$data_profile = $this->__getProfilebyToken($access_token);
		if($data_profile =='Expired token' ){
			$this->__jsonResponse(405, 'token_expires');
		}
		if($data_profile =='Signature verification failed' ){
			$this->__jsonResponse(406, 'token_false');
		}
		$member_id = $data_profile->id;
		if(!$member_id)
		$this->__jsonResponse(404, 'not_found');
		$filename = md5(uniqid(rand(), true));
		$config = array(
			'upload_path' => 'uploads',
			'allowed_types' => "gif|jpg|png|jpeg",
			'file_name' => $filename
		);	
		$rs=$this->load->library('upload', $config);
		if($this->upload->do_upload('avatar'))
			{
			$file_data = $this->upload->data();
			$data_image = $file_data['file_name'];
			$rs =$this->member_model->save_image($data_image, $member_id);
			if($rs['code'] == 1){
				$data = getImageUrl($data_image);
				$this->__jsonResponse(200, 'success', $data);
			}
			if($rs['code'] == 2){
				$this->__jsonResponse(400, 'an_error_has_occurred');
			}		
			}
		}
}
