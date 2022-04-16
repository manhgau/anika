<?php
class File_model extends MY_Model{
    
    protected $_table_name  = 'file';
    protected $_primary_key = 'id';
    protected $_order_by    = 'id DESC';    
    
    public function __construct(){
        parent::__construct();
    }
    
    public function get_new(){
        $data = new stdClass();
        $data->name = '';
        $data->url = '';
        $data->description = '';
        $data->status = 1;
        return $data;
    }
    
    public function insert_file($url,$name='',$description='') {
        $data = array(
            'name' => $name,
            'url' => $url,
            'description' => $description,
            'status' => 1);
       return parent::save($data);
    }
    
    public function get_list_file_by_str_ids($str_ids) {
        $arrId = explode(',', $str_ids);
        $arrId = array_map('intval', $arrId);
        if (!$arrId) 
            return NULL;

        return parent::get_by('id IN('. implode(',', $arrId) .')');
    }
    
}