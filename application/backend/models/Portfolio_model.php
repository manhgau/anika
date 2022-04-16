<?php
class Portfolio_model extends MY_Model {

    protected $_table_name  = 'portfolio';
    protected $_primary_key = 'id';
    protected $_order_by    = '`order` ASC, id DESC';
    public    $rules        = array (
        'name' => array(
            'field'   => 'name',
            'rules'   => 'trim|required' )
    );
    public $logoSize = '196x196';

    const STATUS_ACTIVE = 1;
    const STATUS_IN_ACTIVE = 2;

    public function getPortfolioStatusFilter()
    {
        return [
            self::STATUS_ACTIVE => 'Hiển thị',
        ];
    }

    public function __construct(){
        parent::__construct();
    }

    public function porfolioForm($portfolio)
    {
        return [
            'type' => [
                'name' => 'type',
                'type' => 'text',
                'class' => 'form-control',
                'required' => TRUE,
                'value' => $portfolio->type
            ],
            'logo' => [
                'name' => 'logo',
                'value' => $portfolio->logo,
                'type' => 'fileupload',
                'button_label' => 'chọn ảnh',
            ],
            'status' => [
                'name' => 'status',
                'type' => 'checkbox',
                'value' => self::STATUS_ACTIVE,
                'class' => 'simple',
                'checked' => !!($portfolio->status == self::STATUS_ACTIVE)
            ],
            'isHot' => [
                'name' => 'isHot',
                'value' => self::STATUS_ACTIVE,
                'type' => 'checkbox',
                'class' => 'simple',
                'checked' => ($portfolio->isHot==self::STATUS_ACTIVE)
            ],
            'order' => [
                'name' => 'order',
                'value' => $portfolio->order,
                'type' => 'number',
                'class' => 'form-control',
            ],
            'thinkzone_batch' => [
                'label' => 'Batch',
                'name' => 'thinkzone_batch',
                'value' => substr($portfolio->thinkzone_batch, 1, -1),
                'type' => 'text',
                'class' => 'form-control',
                'placeholder' => 'cách nhau bằng dấu ,',
            ],
            'bussiness_area' => [
                'label' => 'Vertical',
                'name' => 'bussiness_area',
                'value' => substr($portfolio->bussiness_area, 1, -1),
                'type' => 'text',
                'class' => 'form-control',
                'placeholder' => 'cách nhau bằng dấu ,',
            ],
            'vision_mission' => [
                'name' => 'vision_mission',
                'value' => $portfolio->vision_mission,
                'type' => 'textarea',
                'rows' => 3,
                'class' => 'form-control',
            ],
            'key_traction' => [
                'name' => 'key_traction',
                'value' => $portfolio->key_traction,
                'type' => 'textarea',
                'rows' => 3,
                'class' => 'form-control',
            ],
            'founder_name' => [
                'name' => 'founder_name',
                'value' => $portfolio->founder_name,
                'type' => 'text',
                'class' => 'form-control',
            ],
            'founder_image' => [
                'name' => 'founder_image',
                'value' => $portfolio->founder_image,
                'type' => 'fileupload',
                'class' => 'form-control',
                'button_label' => 'Chọn ảnh'
            ],
            'year_foundation' => [
                'name' => 'year_foundation',
                'value' => $portfolio->year_foundation,
                'type' => 'number',
                'class' => 'form-control',
            ]
        ];
    }

    public function getListPorfolio($status=NULL, $limit=10, $offset=0)
    {
        $this->db->select('id, name, logo, status, order, url, description, isHot, createTime, type');
        $this->db->from($this->_table_name);
        if ($status)
            $this->db->where('status', intval($status));
        $this->db->order_by('id', 'desc');
        $this->db->limit($limit, $offset);
        return $this->db->get()->result();
    }

    public function getNew()
    {
        $data = parent::getNew();
        $data->createTime = date('Y-m-d H:i:s', time());
        $data->status = 1;
        $data->isHot = 0;
        $data->type = '';
        $data->order = $this->getNextOrder();
        return $data;
    }

    public function getNextOrder($status=NULL)
    {
        $this->db->select('MAX(`order`) AS maxOrder');
        $this->db->from($this->_table_name);
        if ($status) 
            $this->db->where('status', intval($status));
        $result = $this->db->get()->row();
        return intval($result->maxOrder)+1;
    }

    public function addPortfolio($args)
    {
        $default = [
            'name' => '',
            'logo' => '',
            'status' => '',
            'order' => '',
            'url' => '',
            'description' => '',
            'type' => '',
        ];
        $data = array_merge($default); 
        $data['order'] = $this->getNextOrder();
        $data['createTime'] = date('Y-m-d H:i:s');
        return $this->save($data, NULL);
    }
}