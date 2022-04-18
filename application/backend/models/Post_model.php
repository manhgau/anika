<?php
    class Post_model extends MY_Model {
        protected $_table_name  = 'news';
        public function get_list_post($offset=0, $limit=10 ,$category=0){
            $this->db->select('*');
            $this->db->from($this->_table_name );
            if($category > 0){
                $this->db->where('category',$category);
            }
            $this->db->where('status', 1);
            $this->db->limit($limit, $offset);
            $query = $this->db->get();
            $data = $query->result();  
            return $data;
        }
    }