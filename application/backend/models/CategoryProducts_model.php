<?php
    class CategoryProducts_model extends MY_Model {
        protected $_table_name  = 'category_products';
        public function get_list_category_products($offset=0, $limit=10){
            $this->db->select('*');
            $this->db->from($this->_table_name );
            $this->db->where('status', 1);
            $this->db->limit($limit, $offset);
            $data = $this->db->get()->result();
            return $data;
        }
    }