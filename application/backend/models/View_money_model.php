<?php
    class View_money_model extends MY_Model {

        protected $_table_name  = 'view_to_money';
        protected $_primary_key = 'id';
        protected $_order_by    = 'id DESC';
        public    $rules        = array (
            'view_min' => array(
                'field'   => 'view_min',
                'rules'   => 'trim|intval|required' ),
            'view_max' => array(
                'field'   => 'view_max',
                'rules'   => 'trim|intval|required' ),
            'money_min' => array(
                'field'   => 'money_min',
                'rules'   => 'trim|intval|required' ),
            'money_max' => array(
                'field'   => 'money_max',
                'rules'   => 'trim|intval|required' ),
            'news_type_id' => array(
                'field'   => 'news_type_id',
                'rules'   => 'trim|intval|required' )
        );

        public function __construct(){
            parent::__construct();
        }

        public function get_new()
        {
            $data = new stdClass();
            $data->view_min = 0;
            $data->view_max = 0;
            $data->money_min = 0;
            $data->money_max = 0;
            $data->news_type_id = null;
            return $data;
        }

        public function getDetailQuota($id='')
        {
            return ($id) ? $this->get($id, true) : $this->get_new();
        }
}