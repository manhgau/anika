<?php
    class Products_model extends MY_Model {
        protected $_table_name  = 'real_news';
        public function get_list_products($limit=10, $offset=0, $category_id = 0){
                $this->db->select('a.*, b.title AS category_name');
                $this->db->from($this->_table_name . ' as a');
                $this->db->join('category_products as b', 'a.category_id=b.id', 'inner');
                if($category_id>0){
                    $this->db->where('a.category_id',$category_id);
                }
                $this->db->limit($limit, $offset);
                $data = $this->db->get()->result();
                return $data;


        }
        public function get_detail_product($id){
            $this->db->select('*');
            $this->db->from($this->_table_name );
            $this->db->where('id', $id);
            $query = $this->db->get();
            $data = $query->result();  
            return $data;
        }
    }