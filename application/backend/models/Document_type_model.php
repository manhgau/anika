<?php
class Document_type_model extends MY_Model {
    
    protected $_table_name = 'document_type';
    protected $_primary_key = 'id';
    protected $_order_by = 'position ASC, id DESC';
    
    public $rules = array(
        'name' => array(
            'field' => 'name',
            'rules' => 'required|max_length[250]'    
        ),
        'slugname' => array(
            'field' => 'slugname',
            'rules' => 'trim'
        ),
        'status' => array(
            'field' => 'status',
            'rules' => 'intval'
        ),
        'position' => array(
            'field' => 'position',
            'rules' => 'intval'
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
        $data->meta_title = '';
        $data->meta_keyword = '';
        $data->meta_description = '';
        $data->status = 1;
        $data->position = 1;
        return $data;
    }
    
    public function get_detail_document_type($id)
    {
        return $this->get($id, TRUE);
    }
    
    public function get_list_document_type($offset=0, $limit=20)
    {
        $this->db->select('name, slugname, status, position');
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
    
    public function delete($id)
    {
        $this->db->where('id', $id);
        if($this->db->delete($this->_table_name))
            return TRUE;
        else
            return FALSE;
    }
    
    public function get_all_types()
    {
        $result = $this->get();
        foreach ($result as $key => $val) {
            $data[$val->id] = $val;
        }
        return $data;
    }
    
}
