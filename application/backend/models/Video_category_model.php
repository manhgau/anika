<?php
class Video_category_model extends MY_Model {
    
    protected $_table_name  = 'video_category';
    protected $_primary_key = 'id';
    protected $_order_by    = 'id ASC';
    public $rules = array (
        'title'            => array(
            'field'   => 'title',
            'rules'   => 'trim|max_length[100]|required' ),
        'slugname' => array(
            'field' => 'slugname',
            'rules' => 'trim|xss_clean'
        ),   
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
    
    public function get_new() {
        $data = new stdClass();
        $data->title = '';
        $data->slugname = '';
        $data->meta_title = '';
        $data->meta_description = '';
        $data->meta_keyword = '';
        $data->parent_id = 0;
        return $data;
    }
    
    public function get_list_video_category()
    {
        $data = $this->get();
        foreach ($data as $key => $val) {
            $result[$val->id] = $val;
        }
        return $result;
    }
    
    public function get_detail_video_category($id)
    {
        $data = $this->get($id, TRUE);
        if( ! $data) return FALSE;
        return $data;
    }
}