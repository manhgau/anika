<?php
    class Video_model extends MY_Model {
        protected $_table_name  = 'video';
        protected $_primary_key = 'id';
        protected $_order_by    = 'id DESC';
        public    $rules        = array (
            'title'            => array(
                'field'   => 'title',
                'rules'   => 'trim|max_length[100]|required' ),
            'status'           => array(
                'field'   => 'status',
                'rules'   => 'trim|intval' ),
            'fileUrl' => array(
                'field' => 'fileUrl',
                'rules' => 'trim|required'
            ),
            'cat_id' => array(
                'field' => 'cat_id',
                'rules' => 'intval'
            )
        );

        public function __construct() {
            parent::__construct();
        }

        public function get_new() {
            $data = new stdClass();
            $data->title=''; 
            $data->slugname=''; 
            $data->description=''; 
            $data->fileUrl=''; 
            $data->thumbnail=''; 
            $data->meta_title=''; 
            $data->meta_description=NULL; 
            $data->meta_keyword=NULL; 
            $data->tags_id=NULL;
            $data->status=1;
            $data->is_hot=0;
            $data->create_time = time();
            $data->public_time = time();
            $data->cat_id = 1;
            return $data;
        }

        function getListVideo($status=0) {
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
                return TRUE;
            }
            return FALSE;
        }
        
        public function search($q) {
            $this->db->distinct();
            $this->db->select('id,title');
            $this->db->like('title',$q);
            $this->db->group_by('id');
            return $this->get();
        }
        
        public function get_videos_with_ids($ids)
        {
            $args = explode(',',$ids);
            $this->db->where_in('id',$args);
            return $this->get();
        }
}