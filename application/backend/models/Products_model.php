<?php
class Products_model extends MY_Model {
    protected $_table_name  = 'real_news';

    public function get_list_products(int $limit=10, int $offset=0, int $category_id = 0){
        $this->db->select('a.*, b.title AS category_name');
        $this->db->from($this->_table_name . ' as a');
        $this->db->join('category_products as b', 'a.category_id=b.id', 'inner');
        if($category_id>0){
            $this->db->where('a.category_id',$category_id);
        }
        $this->db->order_by('a.id',"DESC");
        $this->db->where('a.is_public',"1");
        $this->db->limit($limit, $offset);
        $data = $this->db->get()->result();
        return $data;
    }

    public function get_detail_product(int $id){
        if (!$id){
            return NULL;
        }
        $this->db->select('a.*, b.title AS category_name');
        $this->db->from($this->_table_name . ' as a');
        $this->db->join('category_products as b', 'a.category_id=b.id', 'left');
        $this->db->where('a.id',$id);
        $this->db->where('a.is_public',"1");
        $data = $this->db->get()->row();
        return $data;
    }
}