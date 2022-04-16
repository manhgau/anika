<?php
    class News_type_model extends MY_Model {

        protected $_table_name  = 'news_type';
        protected $_primary_key = 'id';
        protected $_order_by    = 'name ASC, id DESC';
        public    $rules        = array (
            'name' => array(
                'field'   => 'name',
                'rules'   => 'trim|required' )
        );

        public function __construct(){
            parent::__construct();
        }

        public function get_new()
        {
            $data = new stdClass();
            $data->name = '';
            $data->slugname = '';
            $data->description = '';
            $data->view_money = NULL;
            $data->fixed_money = 0;
            return $data;
        }

        public function getDetailType($typeId)
        {
            return ($typeId) ? $this->get($typeId, true) : $this->get_new();
        }

        public function getAllType($params = array())
        {
            $this->db->select('id, name, view_money, fixed_money');
            if( isset($params['has_view_money']) && $params['has_view_money']=='true' ) $this->db->where('view_money !=', '');
            return $this->get();
        }


}