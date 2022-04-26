<?php
    class Post_model extends MY_Model {
        protected $_table_name  = 'news';
        public function list_post ($offset=0, $limit=10, $category=0, $is_hot=0){
            // $this->db->select('a.*, b.title AS category_name');
            // $this->db->from($this->_table_name . ' as a');
            // //$this->db->join('category as b', 'a.category = b.id', 'inner');
            // if($category_id>0){
            //     $this->db->where('a.category',$category);
            // }
            // if($is_hot > 0){
            //     $this->db->where('is_hot',$is_hot);
            // }
            // $this->db->where('status', 1);
            // $this->db->limit($limit, $offset);
            // $data = $this->db->get()->result();
            $this->db->select('a.*, b.title AS category_name');
            $this->db->from($this->_table_name . ' as a');
            $this->db->join('category as b', 'a.category=b.id', 'inner');
            if($category>0){
                $this->db->where('a.category',$category);
            }
            if($is_hot > 0){
            $this->db->where('a.is_hot',$is_hot);
            }
            $this->db->order_by('a.id',"DESC");
            $this->db->limit($limit, $offset);
            $data = $this->db->get()->result();
            return $data;
        }
        public function get_category($id){
            $this->db->select();
            $this->db->from('category');
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