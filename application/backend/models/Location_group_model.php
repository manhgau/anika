<?php
class Location_group_model extends MY_Model{
    
    protected $_table_name = 'location_group';
    protected $_primary_key = 'id';
    protected $_order_by = 'name ASC, id DESC';
    public    $rules = array (
        'name' => array(
            'field'   => 'name',
            'rules'   => 'trim|required')
        );

    public function __construct()
    {
        parent::__construct();
    }
    
    public function getNew()
    {
        $data = new stdClass();
        $data->name = ''; 
        $data->slugname = ''; 
        $data->parent_id = ''; 
        return $data;
    }
    
    public function getAllGroup()
    {
        $this->db->select('id, name, slugname, parent_id');
        return $this->get();
    }

    public function getDetailGroup($id=null)
    {
        return ($id) ? $this->get($id, true) : $this->getNew();
    }

    public function search($keyword, $offset=0, $limit=10)
    {
        $this->db->like('name', $keyword);
        $this->db->limit($limit, $offset);
        return $this->get();
    }
}