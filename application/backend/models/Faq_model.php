<?php
class Faq_model extends MY_Model{
    
    protected $_table_name = 'faq';
    protected $_primary_key = 'id';
    protected $_order_by = '`order` ASC';
    public    $rules = array(
        'question' => array(
            'field'   => 'question',
            'rules'   => 'trim|max_length[100]|required' ),
        'answer' => array(
            'field'   => 'answer',
            'rules'   => 'trim' ),
        'order' => array(
            'field'   => 'order',
            'rules'   => 'trim|intval' )
        );

    public function __construct()
    {
        parent::__construct();
    }
    
    public function get_new()
    {
        $data = parent::getNew();
        $data->order = $this->getNextOrder();
        return $data;
    }

    public function getNextOrder($page='all')
    {
        $this->db->select('IF(`order` IS NULL, 0, MAX(`order`)) AS `pos`');
        $this->db->from($this->_table_name);
        $this->db->limit(1);
        $data = $this->db->get()->row();
        return intval($data->pos) + 1;
    }
    

}