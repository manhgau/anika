<?php
    class Gallery_model extends MY_Model {
        protected $_table_name  = 'gallery';
        protected $_primary_key = 'id';
        protected $_order_by    = 'id DESC';
        public    $rules        = array (
            'title'            => array(
                'field'   => 'title',
                'rules'   => 'trim|max_length[100]|required' ),
            'status'           => array(
                'field'   => 'status',
                'rules'   => 'trim|intval' )
        );

        public function __construct() {
            parent::__construct();
        }

        public function get_new() {
            $data = new stdClass();
            $data->title            = ''; 
            $data->slugname         = ''; 
            $data->thumbnail        = ''; 
            $data->description      = ''; 
            $data->status           = 1; 
            $data->is_hot           = 0; 
            $data->meta_title       = NULL; 
            $data->meta_keyword     = NULL; 
            $data->meta_description = NULL;
            return $data;
        }

        function getListGallery($status=0) {
            if($status) 
                $this->db->where('status',$status);
            else 
                $this->db->where('status !=',3);
            return $this->get();
        }

        public function updateStatus($ids,$status) {
            $this->db->where_in('id',$ids);
            $args = array('status' => $status);
            if($this->db->update($this->_table_name,$args)) {
                return true;
            }
            return false;
        }

        public function search($q) {
            $this->db->distinct();
            $this->db->select('id,title');
            $this->db->like('title',$q);
            $this->db->group_by('id');
            return $this->get();
        }
}