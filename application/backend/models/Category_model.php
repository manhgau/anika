<?php
class Category_model extends MY_Model{
    
    protected $_table_name  = 'category';
    protected $_primary_key = 'id';
    protected $_order_by    = 'id ASC';
    public    $rules        = array (
        'title'            => array(
            'field'   => 'title',
            'rules'   => 'trim|max_length[100]|required' ),
        'status'           => array(
            'field'   => 'status',
            'rules'   => 'trim|intval' ),     
        'meta_title' => array(
            'field'   => 'meta_title',
            'rules'   => 'trim|max_length[100]' ),   
        'meta_description' => array(
            'field'   => 'meta_description',
            'rules'   => 'trim|max_length[250]' ),   
        'meta_keyword'     => array(
            'field'   => 'meta_keyword',
            'rules'   => 'trim|max_length[250]' ),  
        'parent_id'        => array(
            'field'   => 'parent_id',
            'rules'   => 'trim|intval' )
        );
    
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_new() {
        $data = new stdClass();
        $data->title = '';
        $data->slug = '';
        $data->description = '';
        $data->meta_title = '';
        $data->meta_description = '';
        $data->meta_keyword = '';
        $data->status = 1;
        $data->parent_id = 0;
        $data->level = 1;
        return $data;
    }
    
    public function get_tree_categories ($parent_id=0) {
        $data = array();
        $_list_lv1 = $this->get_child_cats($parent_id);
        if(count($_list_lv1)) {
            foreach( $_list_lv1 as $_key => $_cat) {
                $data[] = $_cat;
                $childs = $this->get_tree_categories($_cat->id);
                if(count($childs)) {
                    foreach($childs as $_c) {
                        $data[] = $_c;
                    }
                }
            }
        }
        return $data;
    }
    
    public function get_category_with_parent ($id=NULL,$single=FALSE) {
        $this->db->select('category.*,c.title as parent_title,c.slug as parent_slug, c.id as parent_id');
        $this->db->join('category as c','category.parent_id = c.id','left');
        return parent::get($id,$single);
    }
    
    public function get_child_cats ($parent_id=0) {
        $this->db->where('parent_id',$parent_id);
        return parent::get();
    }
    
    public function get_category_perm_in($cats_id_perm)
    {
        $args = explode(',',$cats_id_perm);
        $this->db->select('id');
        $this->db->where_in('parent_id',$args);
        $this->db->or_where_in('id',$args);
        $this->db->where('status',1);
        $data = $this->get();
        if($data)
        {
            foreach ($data as $key => $val) {
                $result[] = $val->id;
            }
            return $result;
        }
        return FALSE;
    }
    
    public function get_all_category()
    {
        $this->db->select('id,title,slugname,parent_id,level');
        $list = $this->get();
        if ($list)
        {
            foreach ($list as $key => $val) {
                $data[$val->id] = $val;
            }
            return $data;
        }
        return FALSE;
    }
}