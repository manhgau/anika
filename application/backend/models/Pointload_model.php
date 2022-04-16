<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pointload_model extends MY_Model {

        protected $_table_name  = 'point_load';
        protected $_primary_key = 'id';
        protected $_order_by    = 'id DESC';
        public    $rules        = array ();

        const MASTER_ID = 1;

        protected $allType = [
            'recharge' => [
                'name' => 'Nạp điểm',
            ],
            'view' => [
                'name' => 'Xem bài viết',
            ],
            'post' => [
                'name' => 'Đăng bài viết',
            ],
            'refund' => [
                'name' => 'Hoàn điểm',
            ],
            'recover' => [
                'name' => 'Thu hồi điểm',
            ],
            'bonus' => [
                'name' => 'Thưởng điểm',
            ],
        ];

        public function __construct(){
            parent::__construct();
        }

        public function getType($type='')
        {
            return ($type) ? $this->allType[$type] : $this->allType;
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
            if ($post['type']) $where['a.type'] = $post['type'];
            
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
                foreach ($result['data'] as $key => $value) {
                	$value['type_name'] = $this->allType[ $value['type'] ]['name'];

                	$result['data'][$key] = $value;
                }
            }
            
            return $result;
        }

        public function reportSystemPoint()
        {
        	$this->db->select('SUM(point) AS point, SUM(used_point) used_point');
        	$this->db->from('member');
        	return $this->db->get()->row();
        }

        public function addPointLoad(int $amount, int $memberId, string $type, $note='', $detail='')
        {
            $data[] = [
                'member_id' => $memberId,
                'amount' => $amount,
                'type' => strtolower($type),
                'detail' => $detail,
                'note' => $note
            ];
            $data[] = [
                'member_id' => self::MASTER_ID,
                'amount' => -$amount,
                'type' => strtolower($type),
                'detail' => $detail,
                'note' => $note . ' cho thành viên ' . showUserId($memberId)
            ];
            $addload = $this->db->insert_batch($this->_table_name, $data);
            return ($addload) ? true : false;
        }

        public function processRefund($newsCode, int $buyerId, int $amount, $sponserId=0)
        {
            $data[] = [
                'member_id' => $buyerId,
                'amount' => $amount,
                'type' => 'refund',
                'detail' => '',
                'note' => 'Hoàn điểm theo yêu cầu từ bài viết: ' . $newsCode
            ];
            $masterAmount = ($sponserId) ? ceil($amount/2) : $amount;
            $data[] = [
                'member_id' => self::MASTER_ID,
                'amount' => -$masterAmount,
                'type' => 'recover',
                'detail' => '',
                'note' => 'Hoàn Điểm theo yêu cầu của thành viên ' . showUserId($buyerId) . '. Mã bài: ' . $newsCode
            ];
            if ($sponserId) {
                $data[] = [
                    'member_id' => $sponserId,
                    'amount' => $masterAmount - $amount,
                    'type' => 'recover',
                    'detail' => '',
                    'note' => 'Hoàn Điểm theo yêu cầu của thành viên ' . showUserId($buyerId) . '. Mã bài: ' . $newsCode
                ];
            }
            $refund = $this->db->insert_batch($this->_table_name, $data);
            return ($refund) ? true : false;
        }

        public function processBuyNews($newsCode, int $buyerId, int $amount, $sponserId=0)
        {
            $data[] = [
                'member_id' => $buyerId,
                'amount' => -$amount,
                'type' => 'view',
                'detail' => '',
                'note' => 'Xem bài viết, Mã bài viết: ' . $newsCode
            ];
            $masterAmount = ($sponserId) ? ceil($amount/2) : $amount;
            $data[] = [
                'member_id' => self::MASTER_ID,
                'amount' => $masterAmount,
                'type' => 'bonus',
                'detail' => '',
                'note' => showUserId($buyerId) . ' mua bài viết. Mã bài: ' . $newsCode
            ];
            if ($sponserId) {
                $data[] = [
                    'member_id' => $sponserId,
                    'amount' => $amount - $masterAmount,
                    'type' => 'bonus',
                    'detail' => '',
                    'note' => showUserId($buyerId) . ' mua bài viết của bạn. Mã bài: ' . $newsCode
                ];
            }
            $insert = $this->db->insert_batch($this->_table_name, $data);
            return ($insert) ? true : false;
        }
}

/* End of file Pointload_model.php */
/* Location: ./application/backend/models/Pointload_model.php */