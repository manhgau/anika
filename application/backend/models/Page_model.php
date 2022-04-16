<?php
class Page_model extends MY_Model{
    
    protected $_table_name = 'page';
    protected $_primary_key = 'id';
    protected $_order_by = 'order ASC';
    public    $rules = array(
        'title' => array(
            'field'   => 'title',
            'rules'   => 'trim|max_length[100]|required' ),
        'order' => array(
            'field'   => 'order',
            'rules'   => 'trim|is_natural' ),
        'parent_id' => array(
            'field'   => 'parent_id',
            'rules'   => 'trim|intval' ),
        'content' => array(
            'field'   => 'content',
            'rules'   => 'trim' )
        );

    public function __construct()
    {
        parent::__construct();
    }
    
    public function get_new()
    {
        $data = new stdClass();
        $data->title = '';
        $data->slug = '';
        $data->order = '';
        $data->content = '';
        $data->parent_id = 0;
        $data->meta_title = '';
        $data->meta_keyword = '';
        $data->meta_description = '';
        return $data;
    }
    
    public function get_with_parent($id=NULL,$single=FALSE) 
    {
        $this->db->select('p.*,page.title as parent_title,p.slug as parent_slug');
        $this->db->join('page as p','p.parent_id = page.id','right');
        return parent::get($id,$single);
    }
    
    public function get_no_parent() 
    {
        $this->db->select('id,title,slug');
        $this->db->where('parent_id',0);
        $list = parent::get();
        $data = array(0 => 'no parent');
        if(count($list)) {
            foreach ($list as $page) {
                $data[$page->id] = $page->title;
            }
        }
        return $data;
    }
    
    public function delete($id) 
    {
        parent::delete($id);
        $this->db->set('parent_id',0)->where('parent_id',$id)->update($this->_table_name);
    }
    
    public function column_exist($column_name) 
    {
        $str_query = "SHOW COLUMNS FROM " . $this->_table_name . " LIKE '".$column_name."'";
        return $this->db->query($str_query);
    }
    
    public function get_listing_page () 
    {
        return parent::get();
    }
    
    public function get_detail_page($page_id) 
    {
        $this->db->where('status',1);
        return parent::get($page_id,true);
    }
    
}