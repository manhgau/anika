<?php
class Category_product_model extends MY_Model{
    
    protected $_table_name  = 'category_products';
    protected $_primary_key = 'id';
    protected $_order_by    = 'id ASC';
    public    $rules        = array (
        'title'            => array(
            'field'   => 'title',
            'rules'   => 'trim|max_length[100]|required' ),
        'status'           => array(
            'field'   => 'status',
            'rules'   => 'trim|intval' ),     
        'meta_title' => array(
            'field'   => 'meta_title',
            'rules'   => 'trim|max_length[100]' ),   
        'meta_description' => array(
            'field'   => 'meta_description',
            'rules'   => 'trim|max_length[250]' ),   
        'meta_keyword'     => array(
            'field'   => 'meta_keyword',
            'rules'   => 'trim|max_length[250]' ),  
        'parent_id'        => array(
            'field'   => 'parent_id',
            'rules'   => 'trim|intval' )
        );
    
    
    public function __construct() {
        parent::__construct();
    }
    
    // public function get_new() {
    //     $data = new stdClass();
    //     $data->title = '';
    //     $data->slug = '';
    //     $data->description = '';
    //     $data->meta_title = '';
    //     $data->meta_description = '';
    //     $data->meta_keyword = '';
    //     $data->status = 1;
    //     // $data->parent_id = 0; 
    //     // $data->level = 1;
    //     return $data;
    //}
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