<?php
    class Partner_model extends MY_Model {
        protected $_table_name  = 'relation';
        public function get_list_partner($offset=0, $limit=10){
            $this->db->select('*');
            $this->db->from($this->_table_name );
            $this->db->where('status', 1);
            $this->db->limit($limit, $offset);
            $data = $this->db->get()->result();
            return $data;
        }
        public function get_detail_partner($id){
            $this->db->select('*');
            $this->db->from($this->_table_name );
            $this->db->where('id', $id);
            $data = $this->db->get()->row();
            return $data;
        }
    }
