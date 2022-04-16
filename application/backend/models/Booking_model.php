<?php
class Booking_model extends MY_Model {

    protected $_table_name  = 'booking';
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
        'status' => array(
            'field'   => 'status',
            'rules'   => 'intval|required')
    );

    public function __construct(){
        parent::__construct();
    }

    public function getBookingById($id=NULL)
    {
        if ( ! $id) 
            return $this->get_new();
        if (is_array($id)) {
            $this->db->where_in('id', $id);
            return $this->get();
        }
        else
        {
            return $this->get($id, TRUE);
        }
    }

    public function get_new()
    {
        $data = new stdClass();
        $data->name = '';
        $data->email = '';
        $data->phone = '';
        $data->created_time = date('Y-m-d H:i:s', time());
        $data->status = 2;
        $data->tour_id = NULL;
        $data->note = NULL;
        $data->process_status = NULL;
        $data->payment_return = NULL;
        return $data;
    }

    public function updateStatus($id, $status)
    {
        $data =[
            'process_status' => $status
        ];
        if (is_array($id)) 
        {
            $this->db->where_in('id', $id);
            return $this->db->update($this->_table_name, $data);
        }
        else
        {
            return $this->save($data, $id);
        }
    }

    public function getListBooking($args)
    {
        $default = array(
            'offset' => 0,
            'limit' => 20
        );
        $params = array_merge($default, $args);
        $where = array();
        if ($params['status'] && $params['status'] !='') $where['status'] = $params['status'];
        if ($params['process_status'] && $params['process_status'] !='') $where['process_status'] = $params['process_status'];

        $this->db->select('id, name, email, phone, created_time, status, tour_id, customer_id, bussiness_id, note, person_number, child_number, baby_number, room_number, arrival_date, price, price_child, pack_name, pack_date, checkout_date, product_type, user_ip, address, total, paid, payment_return, process_status');
        if ($where) $this->db->where($where);
        $this->db->limit($params['limit'], $params['offset']);
        return $this->get();
    }

    public function getCountBooking($params=NULL)
    {
        $default = [
            'status' => NULL,
            'process_status' => NULL,
            'bussiness_id' => NULL,
            'tour_id' => NULL,
            'created_time' => NULL,
            'product_type' => NULL
        ];
        $params = array_merge($default, $params);

        if (isset($params['status']) && $params['status']) 
            $where['status'] = $params['status'];

        if (isset($params['process_status']) && $params['process_status']) 
            $where['process_status'] = $params['process_status'];

        if (isset($params['bussiness_id']) && $params['bussiness_id']) 
            $where['bussiness_id'] = $params['bussiness_id'];

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