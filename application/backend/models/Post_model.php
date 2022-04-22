<?php
    class Post_model extends MY_Model {
        protected $_table_name  = 'news';
        public function get_list_post($offset=0, $limit=10 ,$category=0, $is_hot=0){
            $this->db->select('*');
            $this->db->from($this->_table_name );
            if($category > 0){
                $this->db->where('category',$category);
            }
            if($is_hot > 0){
                $this->db->where('is_hot',$is_hot);
            }
            $this->db->where('status', 1);
            $this->db->limit($limit, $offset);
            $query = $this->db->get();
            $data = $query->result();  
            return $data;
        }
        public function get_detail_post($id){
            $this->db->select('*');
            $this->db->from($this->_table_name );
            $this->db->where('id',$id);
            $this->db->where('status', 1);
            $query = $this->db->get();
            $data = $query->result();  
            return $data;
        }
    }