<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Postrequest_model extends MY_Model {

        protected $_table_name  = 'post_request';
        protected $_primary_key = 'id';
        protected $_order_by    = 'id DESC';
        public    $rules        = array ();

        const STATUS_SUCCESS = 'success';
        const STATUS_PENDING = 'pending';
        const STATUS_FAILED = 'failed';
        protected $allStatus = [
            self::STATUS_SUCCESS => [
                'name' => 'Thành công',
            ],
            self::STATUS_PENDING => [
                'name' => 'Chờ duyệt',
            ],
            self::STATUS_FAILED => [
                'name' => 'Thất bại',
            ],
        ];

        public function __construct(){
            parent::__construct();
        }

        public function getStatus($status='')
        {
            return ($status) ? $this->allStatus[$status] : $this->allStatus;
        }

        public function getStatusFilter($text='--- chọn ---')
        {
            return ['' => $text] + array_combine(array_keys($this->allStatus), array_column($this->allStatus, 'name'));
        }

        public function getNew()
        {
            $data = parent::getNew();
            $data->created_time = date('Y-m-d H:i:s');
            return $data;
        }

        public function dataGrid()
        {
            $post = $this->input->post();
            $offset = intval($post['start']);
            $limit = intval($post['length']);
            $where = [];
            if ($post['status']) $where['a.status'] = $post['status'];
            if ($post['from_date']) $where['DATE(a.created_time) >='] = date('Y-m-d', strtotime( str_replace('/', '-', $post['from_date']) ));
            if ($post['to_date']) $where['DATE(a.created_time) <='] = date('Y-m-d', strtotime( str_replace('/', '-', $post['to_date']) ));
            
            if ($post['keyword']) {
                if (filter_var($post['keyword'], FILTER_VALIDATE_EMAIL)) 
                    $where['u.email'] = strtolower($post['keyword']);
                elseif ($id = intval($post['keyword'])) 
                    $where['a.id'] = $id;
                elseif (preg_match('/^0[1-9][0-9]{8,9}/',$post['keyword'])) 
                    $where['u.phone'] = $post['keyword'];
            }

            $result = [
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
            ];

            #counter
            $this->db->select('COUNT(a.id) AS number');
            $this->db->from($this->_table_name . ' AS a');
            if ($post['keyword']) 
	            	$this->db->join('member AS u', 'a.member_id=u.id', 'inner');
            if ($where) $this->db->where($where);
            $counter = $this->db->get()->row();

            if ($counter && $counter->number) {
                $result['recordsFiltered'] = $result['recordsTotal'] = intval($counter->number);

                $this->db->select('a.*, u.fullname AS member_name, u.email AS member_email, u.phone AS member_phone');
	            $this->db->from($this->_table_name . ' AS a');
	            	$this->db->join('member AS u', 'a.member_id=u.id', 'inner');
	            if ($where) $this->db->where($where);
	            $this->db->order_by('a.id', 'desc');
                $this->db->limit($limit, $offset);
                $result['data'] = $this->db->get()->result_array();
                $answerBy = [];

                foreach ($result['data'] as $key => $value) {
                	$value['status_name'] = $this->allStatus[ $value['status'] ]['name'];
                	
                	if ($value['answer_by']) {
                		if (! isset($answerBy[ $value['answer_by'] ])) 
                			$answerBy[ $value['answer_by'] ] = $this->user_model->get( $value['answer_by'], true);

                		$answerUser = $answerBy[ $value['answer_by'] ];
                		$value['answer_by_name'] = $answerUser->name;
                		$value['answer_by_email'] = $answerUser->email;
                	}
                	else {
                		$value['answer_by_name'] = '';
                		$value['answer_by_email'] = '';
                	}

                	$result['data'][$key] = $value;

                }
            }
            return $result;
        }

        public function postProccess($id, $note, $status, $managerId)
        {
        	$request = $this->get($id, true);
        	if (!$request) 
        		return false;

        	if (! in_array($status, array_keys($this->allStatus))) 
        		return false;

        	$data = [
        		'answer_by' => $managerId,
        		'note' => $note,
        		'answer_time' => date('Y-m-d H:i:s'),
        		'status' => $status,
        	];
        	$this->save($data, $id);

        	if ($status==self::STATUS_FAILED) {
                # hoàn lại tiền
        		$this->load->model('pointload_model');
        		$refund = [
        			'member_id' => $request->member_id,
        			'amount' => $request->point,
        			'type' => 'refund',
        			'detail' => json_encode($request),
        			'note' => 'Hoàn Điểm do bài đăng bị từ chối: ' . $request->title,
        			'admin_id' => $managerId
        		];
        		$this->pointload_model->save($refund, null);
        	}
            elseif ($status==self::STATUS_SUCCESS && $request->details) {
                # tạo bài viết tự động
                $this->load->model('realnews_model');
                $news = json_decode($request->details, true);
                $news['request_id'] = $request->id;
                $news['fb_group_url'] = $news['url'];
                $news['fb_group_url'] = $news['url'];
                $news['title'] = '['.showUserId($request->member_id).'] ' . $request->title;
                $news['slugname'] = build_slug($request->title);
                $news['member_id'] = $request->member_id;
                $news['is_public'] = 0;
                unset($news['url']);
                $news['price'] *= TYDONG;
                $news['rent_price_day'] *= TRIEUDONG;
                $news['rent_price_hour'] *= TRIEUDONG;
                $news['rent_price_month'] *= TRIEUDONG;
                $news['sale_bonus'] *= TRIEUDONG;
                $news['service_type'] = [];
                if ($news['price']) $news['service_type'][] = $this->realnews_model::SEVICE_MUABAN;
                if ($news['rent_price_day'] || $news['rent_price_hour'] || $news['rent_price_month']) $news['service_type'][] = $this->realnews_model::SEVICE_CHOTHUE;
                $news['service_type'] = json_encode($news['service_type']);
                $news['created_by'] = $this->data['userdata']['id'];
                $news['code'] = 'RQ_' . str_replace('ID-', '', showUserId($request->id));
                $newsId = $this->realnews_model->save($news, null);
                $this->save(['realnews_id' => $newsId], $request->id);
            }

        	return true;
        }

        public function pendingNumber()
        {
        	$this->db->select('COUNT(id) AS number');
        	$data = $this->get_by(['status' => self::STATUS_PENDING], true);
        	return ($data) ? $data->number : 0;
        }

        public function addRequest(int $memberId, $title, $url, $point, $owner_phone, $owner_name, $address, $details)
        {
            $user = $this->member_model->get($memberId, true);
            if ($user->point < $point) 
                return 'your_point_not_enough';

            $data = [
                'member_id' => $memberId,
                'title' => $title,
                'url' => explode('?', $url)[0],
                'point' => $point,
                'owner_phone' => reformatPhoneNumber($owner_phone),
                'owner_name' => $owner_name,
                'address' => $address,
                'details' => $details,
                'status' => self::STATUS_PENDING,
            ];

            # check trùng địa chỉ
            if (@$arrDetails = json_decode($details, true)) {
                $provinceId = (@$arrDetails['province_id']) ? intval($arrDetails['province_id']) : 0;
                $districtId = (@$arrDetails['district_id']) ? intval($arrDetails['district_id']) : 0;
                if ($provinceId && $districtId) {
                    $chk = [
                        'province_id' => $provinceId,
                        'district_id' => $districtId,
                        'address' => $address,
                    ];

                    if ($already = @$this->get_by($chk, true)) {
                        return 'this_address_has_post';
                    }
                }
            }

            $where = [
                'url' => $data['url'],
                'member_id' => $memberId
            ];
            if ($chk = $this->get_by($where, true)) 
                return 'your_url_already';

            # Trừ điểm
            $this->load->model('pointload_model');
            $refund = [
                'member_id' => $memberId,
                'amount' => -$point,
                'type' => 'post',
                'detail' => json_encode($data),
                'note' => 'Yêu cầu duyệt bài: ' . $data['title'],
            ];
            if ($this->pointload_model->save($refund, null)==false) 
                return 'system_busy';

            return ($this->save($data, null)) ? 'success' : 'system_busy';
        }

}

/* End of file Postrequest_model.php */
/* Location: ./application/backend/models/Postrequest_model.php */