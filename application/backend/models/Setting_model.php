<?php
    class Setting_model extends MY_Model {
        protected $_table_name = 'setting';
        protected $_primary_key = 'id';
        protected $_order_by = 'id DESC';
        public $rules = array (
            'phone'            => array(
                'field'   => 'phone',
                'label'   => 'Phone',
                'rules'   => 'trim|required' )
        );
}