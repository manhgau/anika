<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Location_model extends MY_Model {

    private $tbProvince = 'vtp_province';
    private $tbRegion = 'region';
    private $tbDistrict = 'vtp_district';
    private $tbWard = 'vtp_ward';

    protected $_data_type = [
        'id' => 'int',
        'province_id' => 'int',
        'district_id' => 'int',
        'region_id' => 'int',
        'area_id' => 'int',
        'country_id' => 'int'
    ];

    function __construct()
    {
        parent::__construct();
    }
    public function getProvince($id=NULL) {
        if (! $id) {
            $data = $this->db->order_by('id ASC')->get($this->tbProvince)->result();
            foreach ($data as $key => $value) {
                $value = $this->setData($value, true);
                $data[$key] = $value;
            }
            return $data;
        }

        if (is_array($id)) {

            $this->db->select('id, name, code, area_id, region_id');
            $this->db->from($this->tbProvince);
            $this->db->where_in('id', $id);
            $this->db->limit(count($id));
            $data = $this->db->get()->result();
            foreach ($data as $key => $value) {
                $value = $this->setData($value, true);
                $data[$key] = $value;
            }
            return $data;
        }
        else
            return $this->setData($this->db->get_where($this->tbProvince, ['id'=>$id], 1)->row(), true);
    }

    public function getProvinByRegion(int $id) {
        return $this->db->get_where($this->tbProvince, ['region_id'=>$id])->result();
    }

    public function getRegion($id=NULL) {
        if (! $id) 
            return $this->db->get($this->tbRegion)->result();

        if (is_array($id)) {

            $this->db->from($this->tbRegion);
            $this->db->where_in('id', $id);
            $this->db->limit(count($id));
            return $this->db->get()->result();
        }
        else
            return $this->db->get_where($this->tbRegion, ['id'=>$id], 1)->row();
    }

    public function regionSelectOption($nullText='vùng/miền')
    {
        $region = json_decode(json_encode($this->getRegion()), true);
        $keys = array_column($region, 'id');
        $values = array_column($region, 'name');
        return ['' => "--- {$nullText} ---"] + array_combine($keys, $values);
    }

    public function getDistrict($id=NULL) {

        if (is_array($id)) {

            $this->db->select('id, name, code, fullname, province_id, province_code, province_name');
            $this->db->from($this->tbDistrict);
            $this->db->where_in('id', $id);
            $this->db->limit(count($id));
            return $this->db->get()->result();
        }
        else
            return $this->setData($this->db->get_where($this->tbDistrict, ['id'=>$id], 1)->row(), true);
    }

    public function getDistrictByProvince($id=NULL) {
        $this->db->select('id, name, code, fullname, province_id, province_code, province_name');
        $this->db->from($this->tbDistrict);
        $this->db->where('province_id', $id);
        $this->db->limit(100);
        return $this->db->get()->result();
    }

    public function provinceSelectOption($nullText='tỉnh/thành phố')
    {
        $province = json_decode(json_encode($this->getProvince()), true);
        $keys = array_column($province, 'id');
        $values = array_column($province, 'name');
        return ['' => "--- {$nullText} ---"] + array_combine($keys, $values);
    }

    public function districtSelectOption($provinceId, $nullText='huyện/quận')
    {
        $province = json_decode(json_encode($this->getDistrictByProvince($provinceId)), true);
        $keys = array_column($province, 'id');
        $values = array_column($province, 'name');
        return ['' => "--- {$nullText} ---"] + array_combine($keys, $values);
    }

    public function wardSelectOption($districtId, $nullText='xã/phường')
    {
        $province = json_decode(json_encode($this->getWardByDistrict($districtId)), true);
        $keys = array_column($province, 'id');
        $values = array_column($province, 'name');
        return ['' => "--- {$nullText} ---"] + array_combine($keys, $values);
    }

    function getWardByDistrict($district_id)
    {
        return $this->db->get_where($this->tbWard, ['district_id'=>$district_id], 100)->result();
    }

    function getWard($id)
    {
        return $this->db->get_where($this->tbWard, ['id'=>$id])->row();
    }

}

/* End of file Location_model.php */
/* Location: ./application/models/Location_model.php */