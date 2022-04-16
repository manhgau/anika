<?php
class Document_model extends MY_Model {
    
    protected $_table_name = 'document';
    protected $_primary_key = 'id';
    protected $_order_by = 'id DESC';
    
    public $rules = array(
        'name' => array(
            'field' => 'name',
            'rules' => 'required|max_length[250]'    
        ),
        'file_path' => array(
            'field' => 'file_path',
            'rules' => 'trim'
        ),
        'type_id' => array(
            'field' => 'type_id',
            'rules' => 'required|intval'
        ),
        'description' => array(
            'field' => 'description',
            'rules' => ''
        ),
        'publish_time' => array(
            'field' => 'publish_time',
            'rules' => ''
        ),
        'status' => array(
            'field' => 'status',
            'rules' => 'intval'
        ),
        'active_time' => array(
            'field' => 'active_time',
            'rules' => 'required'
        )
    );
    public function __construct()
    {
        parent::__construct();
    }
    
    public function get_new()
    {
        $data = new stdClass();
        $data->name = '';
        $data->slugname = '';
        $data->file_path = '';
        $data->create_time = time();
        $data->type_id = 0;
        $data->description = '';
        $data->publish_time = time();
        $data->active_time = time();
        $data->meta_title = '';
        $data->meta_keyword = '';
        $data->meta_description = '';
        $data->status = 1;
        return $data;
    }
    
    public function get_detail_document($id)
    {
        return $this->get($id, TRUE);
    }
    
    public function get_list_document($type_id=NULL, $status=NULL, $offset=0, $limit=20)
    {
        $this->db->select('id,name, slugname, file_path, create_time, type_id, publish_time, active_time, status');
        if($type_id) $this->db->where('type_id', $type_id);
        if($status) $this->db->where('status', $status);
        $this->db->limit($limit, $offset);
        return $this->get();
    }
    
    public function updateStatus($ids,$status) {
        $this->db->where_in('id',$ids);
        $args = array('status' => $status);
        if($this->db->update($this->_table_name,$args)) {
            return TRUE;
        }
        return FALSE;
    }
    
}
