<?php
class MY_Model extends CI_Model {
    
    protected $_table_name = '';
    protected $_primary_key = 'id';
    protected $_primary_filter = 'intval';
    protected $_data_type = [];
    protected $_order_by = '';
    public $rules = array();
    protected $_timestamp = FALSE;
    
    public function __construct(){
        parent::__construct();
        
        //Load Caching_driver
        $this->load->driver('cache', array('adapter' => 'file'));
    }

    public function setData($data, $isObject=FALSE)
    {
        if (!$this->_data_type) 
            return $data;

        if ($isObject) 
            $data = get_object_vars($data);

        $typeFormat = [
            'int' => 'intval',
            'interger' => 'intval',
            'double' => 'doubleval',
            'float' => 'floatval',
            'boolean' => 'boolval',
            'string' => 'trim',
            'varchar' => 'trim',
            'char' => 'trim',
            'text' => 'trim',
            'string' => 'trim',
            'file' => 'getImageUrl',
        ];

        foreach ($data as $key => $value) {
            if ( isset($this->_data_type[ $key ]) && $_type=$this->_data_type[ $key ] ) 
            {
                $fnc = $typeFormat[strtolower($_type)];
                $data[$key] = $fnc($value);
            }
        }
        return ($isObject) ? json_decode(json_encode($data)) : $data;
    }

    public function getNew()
    {
        $data = [];
        $fields = $this->db->list_fields($this->_table_name);
        foreach ($fields as $field) {
            $data[$field] = NULL;
        }
        return json_decode( json_encode($data) );
    }
    
    public function array_from_post($fields) {
        $data = array();
        foreach ($fields as $field) {
            $data[$field] = $this->input->post($field);
        }
        return $data;
    }
    
    public function get($id = NULL,$single = FALSE) {
        if(! $id == NULL)
        {
            $filter = $this->_primary_filter;
            $id = $filter($id);
            $this->db->where($this->_primary_key,$id);
            $method = 'row';
        }
        elseif ($single == TRUE)
           $method = 'row';            
        else
            $method = 'result';
        if(! $this->db->order_by($this->_order_by))
            $this->db->order_by($this->_order_by);
        return $this->db->get($this->_table_name)->$method();
    }
    
    public function get_by($where, $single = FALSE) {
        $this->db->where($where);
        return $this->get(NULL,$single);
    }
    
    public function save($data,$id = NULL) {
        //Insert
        if($id === NULL) {
            !isset($this->_primary_key) || $this->_primary_key == NULL;
            $this->db->set($data);
            $this->db->insert($this->_table_name);
            $id = $this->db->insert_id();
        }
        //Update
        else 
        {
            $filter = $this->_primary_filter;
            $id = $filter($id);
            $this->db->set($data);
            $this->db->where($this->_primary_key,$id);
            $this->db->update($this->_table_name);
        }
        return $id;
    }
    
    public function delete($id) {
        $filter = $this->_primary_filter;
        $id = $filter($id);
        if(!$id)
            return FALSE;
        $this->db->where($this->_primary_key,$id);
        $this->db->limit(1);
        return $this->db->delete($this->_table_name);
    }
    
    public function get_cache($cacheID) {
        return $this->cache->get($cacheID);
    }
    
    public function set_cache($cacheID,$data,$cache_time = TIMEOUTMIN) {
        $this->cache->save($cacheID,$data,$cache_time);
    }
    
    public function clear_cache($cacheID) {
        $this->cache->delete($cacheID);
    }
    
}