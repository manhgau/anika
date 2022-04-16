<?php
class Seo_option_model extends MY_Model
{
    protected $_table_name = 'seo_option';
    protected $_primary_key = 'id';
    protected $_order_by = 'id DESC';
    public $rules = array (
        'type' => array(
            'field' => 'type',
            'rules' => 'trim|required|xss_clean'));

    public function __construct() {
        parent::__construct();
    }

    public function get_new()
    {
        $data = new stdClass();
        $data->type = '';
        $data->meta_title = '';
        $data->meta_keyword = '';
        $data->meta_description = '';
        return $data;
    }
    
    public function get_list_seo_option()
    {
        return $this->get();
    }
}