<?php
class Textlink_model extends MY_Model
{

    protected $_table_name = 'textlink';
    protected $_primary_key = 'id';
    protected $_order_by = 'id DESC';
    public $rules = array(
        'title' => array(
            'field' => 'title',
            'label' => 'TextLink',
            'rules' => 'trim|required'),
        'url' => array(
            'field' => 'url',
            'label' => 'Url',
            'rules' => 'trim|required'),
        'status' => array(
            'field' => 'status',
            'label' => 'Status',
            'rules' => 'trim|intval|required'));

    public function __construct()
    {
        parent::__construct();
    }

    public function get_new()
    {
        $data = new stdClass();
        $data->title = '';
        $data->url = '';
        $data->is_blank = 1;
        $data->do_follow = 1;
        $data->status = 1;
        return $data;
    }

    public function get_all_textlink()
    {
        $this->db->where(array('status' => 1));
        return parent::get();
    }
}
