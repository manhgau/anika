<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public $data;
	public $me;

	public function __construct()
	{
		parent::__construct();
		$this->load->model('member_model');
		$this->load->model('postrequest_model');
		$this->load->model('pointload_model');
		$this->load->model('pointrefund_model');
		$this->load->model('realnews_model');
		$this->load->model('banner_model');

		$this->data = [];
		if ($this->session->userdata('user_login')) {
			$fbId = $this->session->userdata('fb_id');
			$this->me = $this->member_model->getMemberByFbId($fbId);
			$this->me->session_id = $this->session->userdata('user_session_id');
		}
		else
			$this->me = null;
	}

	public function index()
	{
		$this->data['subView'] = 'home/index';
		$this->data['subJs'] = true;
		$this->load->view('home/_layout_main', $this->data);
	}

	public function newsDetail($slugname, $code)
	{
		$news = toArray($this->realnews_model->getPublicNewsByCode($code));
		$news['is_bought'] = true;
		if (!$this->me || !$this->realnews_model->checkNewsBought($news['id'], $this->me->id, $this->me->session_id)) {
			$news = $this->realnews_model->newsUnBoughtFilter($news);
			$news['is_bought'] = false;
		}
		$this->data['news'] = $news;

		$this->data['code'] = $code;
		$this->data['subView'] = 'news/detail';
		$this->data['subJs'] = true;
		$this->load->view('home/_layout_main', $this->data);
	}

	public function apis($action)
	{
		$fnc = '__' . $action;
		$this->$fnc();
	}

	public function fbLogin()
	{
		$id = $this->input->post('uid');
		$name = $this->input->post('name');
		$member = $this->member_model->fbLogin($id);
	}

	private function __checkAuth()
	{
		if ($this->me) {
			$data = [
				'me' => $this->me,
				'user_nav' => $this->load->view('home/block/user-nav', $this->me, true)
			];
			$this->jsonResponse(200, 'success', $data);
		}
		else
			$this->jsonResponse(401, lang('not_login'));
	}

	private function __getNews()
	{
		$code = $this->input->post('code');
		$news = toArray($this->realnews_model->getPublicNewsByCode($code));
		if (! $news) 
			$this->jsonResponse(404, 'Bài viết không tồn tại');

		# nếu user chưa đăng nhập, hoặc chưa mua bài viết thì ẩn bớt thông tin
		$hidenInfo = false;
		if (!$this->me || !$this->realnews_model->checkNewsBought($news['id'], $this->me->id, $this->me->session_id)) {
			$hidenInfo = true;
		}

		if ($hidenInfo) 
			$news = $this->realnews_model->newsUnBoughtFilter($news);

		$this->jsonResponse(200, 'success', ['news' => $news]);
	}

	private function __buyNews()
	{
		if (! $this->me)
			$this->jsonResponse(401, lang('not_login'));

		$code = $this->input->post('code');
		$news = toArray($this->realnews_model->getPublicNewsByCode($code));
		if (! $news) 
			$this->jsonResponse(404, 'Bài viết không tồn tại');
		
		$news['province'] = $this->location_model->getProvince($news['province_id']);

		# check bought
		if ($this->me && $this->realnews_model->checkNewsBought($news['id'], $this->me->id, $this->me->session_id)) {
			$this->jsonResponse(200, 'success', ['news' => $news, 'me' => $this->me]);
		}

		if ($this->me->point < $news['point']) 
			$this->jsonResponse(404, 'Số Điểm hiện có không đủ. Vui lòng nạp Điểm để tiếp tục.');

		# trừ điểm
		// $type = 'view';
		// $note = 'Xem bài viết ' . $news['title'];
		// $amount = 0 - intval($news['point']);
		// $detail = json_encode([
		// 	'news_id' => $news['id'],
		// 	'news_title' => $news['title'],
		// 	'point' => $news['point'],
		// ]);
		// if ($this->pointload_model->addPointLoad($amount, intval($this->me->id), $type, $note, $detail)) {
		
		if ($this->pointload_model->processBuyNews($news['code'], intval($this->me->id), intval($news['point']), intval($news['member_id']))) {
			$this->me->point = intval($this->me->point) - intval($news['point']);
			
			$this->db->insert('member_news', ['news_id' => $news['id'], 'member_id'=>$this->me->id, 'point' => $news['point'], 'session_id' => $this->me->session_id]);

			$this->jsonResponse(200, 'success', ['news' => $news, 'me' => $this->me]);
		}
		else
			$this->jsonResponse(500, 'Hệ thống bận', []);
	}

	private function __postRequest()
	{
		if (! $this->me)
			$this->jsonResponse(401, 'Vui lòng đăng nhập để tiếp tục');

		$url = $this->input->post('url');
		$point = intval($this->input->post('point'));
		$title = cleanInputString($this->input->post('title'));
		$owner_phone = cleanInputString($this->input->post('owner_phone'));
		$owner_name = cleanInputString($this->input->post('owner_name'));
		$address = cleanInputString($this->input->post('address'));
		$details = json_encode($this->input->post());
		
		$result = $this->postrequest_model->addRequest( intval($this->me->id), $title, $url, $point, $owner_phone, $owner_name, $address, $details );
		if ($result=='success') {
			$this->me->point -= $point;
			$this->jsonResponse(200, 'Gửi thành công. Bài viết của bạn sẽ được duyệt sau ít phút.', ['me' => $this->me]);
		}
		else
			$this->jsonResponse(500, lang($result), []);
	}

	private function __refundRequest()
	{
		if (! $this->me)
			$this->jsonResponse(401, lang('not_login'));

		$url = $this->input->post('url');
		$code = trim($this->input->post('code'));
		$note = cleanInputString($this->input->post('note'));

		$request = $this->pointrefund_model->addRequest( intval($this->me->id), $code, $url, $note ); 
		
		if ($request=='success') 
			$this->jsonResponse(200, 'success');
		elseif ($request=='system_busy') 
			$this->jsonResponse(500, 'Hệ thống bận');
		else
			$this->jsonResponse(400, lang($request));
	}

	private function __logout()
	{
		$this->session->sess_destroy();
		// session_regenerate_id(TRUE);
		$this->me = null;
		$this->jsonResponse(200, 'success', ['user_nav' => $this->load->view('home/block/user-nav', [], true)]);
	}

    public function __getListLocationByPrarent()
    {
        $parentId = $this->input->get_post('parent_id');
        $type = $this->input->get_post('type');
        $allowType = ['country', 'region', 'province', 'district', 'ward'];
        $locName = [
            'country'=>'Quốc gia', 
            'region' => 'Vùng miền', 
            'province' => 'Tỉnh/thành', 
            'district' => 'Quận/huyện', 
            'ward' => 'Xã/phường'
        ];

        if ( ! in_array($type, $allowType)) 
            $this->jsonResponse(400, 'Yêu cầu không hợp lệ');

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
            $this->jsonResponse(200, 'success', $data);
        }
        else
            $this->jsonResponse(200, 'data empty', NULL);
    }

	public function jsonResponse($code=200, $msg='success', $data=NULL)
    {
        $data = [
            'code' => $code,
            'msg' => $msg,
            'data' => $data
        ];
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }

	public function __checkSalePhone()
	{
		$chk = ['owner_phone' => $this->input->post('phone')];
		$already = $this->realnews_model->get_by($chk, true);
		if ($already) 
			$this->jsonResponse(201, lang('owner_phone_already'));
			
		$check = isNotSalePhone($this->input->post('phone'));
		$this->jsonResponse(($check=='success') ? 200 : 400, lang($check));
	}

}

/* End of file Home.php */
/* Location: ./application/backend/controllers/Home.php */