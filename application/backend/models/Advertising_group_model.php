<?php
    class Advertising_group_model extends MY_Model {

        protected $_table_name  = 'advertising_group';
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
            return $data;
        }

        public function getGroups()
        {
            $selected = 'id, name, slugname';
            $this->db->select($selected);
            return $this->get();
        }

        public function getDetailGroup($id)
        {
            return ($id) ? $this->get($id, true) : $this->get_new();
        }

}