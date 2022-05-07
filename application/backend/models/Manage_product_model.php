<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Manage_product_model extends MY_Model {

	protected $_table_name = 'real_news';
	protected $_table_member_news = 'member_news';
	protected $_primary_key = 'id';
	protected $_order_by = 'id DESC';
	protected $_data_type = [
		'id' => 'int',
		'price' => 'int',
		'rent_price_hour' => 'int',
		'slugname' => 'int',
		'title' => 'int',
		'intro' => 'int',
		'content' => 'int',
		'point' => 'int',
		'created_by' => 'int',
		'bedroom_number' => 'int',
		'floor_number' => 'int',
		'acreage' => 'int',
		'member_id' => 'int'
	];
	
	public $rules = [
		'title'            => array(
            'field'   => 'title',
            'rules'   => 'trim|max_length[100]|required' ),
        'intro'           => array(
            'field'   => '	intro',
            'rules'   => 'trim|max_length[500]' ),     
        'content' => array(
            'field'   => 'content',
            'rules'   => 'trim|max_length[500]' ),   
        'category_id' => array(
            'field'   => 'category_id',
            'rules'   => 'trim|max_length[250]' ),   
        'price'     => array(
            'field'   => 'price',
            'rules'   => 'trim|max_length[250]' ),  
		'status'        => array(
			'field'   => 'status',
			'rules'   => 'trim'
		),  
		'is_public' => array(
			'field'   => 'is_public',
			'rules'   => 'intval'
		)
	];

	const STATUS_HOATDONG = 'public';
	const STATUS_TAMKHOA = 'block';
	const STATUS_DAXOA = 'delete';
	protected $allStatus = [
		self::STATUS_HOATDONG => [
			'name' => 'Hoạt động',
		],
		self::STATUS_TAMKHOA => [
			'name' => 'Tạm khóa',
		],
		self::STATUS_DAXOA => [
			'name' => 'Đã xóa',
		]
	];



	public function __construct()
	{
		parent::__construct();
	}

	// public function publishPrice()
	// {
	// 	return range(10, 100, 10);
	// }

	public function getStatus($status='')
	{
		return ($status) ? $this->allStatus[$status] : $this->allStatus;
	}

	public function getType($type='')
	{
		return ($type) ? $this->allType[$type] : $this->allType;
	}

	public function getService($service='')
	{
		return ($service) ? $this->allService[$service] : $this->allService;
	}

	public function getRentTime($time='')
	{
		return ($time) ? $this->rentTime[$time] : $this->rentTime;
	}

    // public function getListProduct()
    // {
    //     $query = $this->db->get($this->_table_name);
    //     return ($query->num_rows() > 0 ) ? $query->result_array() : null;
    // }

	// public function getCategory()
    // {
    //     $query = $this->db->get($this->_table_name['category_id']);
    //     return ($query->num_rows() > 0 ) ? $query->result_array() : null;
    // }
	
	// public function getList($limit=10, $offset=0){
	// 		$this->db->select('a.*, b.title AS category_name');
	// 		$this->db->from($this->_table_name . ' as a');
	// 		$this->db->join('category_products as b', 'a.category_id=b.id', 'left');
	// 		// if($category_id>0){
	// 		// 	$this->db->where('a.category_id',$category_id);
	// 		// }
	// 		$this->db->limit($limit, $offset);
	// 		$data = $this->db->get()->result();

	// 		return $data;


	//  	}
		 public function getList( $limit=10, $offset=0){
			$this->db->select('a.*, b.title AS category_name');
			$this->db->from($this->_table_name . ' as a');
			$this->db->join('category_products as b', 'a.category_id=b.id', 'left');
			$this->db->where('status', 'public');
			$this->db->or_where('status', 'block');
			$this->db->limit($limit, $offset);
			$data = $this->db->get();
			return $data;
	
	
		}
	// public function get_detail_product($id){
	// 	$this->db->select('a.*, b.title AS category_name');
	// 	$this->db->from($this->_table_name . ' as a');
	// 	$this->db->join('category_products as b', 'a.category_id=b.id', 'inner');
	// 	$this->db->where('a.id',$id);
	// 	$data = $this->db->get()->result();
	// 	return $data;
	// }

	

	public function dataGrid()
	{
		$post = $this->input->post();
		$offset = intval($post['start']);
		$limit = intval($post['length']);
		$where = [];
		if ($post['status'])
			$where['status'] = $post['status'];
		else
			$where['status !='] = self::STATUS_DAXOA;
		// if (@$post['service_type']) $where['service_type'] = $post['service_type'];
		if ($post['status']) $where['status'] = $post['status'];
		// if (@$post['is_public']) $where['is_public'] = $post['is_public'];
		if (@$post['category_id']) $where['category_id'] = $post['category_id'];
		if ($post['keyword']) {
			if (preg_match('/^0[1-9][0-9]{8,9}$/',$post['keyword'])) 
				$where['owner_phone'] = $post['keyword'];
			elseif (preg_match('/^[a-zA-Z0-9]*$/',$post['keyword'])) 
				$where['code'] = $post['keyword'];
			else
				$where["title LIKE '%".$post['keyword']."%'"] = NULL;
		}

		$result = [
			'recordsTotal' => 0,
			'recordsFiltered' => 0,
			'data' => [],
		];

		#counter
		$this->db->select('COUNT(id) AS number');
		if ($where) $this->db->where($where);
		$counter = $this->get(null, true);

		if ($counter && $counter->number) {
			$result['recordsFiltered'] = $result['recordsTotal'] = intval($counter->number);

			$this->db->select('*');
			$this->db->from($this->_table_name);
			if ($where) $this->db->where($where);
			$this->db->order_by('id', 'desc');
			$this->db->limit($limit, $offset);
			$result['data'] = $this->db->get()->result_array();
			if ($result['data']) {
				$authors = [];
				foreach ($result['data'] as $key => $value) {
					if (! in_array($value['created_by'], array_keys($authors))) {
						$user = (array)$this->user_model->get(intval($value['created_by']));
						unset($user['password']);
						unset($user['level']);
						unset($user['status']);
						unset($user['intro']);
						$authors[$value['created_by']] = $user;
					}
					$author = $authors[ $value['created_by'] ];
					$value['created_by_user'] = $author;
					$value['category_id'] = intval($value['category_id']);
					$value['thumbnail'] = getImageUrl($value['thumbnail']);
					$value['status_name'] = $this->allStatus[ $value['status'] ]['name'];
					// $value['type_name'] = $this->allType[ $value['type'] ]['name'];
					// $value['service_type_name'] = implode(', ', $this->getServiceName($value['service_type']));
					// $value['price_name'] = doubleval($value['price']/TYDONG) . ' tỷ';
					// $value['rent_price_hour_name'] = $value['rent_price_hour']/TRIEUDONG . ' tr';
					// $value['rent_price_day_name'] = $value['rent_price_day']/TRIEUDONG . ' tr';
					// $value['rent_price_month_name'] = $value['rent_price_month']/TRIEUDONG . ' tr';
					$result['data'][$key] = $value;
				}
			}
		}
		
		return $result;
	}

	// public function getNew()
	// {
	// 	$data = parent::getNew();
	// 	$data->status = self::STATUS_CON;

	// 	$data->service_type = self::SEVICE_MUABAN;
	// 	$data->service_time = date('Y-m-d H:i:s');
	// 	$data->price = 0;
	// 	$data->rent_price_hour = 0;
	// 	$data->rent_price_day = 0;
	// 	$data->rent_price_month = 0;
	// 	return $data;
	// }

	public function getServiceName($service_type)
	{
		$serviceType = json_decode($service_type, true);
		$service_type_name = [];
		if ($serviceType) {
			foreach ($serviceType as $key => $value) {
				$service_type_name[]= $this->getService($value)['name'];
			}
		}
		return $service_type_name;
	}

	public function getRentTimeName($rent_time)
	{
		$rent_time_name = [];
		if ($rent_time) {
			$rentTime = json_decode($rent_time, true);
			foreach ($rentTime as $key => $value) {
				$rent_time_name[]= $this->rentTime[$value]['name'];
			}
		}
		return $rent_time_name;
	}

	public function getPublicNewsByCode($code)
	{
		$news = $this->get_by(['code' => $code, 'is_public' => 1], true);
		if (! $news) 
			return false;
		$news->type_name = $this->getType($news->type)['name'];
		// $news->service_type_name = $this->getService($news->service_type)['name'];
		
		$serviceType = json_decode($news->service_type, true);
		$news->service_type_name = $this->getServiceName($news->service_type);
		$news->rent_time_name = $this->getRentTimeName($news->rent_time);
		$news->province = $this->location_model->getProvince($news->province_id);
		$news->district = $this->location_model->getDistrict($news->district_id);
		$news->url = linkToDetailRealNews($news->slugname, $news->code);
		$news->thumbnail_url = ($news->thumbnail) ? getImageUrl($news->thumbnail) : getImageUrl(siteOption('og_image'));
		

		return $this->setData($news, true);
	}

	// public function getNewsByCode($code)
	// {
	// 	return $this->get_by(['code' => $code], true);
	// }

	// public function checkNewsBought($newsId, $memberId, $session)
	// {
	// 	$where = [
	// 		'news_id' => $newsId,
	// 		'member_id' => $memberId,
	// 		'session_id' => $session
	// 	];
	// 	$isBought = $this->db->get_where($this->_table_member_news, $where, 1)->row();
	// 	return ($isBought) ? $isBought : null;
	// }

	public function newsUnBoughtFilter($news)
	{
		$isArray = is_array($news);
		if ($isArray) 
			$news = json_decode(json_encode($news));

		$news->content = '';
		// $news->intro = '';
		$news->owner_phone = hidePhone($news->owner_phone);
		$news->owner_name = '*** ' . @array_pop(explode(' ', $news->owner_name));
		$news->address = '*** *** ***, ' . $news->province->name;

		return ($isArray) ? toArray($news) : $news;
	}

	public function getListNews($request)
	{
		$filter = [
			'limit' => 10,
			'offset' => 0,
			'type' => null,
			'service_type' => null,
			'province_id' => 0,
			'district_id' => 0,
		];

		$filter = array_merge($filter, array_filter($request));
		$page = (intval($filter['page'])) ? abs(intval($filter['page'])) : 1;
		$per_page = (intval($filter['per_page'])) ? abs(intval($filter['per_page'])) : 10;
		$fitler['offset'] = ($page - 1) * $per_page;
		$fitler['limit'] = $per_page;
		$filter['province_id'] = intval($filter['province_id']);
		$filter['district_id'] = intval($filter['district_id']);
		$filter['service_type'] = trim(strtolower($filter['service_type']));
		$filter['type'] = trim(strtolower($filter['type']));
		$where = [
			'is_public' => 1
		];
		if (@$filter['type']) $where['type'] = $filter['type'];
		if (@$filter['service_type']) $where['service_type LIKE \'%"'. $filter['service_type'] .'"%\''] = null;
		if (@$filter['province_id']) $where['province_id'] = $filter['province_id'];
		if (@$filter['district_id']) $where['district_id'] = $filter['district_id'];
		if (@$filter['address']) $where["address LIKE '%".$filter['address']."%'"] = null;
		if (@$filter['number']) $where["bedroom_number"] = intval($filter['number']);
		if ($filter['service_type'] && @$filter['price_range']) {
			# xét khoảng giá
			// if ($service = @$this->getService($filter['service_type'])) {
			// 	$priceRange = explode(' - ', $service['price_range_value'][$filter['price_range']]);
			// 	if ($filter['service_type']==self::SEVICE_MUABAN) {
			// 		$where['price >='] = intval($priceRange[0]);
			// 		$where['price <='] = intval($priceRange[1]);
			// 	} 
			// 	else {
			// 		$where['rent_price_month >='] = intval($priceRange[0]);;
			// 		$where['rent_price_month <='] = intval($priceRange[1]);
			// 	}
			// }
		}

		$this->db->where($where);
		$this->db->limit($filter['limit'], $filter['offset']);
		$this->db->order_by('id desc');
		$data = $this->db->get($this->_table_name)->result();
		if (!$data) 
			return null;

		foreach ($data as $key => $news) {
			$news->content = null;
			$news->type_name = $this->getType($news->type)['name'];
			$serviceType = json_decode($news->service_type, true);
			$news->service_type_name = $this->getServiceName($news->service_type);
			$news->rent_time_name = $this->getRentTimeName($news->rent_time);
			$news->province = $this->location_model->getProvince($news->province_id);
			$news->district = $this->location_model->getDistrict($news->district_id);
			$news->url = linkToDetailRealNews($news->slugname, $news->code);
			$news->thumbnail_url = ($news->thumbnail) ? getImageUrl($news->thumbnail) : getImageUrl(siteOption('og_image'));
			
			$data[$key] = ($news) ? $this->setData( $this->newsUnBoughtFilter($news) , true) : null;
		}
		return $data;
	}

	// public function setData($news, $isObjec=true)
	// {
	// 	$news = parent::setData($news, true);
	// 	$news->price_sort = sortMoney(intval($news->price));
	// 	$news->rent_price_hour_sort = sortMoney(intval($news->rent_price_hour));
	// 	$news->rent_price_day_sort = sortMoney(intval($news->rent_price_day));
	// 	$news->rent_price_month_sort = sortMoney(intval($news->rent_price_month));
	// 	return $news;
	// }

	public function updateRentStatus()
	{
		# trước ngày ngày hết hạn cho thuê 60 ngày: status=sapcon
		$this->db->set('status', self::STATUS_DAXOA);
		// $this->db->like('service_type', '"'.self::SEVICE_CHOTHUE.'"');
		$this->db->where('status', self::STATUS_TAMKHOA);
		$this->db->where('rent_enddate IS NOT NULL', null);
		$this->db->where('rent_price_month IS NOT NULL', null);
		$this->db->where('rent_enddate <= DATE_ADD( DATE(NOW()), INTERVAL 60 DAY )', null);
		$this->db->update($this->_table_name);

		# quá ngày hết hạn cho thuê: status=con
		$this->db->set('status', self::STATUS_HOATDONG);
		// $this->db->like('service_type', '"'.self::SEVICE_CHOTHUE.'"');
		$this->db->where('status', self::STATUS_DAXOA);
		$this->db->where('rent_enddate IS NOT NULL', null);
		$this->db->where('rent_price_month IS NOT NULL', null);
		$this->db->where('rent_enddate < DATE(NOW())', null);
		$this->db->update($this->_table_name);
	}

	public function removeNews($id)
	{
		$this->db->where('id', $id);
		$this->db->delete($this->_table_name);
	}
    public function updateStatus($ids,$status) {
        $this->db->where_in('id',$ids);
        $args = array('status' => $status);
        if($this->db->update($this->_table_name,$args)) {
            return true;
        }
        return false;
    }

}

/* End of file Realnews_model.php */
/* Location: ./application/backend/models/Realnews_model.php */