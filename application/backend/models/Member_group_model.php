<?php
    class Member_group_model extends MY_Model {

        protected $_table_name  = 'member_group';
        protected $_primary_key = 'id';
        protected $_order_by    = 'id DESC';
        public    $rules        = array (
            'title' => array(
                'field'   => 'title',
                'rules'   => 'trim|required' ),
            'slugname' => array(
                'field' => 'slugname',
                'rules' => 'trim'
            )
        );

        public function __construct(){
            parent::__construct();
        }

        public function get_new()
        {
            $data = new stdClass();
            $data->title = '';
            $data->slugname = '';
            $data->meta_title = NULL;
            $data->meta_keyword = NULL;
            $data->meta_description = NULL;
            return $data;
        }

        public function get_list_member_group()
        {
            return $this->get();
        }

        public function get_detail_member_group($id)
        {
            return $this->get($id, TRUE);
        }
        
        public function delete($id)
        {
            $this->db->where('id', $id);
            $this->db->delete($this->_table_name);
            if($this->db->affected_rows() > 0)
                return TRUE;
            else
                return FALSE;
        }
}