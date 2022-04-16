<?php
    class Menu_model extends MY_Model{

        protected $_table_name  = 'menu';
        protected $_primary_key = 'id';
        protected $_order_by    = 'order ASC, id ASC';
        public $rules = array (
            'title'            => array(
                'field'   => 'title',
                'label'   => 'menu',
                'rules'   => 'trim|required' ),
            'url'            => array(
                'field'   => 'url',
                'label'   => 'Url',
                'rules'   => 'trim|required' ),
            'status'           => array(
                'field'   => 'status',
                'label'   => 'Status',
                'rules'   => 'trim|intval|required' )
        );  

        public function __construct(){
            parent::__construct();
        }

        public function get_new() {
            $data = new stdClass();
            $data->title = '';
            $data->url = '';
            $data->parent_id = 0;
            $data->level = 0;
            $data->group = 0;
            $data->order = 1;
            $data->icon_url='';
            return $data;
        }

        public function get_all_menu() {
            $this->db->where(array('status' => 1));
            return parent::get();
        }
        

        public function get_group_menu($group = 1) {
            $this->db->where('group',$group);
            return parent::get();
        }
        
        public function get_menu_by_parent ($parent=0) {
            $this->db->where('parent',$parent);
            $this->db->order('order ASC, id DESC');
            return parent::get();
        }

        public function get_list_menu_in_group ($group,$parent=0) {
            $this->db->where('group',$group);
            $this->db->where('parent_id',$parent);
            return parent::get();
        }

        public function get_list_childrent_menu ($parent) {
            $this->db->where( array('parent' => $parent) );
            return parent::get();
        }

        public function get_tree_navigation ($group_navi=1,$parent=0) {
            $this->db->where('group',$group_navi);
            $this->db->where('parent',$parent);
            $data = parent::get();
            if ( count($data)>0 ) {
                foreach ( $data as $key => $val ) {
                    echo 
                    $listing_navi[] = $val;
                    $this->get_tree_navigation($group_navi,$val->id);
                }
            }
            return $listing_navi;
        }

        public function get_tree_childs_menu ($parent=0) {
            $this->db->where('parent_id',$parent);
            $data = parent::get();
            if (count($data)>0) {
                foreach ($data as $key => $val) {
                    $childs = $this->get_list_childrent_menu($val->id);
                    if ( count($childs)>0 ) {
                        echo '<li><a href="'.$val->url.'">'.$val->title.'</a>';
                        echo '<ul class="sub-menu">';
                        foreach ($childs as $k => $v) {
                        echo '<li><a href="'.$v->url.'">'.$v->title.'</a></li>';
                        }
                        echo '</ul></li>';
                    } else {
                        echo '<li><a href="'.$val->url.'">'.$val->title.'</a></li>';
                    }
                    $this->get_tree_childs_menu($val->id);
                }
            }
        }
}