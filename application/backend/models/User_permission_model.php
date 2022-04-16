<?php
class User_permission_model extends MY_Model {
    
    protected $_table_name  = 'user_permission';
    protected $_primary_key = 'id';
    protected $_order_by    = 'id DESC';
    public    $rules        = array (
        'user_id' => array(
            'field'   => 'user_id',
            'rules'   => 'intval|required' )
    );
    
    public function __construct() 
    {
        parent::__construct();
    }
    
    public function get_permission_by_user($user_id) 
    {
        $this->db->where('user_id',$user_id);
        $this->db->limit(1,0);
        $data = $this->get();
        if ($data)
            return $data[0];
        else
            return false;
    }
    
    public function get_list_permission()
    {
        $data = $this->get();
        if ($data)
        {
            foreach ($data as $key => $val) {
                $result[$val->user_id] = $val;
            }
            return $result;
        }
        return false;
    }
    
}