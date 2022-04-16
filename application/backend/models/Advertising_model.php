<?php
    class Advertising_model extends MY_Model {

        protected $_table_name  = 'advertising';
        protected $_primary_key = 'id';
        protected $_order_by    = 'position ASC, id DESC';
        public    $rules        = array (
            'title' => array(
                'field'   => 'title',
                'rules'   => 'trim|required' ),
            'sale_info' => array(
                'field'   => 'sale_info',
                'rules'   => 'trim|required' ),
            'image' => array(
                'field'   => 'image',
                'rules'   => 'trim|required' ),
            'group_id' => array(
                'field'   => 'group_id',
                'rules'   => 'trim|required' )
        );

        public function __construct(){
            parent::__construct();
        }

        public function get_new()
        {
            $data = new stdClass();
            $data->title = '';
            $data->slugname = '';
            $data->image = '';
            $data->sale_info = '';
            $data->is_hot = 0;
            $data->group_id = 0;
            $data->status = 1;
            $data->position = $this->__getMaxPosition();
            $data->url = '';
            return $data;
        }

        public function getAdvertising()
        {
            $selected = 'id, title, slugname, image, sale_info, is_hot, group_id, status, url, position';
            $this->db->select($selected);
            return $this->get();
        }

        public function getDetailAdvertising($id)
        {
            $selected = 'id, title, slugname, image, sale_info, is_hot, group_id, status, url, position';
            $this->db->select($selected);
            return $this->get($id, true);
        }

        private function __getMaxPosition()
        {
            $this->db->select('MAX(position) AS pos');
            $result = $this->db->get($this->_table_name);
            $data = $result->result_array();
            return ($data) ? intval($data[0]['pos']) + 1 : 1;
        }

}