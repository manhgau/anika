<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pointrefund_model extends MY_Model {

        protected $_table_name  = 'point_refund';
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
                else 
                    $where['a.code'] = $post['keyword'];
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

        public function refundProccess($id, $note, $status, $managerId)
        {
        	$request = $this->get($id, true);
            if (!$request) 
        		return false;

        	if (! in_array($status, array_keys($this->allStatus))) 
        		return false;

            $this->load->model('realnews_model');
            $news = $this->realnews_model->get_by(['code'=>$request->news_code], true);
            
        	$this->db->trans_begin();
            try {

                if ($status==self::STATUS_SUCCESS) {
                    $this->load->model('pointload_model');
                    $refund = $this->pointload_model->processRefund($request->news_code, intval($request->member_id), intval($request->amount), intval($news->member_id));
                    if (!$refund) {
                        throw new Exception("system_busy", 500);
                    }
                }

                $data = [
                    'answer_by' => $managerId,
                    'answer' => $note,
                    'answer_time' => date('Y-m-d H:i:s'),
                    'status' => $status,
                ];
                if (!$this->save($data, $id)) {
                    throw new Exception("system_busy", 500);
                }

            } catch (Exception $e) {
                $this->db->trans_rollback();
                return FALSE;
            }
            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                return FALSE;
            }
            else
            {
                $this->db->trans_commit();
                return TRUE;
            }
        }

        public function pendingNumber()
        {
        	$this->db->select('COUNT(id) AS number');
        	$data = $this->get_by(['status' => self::STATUS_PENDING], true);
        	return ($data) ? $data->number : 0;
        }

        public function getRefundByMemberNews(int $memberId, $code)
        {
            return $this->get_by(['member_id' => $memberId, 'news_code' => $code], true);
        }

        public function addRequest(int $memberId, $code, $url, $note)
        {
            $news = $this->db->select('point, code, slugname')->get_where('real_news', ['code' => $code], 1)->row();
            if (!$news) 
                return 'news_not_exist';

            if ($this->getRefundByMemberNews($memberId, $code)) {
                return 'request_already';
            }

            $point = ($news) ? intval($news->point) : 0;
            $data = [
                'member_id' => $memberId,
                'news_code' => $code,
                'news_url' => linkToDetailRealNews($news->slugname, $news->code),
                'amount' => $point,
                'note' => $note,
                'status' => self::STATUS_PENDING,
            ];
            return ($this->save($data, null)) ? 'success' : 'system_busy';
        }

}

/* End of file Pointrefund_model.php */
/* Location: ./application/backend/models/Pointrefund_model.php */