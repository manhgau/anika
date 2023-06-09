<?php
class Partner_model extends MY_Model
{
    protected $_table_name  = 'relation';
    protected $_primary_key = 'id';
    protected $_order_by    = 'id ASC';
    public    $rules        = array(
        'name'            => array(
            'field'   => 'name',
            'rules'   => 'trim|max_length[100]|required'
        ),
        'status'           => array(
            'field'   => 'status',
            'rules'   => 'trim|intval'
        ),
        'is_hot'           => array(
            'field'   => 'is_hot',
            'rules'   => 'trim|intval'
        ),
        'description' => array(
            'field'   => 'description',
            'rules'   => 'trim|max_length[250]'
        ),
        'meta_keyword'     => array(
            'field'   => 'meta_keyword',
            'rules'   => 'trim|max_length[250]'
        )
    );


    public function __construct()
    {
        parent::__construct();
    }

    public function get_list_partner($offset = 0, $limit = 10)
    {
        $this->db->select('*');
        $this->db->from($this->_table_name);
        $this->db->order_by('is_hot', 'DESC');
        $this->db->order_by('id', 'DESC');
        $this->db->where('status', 1);
        $this->db->limit($limit, $offset);
        $data = $this->db->get()->result();
        return $data;
    }
    public function get_detail_partner($id)
    {
        $this->db->select('*');
        $this->db->from($this->_table_name);
        $this->db->where('id', $id);
        $data = $this->db->get()->row();
        return $data;
    }

    // public function get_list_partner($offset=0, $limit=10){
    //     $this->db->select('*');
    //     $this->db->from($this->_table_name );
    //     $this->db->order_by ('is_hot', 'DESC'); 
    //     $this->db->where('status', 1);
    //     $this->db->limit($limit, $offset);
    //     $data = $this->db->get()->result();
    //     return $data;
    // }

    public function get_new()
    {
        $data = parent::getNew();
        $data->status = 1;
        $data->is_hot = 1;

        // $data->parent_id = 0;
        // $data->level = 1;
        return $data;
    }

    public function getList()
    {
        $query = $this->db->get($this->_table_name);
        return ($query->num_rows() > 0) ? $query->result_array() : null;
    }

    // public function getCategory(){
    //     $query = $this->db->get($this->_table_name);
    //     return ($query->num_rows() > 0 ) ? $query->result_array() : null;
    // }
    // public function get_category_with_parent ($id=NULL,$single=FALSE) {
    //     $this->db->select('category.*,c.title as parent_title,c.slug as parent_slug, c.id as parent_id');
    //     $this->db->join('category as c','category.parent_id = c.id','left');
    //     return parent::get($id,$single);
    // }
}
