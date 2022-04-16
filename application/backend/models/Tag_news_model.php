<?php
    class Tag_news_model extends MY_Model{

        protected $_table_name = 'tag_news';
        protected $_primary_key = 'id';
        protected $_order_by = 'id DESC';
        public    $rules = array();


        public function __construct(){
            parent::__construct();
        }

        public function get_new(){
            $data = new stdClass();
            $data->tag_id = 0;
            $data->news_id = 0;
            return $data;
        }


    }
?>