<?php
    class FieldActivity_model extends MY_Model {
        protected $_table_name  = 'field_activity';
        public function get_list_field($offset=0, $limit=10){
            $this->db->select('*');
            $this->db->from($this->_table_name );
            $this->db->where('status', 1);
            $this->db->limit($limit, $offset);
            $query = $this->db->get();
            $data = $query->result();  
            if (is_array($data) && count($data) > 0){
                return $data;
            }else{
                return NULL;
            }
        }
    }