<?php
    class Products_model extends MY_Model {
        protected $_table_name  = 'real_news';
        public function get_list_products($offset=0, $limit=10 ,$type){
            $this->db->select('*');
            $this->db->from($this->_table_name );
            if($type){
                $this->db->where('type',$type);
            }
            $this->db->limit($limit, $offset);
            $query = $this->db->get();
            $data = $query->result();  
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