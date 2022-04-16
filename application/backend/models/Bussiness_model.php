<?php
class Bussiness_model extends MY_Model {
    
    protected $_table_name = 'bussiness';
    protected $_primary_key = 'id';
    protected $_order_by = 'id DESC, display_name ASC';
    public $rules = array(
        'title' => array(
            'field' => 'title',
            'rules' => 'required|trim'    
        ),
        'email' => array(
            'field' => 'email',
            'rules' => 'valid_email|trim'
        ),
        'display_name' => array(
            'field' => 'display_name',
            'rules' => 'trim'
        )
    );
    
    
    public function __construct(){
        parent::__construct();
    }
    
    public function getNew()
    {
        $data = new stdClass;
        $data->title = '';
        $data->slugname = '';
        $data->description = '';
        $data->thumbnail = '';
        $data->images = '';
        $data->display_name = '';
        $data->login_name = '';
        $data->password = '';
        $data->email = '';
        $data->phone = '';
        $data->status = 1;
        $data->province_id = null;
        $data->address = '';
        $data->tax_code = '';
        $data->bussiness_code = '';
        $data->bank_card = '';
        $data->bank_name = '';
        $data->website = '';
        $data->fax = '';
        $data->director_name = NULL;
        $data->bank_card_owner = NULL;
        $data->facebook_account = NULL;
        $data->zalo_account = NULL;
        $data->viber_account = NULL;
        $data->google_account = NULL;
        $data->created_time = date('Y-m-d H:i:s', time());
        return $data;
    }

    public function hashString($str) 
    {
        return md5($str) . BUSSINESS_ENCRYPT_KEY;
    }

    public function updateStatus($id, $status)
    {
        $data['status'] = $status;
        if (is_array($id)) {
            foreach ($id as $key => $_id) {
                $this->save($data, $_id);
            }
            return TRUE;
        }
        else
            return $this->save($data, $id);
    }

    public function getListBussiness($args = array()) 
    {
        $where = array();
        if ($args['status']) 
            $where['status'] = $args['status'];
        else
            $where['status !='] = STATUS_DELETED;
        if ($args['province_id']) $where['province_id'] = $args['province_id'];
        if ($args['bussiness_code']) $where['bussiness_code'] = $args['bussiness_code'];

        $this->db->select('id, title, slugname, thumbnail, display_name, email, phone, province_id, address, bussiness_code, status, created_time');
        if($where) $this->db->where($where);
        if ( isset($args['keyword']) && $args['keyword'] ) {
            $this->db->like('display_name', $args['keyword']);
        }
        $this->db->limit($args['limit'], $args['offset']);
        return $this->get(NULL, FALSE, 'result_array');
    }

    public function getNumberBussiness($args = array()) {
        $where = array();
        if ($args['status']) $where['status'] = $args['status'];
        if ($args['province_id']) $where['province_id'] = $args['province_id'];
        if ($args['bussiness_code']) $where['bussiness_code'] = $args['bussiness_code'];
        $this->db->select('COUNT(id) AS number');
        if($where) $this->db->where($where);
        if ( isset($args['keyword']) && $args['keyword'] ) {
            $this->db->like('display_name', $args['keyword']);
        }
        return $this->get(null, false, 'result_array');
    }

    public function getDetailBussiness($id=null)
    {
        if ( ! $id) return $this->getNew();
        return $this->get($id, true);
    }

    public function search($keyword, $offset=0, $limit=10)
    {
        $this->db->distinct();
        $this->db->select('id, title, display_name');
        $this->db->like('title', $keyword);
        $this->db->or_like('display_name', $keyword);
        $this->db->limit($limit, $offset);
        return $this->get();
    }
    
}