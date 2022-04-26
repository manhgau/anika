<?php
class Business_setting_model extends MY_Model{
    
    protected $_table_name  = 'field_activity';
    protected $_primary_key = 'id';
    protected $_order_by    = 'id ASC';
    public    $rules        = array (
        'name'            => array(
            'field'   => 'name',
            'rules'   => 'trim|max_length[100]|required' ),
        'status'           => array(
            'field'   => 'status',
            'rules'   => 'trim|intval' ),     
        'parent_id'        => array(
            'field'   => 'parent_id',
            'rules'   => 'trim|intval' )
        );
    
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_new() {
        $data = parent::getNew();
        $data->status = 1;
        // $data->parent_id = 0;
        // $data->level = 1;
        return $data;
    }
    
    public function getList()
    {
        $query = $this->db->get($this->_table_name);
        return ($query->num_rows() > 0 ) ? $query->result_array() : null;
    }

    // public function getCategory(){
    //     $query = $this->db->get($this->_table_name);
    //     return ($query->num_rows() > 0 ) ? $query->result_array() : null;
    // }
    // public function get_category_with_parent ($id=NULL,$single=FALSE) {
    //     $this->db->select('category.*,c.title as parent_title,c.slug as parent_slug, c.id as parent_id');
    //     $this->db->join('category as c','category.parent_id = c.id','left');
    //     return parent::get($id,$single);
    // }
}