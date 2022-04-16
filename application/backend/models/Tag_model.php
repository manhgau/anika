<?php
class Tag_model extends MY_Model
{
    protected $_table_name = 'tag';
    protected $_primary_key = 'id';
    protected $_order_by = 'id DESC';
    public $rules = array ('tag' => array(
            'field' => 'tag',
            'rules' => 'trim|required'));

    public function __construct() {
        parent::__construct();
    }

    public function get_new()
    {
        $data = new stdClass();
        $data->tag = '';
        $data->tag_md5 = '';
        return $data;
    }

    public function check_exist_tag($tag)
    {
        $md5_tag = md5($tag);
        $this->db->where('tag_md5', $md5_tag);
        return parent::get();
    }
    
    public function getTagsInIds($ids='') {
        $args = explode(',',$ids);
        $this->db->where_in('id',$args);
        return $this->get();
    }
    
}