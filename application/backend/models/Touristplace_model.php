<?php
    class Touristplace_model extends MY_Model {

        protected $_table_name  = 'touristdestination';
        protected $_primary_key = 'id';
        protected $_order_by    = 'id DESC';
        public    $rules        = array (
            'title' => array(
                'field'   => 'title',
                'rules'   => 'trim|required' ),
            'cityId' => array(
                'field'   => 'locationId',
                'rules'   => 'trim|intval' ),
            'intro' => array(
                'field'   => 'intro',
                'rules'   => 'trim' ),
            'description' => array(
                'field'   => 'description',
                'rules'   => 'trim' )
        );

        public function __construct(){
            parent::__construct();
        }

        public function get_new()
        {
            $data = new stdClass();
            $data->title = '';
            $data->slugname = '';
            $data->cityId = 0;
            $data->countryId = NULL;
            $data->thumbnail = '';
            $data->meta_title = NULL;
            $data->meta_keyword = NULL;
            $data->meta_description = NULL;
            return $data;
        }

        public function getAllTouristDestination($cityId)
        {
            if($cityId) $this->db->where('cityId', $cityId);
            return $this->get();
        }

        public function getPlaceByName($name)
        {
            $this->db->where('title', $name);
            $data = $this->get();
            if( ! $data) return FALSE;
            return $data[0];
        }
}