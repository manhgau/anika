<?php
    class Destination_model extends MY_Model {

        protected $_table_name  = 'destination';
        protected $_primary_key = 'id';
        protected $_order_by    = 'id DESC';
        public    $rules        = array (
            'title' => array(
                'field'   => 'title',
                'rules'   => 'trim|required' ),
            'locationId' => array(
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
            $data->locationId = 0;
            $data->intro = NULL;
            $data->description = NULL;
            $data->thumbnail = '';
            $data->is_hot = 0;
            $data->properties = '';
            $data->status = 1;
            $data->meta_title = NULL;
            $data->meta_keyword = NULL;
            $data->meta_description = NULL;
            $data->price = 0;
            $data->adultNumber = 1;
            $data->bedroomNumber = 1;
            $data->bathroomNumber = 1;
            $data->kitchenNumber = 0;
            $data->type = 'apartment';
            $data->customerObject = 'family';
            $data->images = NULL;
            $data->address = NULL;
            $data->phone = NULL;
            $data->email = NULL;
            $data->cityId = NULL;
            return $data;
        }

        public function getListDestination($status=NULL, $locationId=NULL)
        {
            $args = array();
            if($status) $args['status'] = $status;
            if($locationId) $args['locationId'] = $locationId;
            $this->db->where($args);
            return $this->get();
        }

        public function getDetailDestination($id)
        {
            return $this->get($id, TRUE);
        }

        function getDestinationInGroupId($ids=array())
        {
            if( ! $ids) return FALSE;
            $this->db->where_in('id', $ids);
            $this->db->limit(count($ids), 0);
            $data = $this->get();
            if( ! $data) return FALSE;
            foreach ($data as $key => $value) {
                $result[$value->id] = $value;
            }
            return $result;
        }
        
        public function getDestinationByName($name)
        {
            $this->db->where('title', $name);
            $data = $this->get();
            if( ! $data) return FALSE;
            return $data[0];
        }
}