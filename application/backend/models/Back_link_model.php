<?php
class Back_link_model extends MY_Model {
    
    protected $_table_name = 'back_link';
    protected $_primary_key = 'id';
    protected $_order_by = 'id DESC';
    public $rules = array(
        'keyword' => array(
            'field' => 'keyword',
            'rules' => 'required'    
        ),
        'link' => array(
            'field' => 'link',
            'rules' => 'required'
        )
    );
    
    
    public function __construct(){
        parent::__construct();
    }
    
    public function getNew()
    {
        $data = new stdClass;
        $data->keyword = '';
        $data->link = '';
        $data->status = 1;
        return $data;
    }
    
    public function get_list_back_link()
    {
        return $this->get();
    }
    
    public function delete($ids = array())
    {
        if ( ! $ids) return FALSE;
        $data = array('status' => 3);
        $this->db->where_in('id',$ids);
        if ( $this->db->update($this->_table_name,$data))
            return TRUE;
        else
            return FALSE;
    }
    
}