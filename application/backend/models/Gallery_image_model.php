<?php
    class Gallery_image_model extends MY_Model {
        protected $_table_name  = 'gallery_image';
        protected $_primary_key = 'id';
        protected $_order_by    = 'position ASC';
        public    $rules        = array ();

        public function __construct() {
            parent::__construct();
        }

        public function get_new() {
            $data = new stdClass();
            $data->gallery_id = 0; 
            $data->image_url = ''; 
            $data->image_title = ''; 
            $data->image_alt = '';
            $data->caption = '';
            $data->position = 1;
            return $data;
        }

        public function getImagesByGallery ($gallery_id) {
            if(!$gallery_id) return FALSE;
            $this->db->where('gallery_id',$gallery_id);
            return $this->get();
        }
        
        public function removeImageInGallery($gallery_id,$excludes=array()) {
            $this->db->where('gallery_id', $gallery_id);
            $this->db->where_not_in('image_url',$excludes);
            $this->db->delete($this->_table_name);
        }
}