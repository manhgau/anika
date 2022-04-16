<?php
    class Member_detail_model extends MY_Model {

        protected $_table_name  = 'member_detail';
        protected $_primary_key = 'id';
        protected $_order_by    = 'id DESC';
        public    $rules        = array (
            'member_id' => array(
                'field'   => 'member_id',
                'rules'   => 'trim|required|intval' )
        );

        public function __construct(){
            parent::__construct();
        }

        public function get_new()
        {
            $data = new stdClass();
            $data->member_id = 0;
            $data->dan_toc = 'Kinh';
            $data->ton_giao = 'Không';
            $data->nghe_nghiep = '';
            $data->trinh_do = '';
            $data->chuyen_mon = '';
            $data->ly_luan_chinh_tri = 'Trung cấp';
            $data->ngoai_ngu = 'Không';
            $data->suc_khoe = 'Tốt';
            $data->di_nuoc_ngoai = 'Không';
            $data->thong_tin_gia_dinh = '<h4>Bố? (họ tên, năm sinh, nghề nghiệp, nơi ở, thông tin liên hệ)</h4><p>..................</p><h4>Mẹ? (họ tên, năm sinh, nghề nghiệp, nơi ở, thông tin liên hệ)</h4><p>..................</p><h4>Anh chị em ruột? (họ tên, năm sinh, nghề nghiệp, nơi ở, thông tin liên hệ)</h4><p>..................</p><h4>Vợ? (họ tên, năm sinh, nghề nghiệp, nơi ở, thông tin liên hệ)</h4><p>..................</p><h4>Con? (họ tên, năm sinh, nghề nghiệp, nơi ở, thông tin liên hệ)</h4><p>..................</p>';
            $data->tu_gioi_thieu = '';
            return $data;
        }

        public function get_detail_for_member($id)
        {
            return $this->get($id, TRUE);
        }
        
        public function get_detail_by_member_id($id)
        {
            $this->db->where('member_id', $id);
            $data = $this->get();
            if($data) return $data[0];
            return FALSE;
        }

}