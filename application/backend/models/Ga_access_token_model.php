<?php
class Ga_access_token_model extends MY_Model {
    
    protected $_table_name  = 'ga_access_token';
    protected $_primary_key = 'id';
    protected $_order_by    = 'created_time ASC';
    
    public function __construct(){
        parent::__construct();
    }

    public function getByClientId($client_id)
    {
        $this->db->where('client_id', $client_id);
        $this->db->limit(1, 0);
        $result = $this->db->get($this->_table_name);
        $this->db->reset_query();
        $data = $result->result();
        return ($data) ? $data[0] : NULL;
    }
    
}