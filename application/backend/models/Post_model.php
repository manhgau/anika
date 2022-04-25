<?php
    class Post_model extends MY_Model {
        protected $_table_name  = 'news';
        public function list_post ($offset=0, $limit=10, $category_id=0, $is_hot=0){
            $this->db->select('a.*, b.name AS category_name');
            $this->db->from($this->_table_name . ' as a');
            $this->db->join('category_posts as b', 'a.category_id=b.id', 'inner');
            if($category_id>0){
                $this->db->where('a.category_id',$category_id);
            }
            if($is_hot > 0){
                $this->db->where('is_hot',$is_hot);
            }
            $this->db->where('status', 1);
            $this->db->limit($limit, $offset);
            $data = $this->db->get()->result();
            return $data;
        }
        public function get_category($id){
            $this->db->select();
            $this->db->from('category_posts');
            $this->db->where('id',$id);
            $data = $this->db->get()->result();
            return $data;
        }
        public function detail_post($id){
            $this->db->select('*');
            $this->db->from($this->_table_name );
            $this->db->where('id',$id);
            $this->db->where('status', 1);
            $data = $this->db->get()->row();
            return $data;
        }
    }