<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Newspaper_model extends MY_Model {

	protected $_table_name = 'news_paper';
    protected $_primary_key = 'id';
    protected $_order_by = 'id DESC';
    protected $pageShow = [
    	'all' => 'Tất cả',
    	'home' => 'Trang chủ',
    	'fund2' => 'Sự kiện Fund 2',
    ];

    public $rules = array(
        'title' => array(
            'field' => 'title',
            'rules' => 'required|max_length[250]'    
        ),
        'newsUrl' => array(
            'field' => 'newsUrl',
            'rules' => 'required|max_length[250]'    
        ),
        'image' => array(
            'field' => 'image',
            'rules' => 'trim'
        ),
        'isHot' => array(
            'field' => 'isHot',
            'rules' => 'intval'
        ),
        'order' => array(
            'field' => 'order',
            'rules' => 'intval'
        )
    );
    
    public function __construct()
	{
		parent::__construct();
	}

	public function getPageShow($page='')
	{
		return ($page) ? $this->pageShow[$page] : $this->pageShow;
	}

	public function getNew()
	{
		$data = parent::getNew();
		$data->order = $this->getNextOrder();
		$data->createTime = date('Y-m-d H:i:s');
		$data->createBy = intval($this->data['userdata']['id']);
		return $data;
	}

	public function getNextOrder($page='all')
	{
		$this->db->select('IF(`order` IS NULL, 0, MAX(`order`)) AS `pos`');
		$this->db->from($this->_table_name);
		if ($page!='all') {
			$this->db->where('on_page', $page);
		}
		$this->db->limit(1);
		$data = $this->db->get()->row();
		return intval($data->pos) + 1;
	}

}

/* End of file Newspaper_model.php */
/* Location: ./application/backend/models/Newspaper_model.php */