<?php
    class Init_model extends MY_Model {
        protected $_table_name = 'option';
        
        public function get_app_init (){     
       
            $this->db->select('name, value');
            $this->db->from($this->_table_name );
            $query = $this->db->get();
            $data = $query->result();  
            $settings = [];
            if(is_array($data) && count($data) > 0) {
                foreach($data as $item){				
                    $settings[$item->name] =$item->value;	
                }
            }           
            return $settings;                   
        }
    }