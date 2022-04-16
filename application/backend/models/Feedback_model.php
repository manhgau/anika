<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Feedback_model extends MY_Model {

	protected $_table_name  = 'feedback';
    protected $_primary_key = 'id';
    protected $_order_by    = 'id ASC';
    public    $rules        = array ();
    public    $feedbackStatus = [
    	'pending' => [
    		'name' => 'Chờ duyệt',
    		'color' => 'gray',
    		'icon' => 'fa fa-minus'
    	],
    	'processed' => [
    		'name' => 'Đã xử lý',
    		'color' => 'green',
    		'icon' => 'fa fa-check'
    	],
    	'sent_mod' => [
    		'name' => 'Đã gửi QTV',
    		'color' => 'black',
    		'icon' => 'fa fa-evelope'
    	],
    	'deleted' => [
    		'name' => 'Đã xóa',
    		'color' => 'red',
    		'icon' => 'fa fa-trash-o'
    	],
    ];

    public $typeName = [
        'tu_van' => 'Tư vấn',
        'dao_tao' => 'Đào tạo',
        'khac' => 'Khác',
    ];
    
    public function __construct() {
        parent::__construct();
    }

    public function getNew()
    {
    	$data = parent::getNew();
    	$data->createTime = date('Y-m-d H:i:s');
    	$data->ip = $this->input->ip_address();
    	return $data;
    }

    public function addFeedback($data)
    {
    	$data['createTime'] = date('Y-m-d H:i:s');
    	$data['ip'] = $this->input->ip_address();
    	return $this->save($data, NULL);
    }

    public function getFeedbackDatatable($args)
    {
    	$default = [
    		'keyword' => NULL,
    		'status' => NULL,
    		'from_date' => NULL,
    		'to_date' => NULL,
    		'offset' => 0,
    		'limit' => 10,
    	];
    	$param = array_merge($default, array_filter($args));

    	$where = [];
    	if ($param['keyword']) 
    	{ 
    		if (intval($param['keyword'])) 
    			$where['fb.id'] = intval($param['keyword']);
    		else
    			$where['fb.name LIKE "%'.$param['keyword'].'%"'] = NULL;
    	}
		if ($param['status']) 
    		$where['fb.status'] = $param['status'];

    	$result = [
    		'recordsFiltered' => 0,
    		'recordsTotal' => 0,
    		'data' => []
    	];
    	
    	# counter
    	$this->db->select('COUNT(id) AS number');
    	$this->db->from('feedback AS fb');
    	if ($where) $this->db->where($where);
    	$counter = $this->db->get()->row();
    	if ($counter->number) 
    	{
    		$result['recordsFiltered'] = $result['recordsTotal'] = $counter->number;

    		# fetch list
    		$this->db->select('fb.id, fb.name, fb.ip, fb.email, fb.phone, fb.createTime, fb.status, fb.message, fb.type, fb.company_name, fb.attach_file');
	    	$this->db->from('feedback AS fb');
	    	if ($where) $this->db->where($where);
	    	$this->db->order_by('fb.createTime', 'desc');
	    	$this->db->limit($param['limit'], $param['offset']);
    		$result['data'] = $this->db->get()->result_array();
    	}
    	return $result;
    }

}

/* End of file Feedback_model.php */
/* Location: ./application/frontend/models/Feedback_model.php */