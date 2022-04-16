<?php
    class Option_model extends MY_Model{

        protected $_table_name = 'option';
        protected $_primary_key = 'id';
        protected $_order_by = 'name ASC, id DESC';
        public    $rules = array(
            'name' => array(
                'field'   => 'name',
                'rules'   => 'trim|max_length[100]|required' ),
            'value' => array(
                'field'   => 'value',
                'rules'   => 'trim' ),
            'var_type' => array(
                'field'   => 'var_type',
                'rules'   => 'trim' )
        );    

        public function __construct(){
            parent::__construct();
        }

        public function get_new(){
            $data = new stdClass();
            $data->name = '';
            $data->value = '';
            $data->var_type = 'string';
            return $data;
        }
        
        public function get_site_option() {
            $this->db->limit(100,0);
            $this->db->not_like('name', 'offer_');
            return parent::get();
        }

        public function updateMulti($data, $fieldName)
        {
            $this->db->update_batch($this->_table_name, $data, $fieldName);
            return ($this->db->affected_rows()>0) ? TRUE : FALSE;
        }
        
        public function delete($id)
        {
            $this->db->where('id',$id);
            if ($this->db->delete($this->_table_name))
            {
                return TRUE;
            }
            return FALSE;
        }
}