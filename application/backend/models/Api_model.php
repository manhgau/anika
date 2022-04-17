<?php
    class Api_model extends MY_Model {
        protected $_table_name = 'company_information';
        
        public function get_app_init (){                       
            $data = $this->get();   
            return $data;            
        }
    }