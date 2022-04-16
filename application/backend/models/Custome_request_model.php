<?php
class Custome_request_model extends MY_Model {

    protected $_table_name  = 'custom_request';
    protected $_primary_key = 'id';
    protected $_order_by    = 'id DESC';
    public    $rules        = array (
        'name' => array(
            'field'   => 'name',
            'rules'   => 'trim|required'),
        'email' => array(
            'field'   => 'email',
            'rules'   => 'trim|required'),
        'phone' => array(
            'field'   => 'phone',
            'rules'   => 'trim|required' ),
        'tour_id' => array(
            'field' => 'tour_id',
            'rules' => 'trim|required|intval'),
        'note' => array(
            'field' => 'note',
            'rules' => 'trim')
    );
    public    $editRules        = array (
        'pack_date_day' => array(
            'field'   => 'pack_date_day',
            'rules'   => 'trim|required'),
        'pack_date_hour' => array(
            'field'   => 'pack_date_hour',
            'rules'   => 'trim|required'),
        'child_number' => array(
            'field'   => 'child_number',
            'rules'   => 'intval'),
        'adult_number' => array(
            'field'   => 'adult_number',
            'rules'   => 'intval|required')
    );

    public function __construct(){
        parent::__construct();
    }

    public function getNew()
    {
        $data = new stdClass();
        $data->id = NULL;
        $data->type = NULL;
        $data->customer_id = NULL;
        $data->customer_name = NULL;
        $data->customer_email = NULL;
        $data->customer_phone = NULL;
        $data->created_by = NULL;
        $data->created_time = NULL;
        $data->customer_ip = NULL;
        $data->request_time = NULL;
        $data->request_time_from = NULL;
        $data->request_time_to = NULL;
        $data->person_number = NULL;
        $data->adult_number = NULL;
        $data->child_number = NULL;
        $data->baby_number = NULL;
        $data->room_number = NULL;
        $data->product_id = NULL;
        $data->location_from = NULL;
        $data->location_to = NULL;
        $data->status = STATUS_PENDING;
        $data->processed_by = NULL;
        $data->processed_time = date('Y-m-d H:i:s', time());
        $data->referer_url = NULL;
        $data->referer_id = NULL;
        $data->note = NULL;
        return $data;
    }

    public function changeStatus($id, $status)
    {
        $data = [
            'status' => $status
        ];
        if ( ! is_array($id)) {
            return $this->save($data, $id);
        }
        else
        {
            $this->db->where_in('id', $id);
            return $this->db->update($this->_table_name, $data);
        }
    }

    public function getListCustomeBooking($args)
    {
        $default = array(
            'created_date_from' => NULL,
            'created_date_to' => NULL,
            'offset' => 0,
            'limit' => 20,
            'status' => NULL,
        );
        $params = array_merge($default, $args);
        $where = array();
        if ($params['status'] && $params['status'] !='') $where['status'] = $params['status'];
        
        if ($default['created_date_from']) 
            $where['date(created_time) >='] = $params['created_date_from'];
        if ($default['created_date_to']) 
            $where['date(created_time) <='] = $params['created_date_to'];

        $this->db->select('id, type, customer_name, customer_email, customer_phone, created_time, created_by, request_time, request_time_from, request_time_to, person_number, adult_number, child_number, baby_number, room_number, product_id, location_from, location_to, status, processed_by, processed_time, note');
        if ($where) $this->db->where($where);
        $this->db->limit($params['limit'], $params['offset']);
        return $this->get();
    }

    public function getCountBooking($params=NULL)
    {
        $default = [
            'status' => NULL,
            'type' => NULL,
            'created_time' => NULL,
            'created_by' => NULL,
            'product_type' => NULL
        ];
        $params = array_merge($default, $params);

        if (isset($params['status']) && $params['status']) 
            $where['status'] = $params['status'];
        else
            $where['status'] = STATUS_PUBLISHED;

        if (isset($params['created_by']) && $params['created_by']) 
            $where['created_by'] = $params['created_by'];

        if (isset($params['tour_id']) && $params['tour_id']) 
            $where['tour_id'] = $params['tour_id'];

        if (isset($params['product_type']) && $params['product_type']) 
            $where['product_type'] = $params['product_type'];

        $this->db->select('COUNT(id) AS number');
        $this->db->from($this->_table_name);
        $this->db->where($where);
        $data = $this->db->get()->row();
        return intval($data->number);
    }
}