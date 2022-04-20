<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//require_once APPPATH . 'third_party/vendor/autoload.php';
use Facebook\Facebook; 
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

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
		$this->load->model('init_model');
		$this->load->model('partner_model');
		$this->load->model('fieldActivity_model');
		$this->load->model('categoryproducts_model');

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
	public function __jsonResponse($code=200, $msg='success', $data=[])
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
		$limit  = (int)isset($_GET['limit'])?$_GET['limit']:10;		
		$page  = (int)isset($_GET['page'])?$_GET['page']:1;        
        $offset = ($page - 1) * $limit;
        $type = isset($_GET['type'])?$_GET['type']:"";
		if (!isset($_GET['type'])){
			$this->__jsonResponse(400, $this->lang->line('input_not_valid'));
        }

        $rs = $this->banner_model->get_list_banners($offset, $limit ,$type);				
		$banners = [];

		if(is_array($rs) && count($rs) > 0){
			foreach($rs as $item){
				switch($item->type){
					case 2:
						$type = $this->lang->line('slideshow');
						break;
					case 1:
					default:	
						$type = $this->lang->line('banner');
						break;	
				}
				$banners[] = [
					'id' 	=> $item->id,
					'name'  => $item->name,
					'image' => $this->config->item('UPLOAD_DOMAIN').$item->image,
					'type'  => $type,
					'url' 	=> $item->url,
				];
			}
		}		
		        
        if($banners){
			$this->__jsonResponse(200, 'success',$banners);			
        }else{
			$this->__jsonResponse(500, $this->lang->line('do_not_exist'),[]);			
        }
	}
	public function appInit()
	{
		$rs = $this->banner_model->get_list_banners(0, 3 ,2);
		if(is_array($rs) && count($rs) > 0) {
			foreach($rs as $item){
				$slider[] = [
					'image' 	=> $item->image,
					'order'  	=> $item->order,
				];
			}
		}
		$data = $this->init_model->get_app_init();
		$settings = [];
		if(is_array($data) && count($data) > 0) {
			foreach($data as $item){				
				$settings[$item->name] =$item->value;	
			}
		}   

		$sliders = $this->banner_model->get_list_banners(0, 3 ,2);
		$data = [
			'siteOptions' => $settings,
			'slider' => $sliders
		];

		$this->__jsonResponse(200, 'success', $data);
	}
	public function listPartner() {
		$limit  = (int)isset($_GET['limit'])?$_GET['limit']:10;		
		$page  = (int)isset($_GET['page'])?$_GET['page']:1;        
        $offset = ($page - 1) * $limit;
		$rs = $this->partner_model->get_list_partner($offset, $limit );
		if(is_array($rs) && count($rs) > 0){
			foreach($rs as $item){
				$list_partner[] = [
					'id' 			=> $item->id,
					'name'  		=> $item->name,
					'image' 		=> $this->config->item('UPLOAD_DOMAIN').$item->image,
					'url' 			=> $item->url,
				];
			}
		}
		if($rs){
			$this->__jsonResponse(200,$this->lang->line('lisst'),$list_partner);			
        }else{
			$this->__jsonResponse(500, $this->lang->line('do_not_exist'),[]);			
        }
	}
	public function detailPartner() {				
		$id = isset($_GET['id'])?$_GET['id']:"";
		if(isset($_GET['id'])){
			$rs = $this->partner_model->get_detail_partner($id);
			if(is_array($rs) && count($rs) > 0){
				foreach($rs as $item){
					$partner[] = [
						'id' 					=> $item->id,
						'name'  				=> $item->name,
						'image' 				=> $this->config->item('UPLOAD_DOMAIN').$item->image,
						'url' 					=> $item->url,
						'description' 			=> $item->description,
						'content' 				=> $item->content,
						'email' 				=> $item->email,
						'phone' 				=> $item->phone,
						'address' 				=> $item->address,
					];
				}
			}
			if($rs){
				$this->__jsonResponse(200,$this->lang->line('detail'),$partner);			
			}else{
				$this->__jsonResponse(500, $this->lang->line('do_not_exist'),[]);			
			}
		}else{
			$this->__jsonResponse(400, $this->lang->line('input_not_valid'),[]);
		}
	}
	public function listPost() {
		$limit  = (int)isset($_GET['limit'])?$_GET['limit']:10;		
		$page  = (int)isset($_GET['page'])?$_GET['page']:1;        
        $offset = ($page - 1) * $limit;
        $category = isset($_GET['category'])?$_GET['category']:"";
		$is_hot = isset($_GET['is_hot'])?$_GET['is_hot']:"";
		
		if (!isset($_GET['category'])){
			$this->__jsonResponse(400, $this->lang->line('input_not_valid'));
		}
        $rs = $this->post_model->get_list_post($offset, $limit ,$category,$is_hot);				
		$list_post = [];
		
		if(is_array($rs) && count($rs) > 0){
			foreach($rs as $item){
				switch($item->category){
					case 2:
						$category = $this->lang->line('achievements');
						break;
					case 1:
					//default:	
						$category = $this->lang->line('news');
						break;	
					}
					$list_post[] = [
					'id' 			=> $item->id,
					'name'  		=> $item->title,
					'image' 		=> $this->config->item('UPLOAD_DOMAIN').$item->thumbnail,
					'category '  	=> $category,
					'url' 			=> $item->url,
				];
			}
		}		
		if(isset($_GET['is_hot'])){
			if($rs){		
				$this->__jsonResponse(200, $this->lang->line('list_new_hot'),$list_post);
			}else{
				$this->__jsonResponse(500, $this->lang->line('news_not_exist'),[]);			
			}
		}       
        if($rs){
			$this->__jsonResponse(200, $this->lang->line('list')." ".$category,$list_post);			
        }else{
			$this->__jsonResponse(500, $this->lang->line('news_not_exist'),[]);			
        }
	}
	public function detailPost() {				
		$id = isset($_GET['id'])?$_GET['id']:"";
		if(isset($_GET['id'])){
			$rs = $this->post_model->get_detail_post($id);
			$post = [];
		
			if(is_array($rs) && count($rs) > 0){
				foreach($rs as $item){
					switch($item->category){
						case 2:
							$category = $this->lang->line('achievements');
							break;
						case 1:
						//default:	
							$category = $this->lang->line('news');
							break;	
						}
						$post[] = [
						'id' 			=> $item->id,
						'name'  		=> $item->title,
						'image' 		=> $this->config->item('UPLOAD_DOMAIN').$item->thumbnail,
						'category '  	=> $category,
						'url' 			=> $item->url,
					];
				}
			}
			if($rs){
				$this->__jsonResponse(200, $this->lang->line('detail'),$post);			
			}else{
				$this->__jsonResponse(500, $this->lang->line('news_not_exist'),[]);			
			}
		}else{
			$this->__jsonResponse(400, $this->lang->line('input_not_valid'),[]);
		}
	}
	public function listProducts() {
		$limit  = (int)isset($_GET['limit'])?$_GET['limit']:10;		
		$page  = (int)isset($_GET['page'])?$_GET['page']:1;        
        $offset = ($page - 1) * $limit;
        $category_id = isset($_GET['category_id'])?$_GET['category_id']:"";
		
		if (!isset($_GET['category_id'])){
			$this->__jsonResponse(400, $this->lang->line('input_not_valid'));
		}
        $rs = $this->products_model->get_list_products($limit, $offset, $category_id);				
		$list_prd = [];
		
		if(is_array($rs) && count($rs) > 0){
			foreach($rs as $item){
					switch($item->	status){
						case "con":
							$status = $this->lang->line('still');
							break;
						case "het":
							$status = $this->lang->line('over');
							break;
						case "sap":
							$status = $this->lang->line('coming_soon');
							break;
						case "khac":	
							$status = $this->lang->line('other');
							break;	
						}

					$list_prd[] = [
					'id' 				=> $item->id,
					'name'  			=> $item->	title,
					'slugname'  		=> $item->	slugname,
					'intro'  			=> $item->	intro,
					'content'  			=> $item->	content,
					'category_name' 	=> $item->category_name,
					'status'  			=> $status,
					'image' 			=> $this->config->item('UPLOAD_DOMAIN').$item->thumbnail,
					'type' 				=> $item->type,
					'service_type' 		=> $item-> service_type,
					'url' 				=> $item->url,
				];
			}
		}		
		        
        if($list_prd){
			$this->__jsonResponse(200, 'success',$list_prd);			
        }else{
			$this->__jsonResponse(500, $this->lang->line('do_not_exist'),[]);			
        }
	}

	public function detailProduct() {				
		$id = isset($_GET['id'])?$_GET['id']:"";
		if(isset($_GET['id'])){
			$rs = $this->products_model->get_detail_product($id);
			if(is_array($rs) && count($rs) > 0){
				foreach($rs as $item){
						switch($item->	status){
							case "con":
								$status = $this->lang->line('still');
								break;
							case "het":
								$status = $this->lang->line('over');
								break;
							case "sap":
								$status = $this->lang->line('coming_soon');
								break;
							case "khac":	
								$status = $this->lang->line('other');
								break;	
							}
	
						$product[] = [
						'id' 				=> $item->id,
						'name'  			=> $item->	title,
						'slugname'  		=> $item->	slugname,
						'intro'  			=> $item->	intro,
						'content'  			=> $item->	content,
						'category_name' 	=> $item->category_name,
						'status'  			=> $status,
						'image' 			=> $this->config->item('UPLOAD_DOMAIN').$item->thumbnail,
						'type' 				=> $item->type,
						'service_type' 		=> $item-> service_type,
						'url' 				=> $item->url,
					];
				}
			}	
			if($rs){
				$this->__jsonResponse(200, $this->lang->line('detail'),$product);			
			}else{
				$this->__jsonResponse(500,$this->lang->line('do_not_exist'),[]);			
			}
		}else{
			$this->__jsonResponse(400, $this->lang->line('input_not_valid'),[]);
		}
	}
	public function fieldActivity(){
		$limit  = (int)isset($_GET['limit'])?$_GET['limit']:10;		
		$page  = (int)isset($_GET['page'])?$_GET['page']:1;        
        $offset = ($page - 1) * $limit;
		$rs = $this->fieldActivity_model->get_list_field($offset, $limit);
		if(is_array($rs) && count($rs) > 0){
			foreach($rs as $item){
				$field[] = [
					'id' 			=> $item->id,
					'name'  		=> $item->name,
					'image' 		=> $this->config->item('UPLOAD_DOMAIN').$item->image,
					'url' 			=> $item->url,
				];
			}
		}
		if($rs){
			$this->__jsonResponse(200, 'success',$field);
		}else{
			$this->__jsonResponse(500, $this->lang->line('do_not_exist'),[]);
		}
		
	}
	public function categoryProducts(){
		$limit  = (int)isset($_GET['limit'])?$_GET['limit']:10;		
		$page  = (int)isset($_GET['page'])?$_GET['page']:1;        
        $offset = ($page - 1) * $limit;
		$rs = $this->categoryproducts_model->get_list_category_products($offset, $limit);
		if(is_array($rs) && count($rs) > 0){
			foreach($rs as $item){
				$category_prd[] = [
					'id' 					=> $item->id,
					'name'  				=> $item->title,
					'image' 				=> $this->config->item('UPLOAD_DOMAIN').$item->image,
					'description' 			=> $item->description,
				];
			}
		}
		if($rs){
			$this->__jsonResponse(200, 'success',$category_prd);
		}else{
			$this->__jsonResponse(500,$this->lang->line('do_not_exist'),[]);
		}
	}
	public function  getProfile(){
		$id = isset($_GET['id'])?$_GET['id']:"";
		if(!isset($_GET['id'])){
			$this->__jsonResponse(400, $this->lang->line('input_not_valid'));
		}
		$profile = $this->member_model->get_detail_member($id);
		if($profile){
			$this->__jsonResponse(200, $this->lang->line('detail'),$profile);
		}else{
			$this->__jsonResponse(500,$this->lang->line('do_not_exist'),[]);
		}

	}
	public function updateProfile(){
		$profile = array();
		$id = isset($_GET['id'])?$_GET['id']:"";
        $profile['fullname'] = $this->request['fullname'];
        $profile['email'] 	= $this->request['email'];
        $profile['phone'] 	= $this->request['phone'];
        $profile['addres'] 	= $this->request['addres'];
		if(!isset($_GET['id'])){
			$this->__jsonResponse(400, $this->lang->line('input_not_valid'));
		}
		if(!empty( $profile['email']) && !empty( $profile['phone']) && !empty( $profile['fullname']) && !empty( $profile['addres'])){
			$my_profile= $this->member_model->update_profile($profile,$id);
			if($my_profile){
				if($my_profile == 1){
					$this->__jsonResponse(401,$this->lang->line('request_already'),[]);
				}else{
					$profile_new = $this->member_model->get_detail_member($id);
					$this->__jsonResponse(200,$this->lang->line('success'),$profile_new);
				}
			}else{
				$this->__jsonResponse(500,$this->lang->line('trouble'),[]);
			}
		}else{
			$this->__jsonResponse(400,$this->lang->line('request'),[]);
		}
	}
	public function loginForm(){
		$memberData = array();
        $memberData['email'] = $this->request['email'];
        $memberData['phone'] = $this->request['phone'];
        $memberData['password'] = $this->request['password'];
		if(!empty( $memberData['email']) && !empty( $memberData['phone'])){
			$login_form= $this->member_model->login_form($memberData);
			if($login_form){
				$this->__jsonResponse(200,$this->lang->line('success'),$login_form);
			}else{
				$this->__jsonResponse(500,$this->lang->line('trouble'),[]);
			}
		}else{
			$this->__jsonResponse(400,$this->lang->line('request'),[]);
		}
	}
	public function registrationForm(){
		$memberData = array();
        $memberData['email'] 			= $this->request['email'];
        $memberData['phone'] 			= $this->request['phone'];
        $memberData['password'] 		= $this->request['password'];
        $memberData['password_confirm'] = $this->request['password_confirm'];
        $memberData['department_id'] 	= $this->request['department_id'];
        $memberData['url_fb'] 			= $this->request['url_fb'];
		if(!empty( $memberData['email']) && !empty( $memberData['phone']) && !empty($memberData['password']) && !empty($memberData['password_confirm'])){
			if ($memberData['password'] == $memberData['password_confirm'] ){
				$memberData['password'] = password_hash($memberData['password'], PASSWORD_DEFAULT);
				$registration_form= $this->member_model->registration_form($memberData);
				if($registration_form){
					if($registration_form == 1){
						$this->__jsonResponse(401,$this->lang->line('request_already'),[]);
					}else{
						$data= $this->member_model->get_detail_member($registration_form);
						$this->__jsonResponse(200,$this->lang->line('Ok'),$data);
					}
				}else{
					$this->__jsonResponse(500,$this->lang->line('trouble'),[]);
				}
			}else{
				$this->__jsonResponse(401,$this->lang->line('password_incorrect'),[]);
			}
		}else{
			$this->__jsonResponse(400,$this->lang->line('request'),[]);
		}
	}  
 
}
