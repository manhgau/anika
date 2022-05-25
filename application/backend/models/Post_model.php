<?php
    class Post_model extends MY_Model {
        protected $_table_name  = 'news';
 
            public function list_post ($offset=0, $limit=10, $category_id=0, $is_hot=0){
            $this->db->select('a.*, b.*, c.title as category_name');
            $this->db->from('category_news' . ' as a');
            $this->db->join('news as b', 'a.news_id=b.id', 'inner');
            $this->db->join('category as c', 'a.category_id =  c.id', 'inner');
            if($category_id>0){
                $this->db->where('a.category_id',$category_id);
            }
            if($is_hot > 0){
            $this->db->where('b.is_hot',$is_hot);
            }
            $this->db->where('b.status',1);
            $this->db->order_by('a.news_id',"DESC");
            $this->db->limit($limit, $offset);
            $data = $this->db->get()->result();
            return $data;
        }

        public function get_category($id){
            $this->db->select();
            $this->db->from('category');
            $this->db->where('id',$id);
            $data = $this->db->get()->result();
            return $data;
        }
        public function detail_post($id){
            if (!$id){
                return NULL;
            }
            $this->db->select('a.*, b.*, c.title as category_name');
            $this->db->from('category_news' . ' as a');
            $this->db->join('news as b', 'a.news_id=b.id', 'inner');
            $this->db->join('category as c', 'a.category_id =  c.id', 'inner');
            $this->db->where('a.news_id',$id);
            $this->db->where('b.status',"1");
            $data = $this->db->get()->row();
            return $data;
        }
    }