<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Accelerator_model extends MY_Model {

    protected $_table_name  = 'accelerator';
    protected $_primary_key = 'id';
    protected $_order_by    = '`order` ASC, id DESC';
    public    $rules        = [
        'name' => [
            'field'   => 'name',
            'rules'   => 'trim|required'
        ],
        'order' => [
            'field'   => 'order',
            'rules'   => 'intval'
        ],
        'type' => [
            'field'   => 'type',
            'rules'   => 'trim'
        ],
        'logo' => [
            'field'   => 'logo',
            'rules'   => 'trim'
        ],
        'intro' => [
            'field'   => 'intro',
            'rules'   => 'trim'
        ],
        'description' => [
            'field'   => 'description',
            'rules'   => 'trim'
        ],
        'status' => [
            'field'   => 'status',
            'rules'   => 'intval'
        ],
    ];
    public $logoSize = '196x196';

    const STATUS_ACTIVE = 1;
    const STATUS_IN_ACTIVE = 2;
    const STATUS_DELETED = 2;
    protected $acceleratorStatus = [
        self::STATUS_ACTIVE => 'Công khai',
        self::STATUS_IN_ACTIVE => 'Đã khóa',
        self::STATUS_DELETED => 'Đã xóa',
    ];

    const GROUP_CLOUD = 'cloud_service';
    const GROUP_ACCOUNTING = 'accounting_service';
    const GROUP_BRAND_CONSULTING = 'brand_consulting';
    const GROUP_WORKSPACE_SUPPORT = 'workspace_support';
    const GROUP_LEGAL_SUPPORT = 'legal_support';
    const GROUP_PICKDECK_DESIGN = 'pickdeck_design';
    const GROUP_SALE_MARKETING = 'sale_marketing';
    const GROUP_INVESTMENT = 'investment';
    const GROUP_DATA_ANALITICS = 'data_analytics';

    protected $acceleratorGroup = [
        self::GROUP_CLOUD => [
            'value' => self::GROUP_CLOUD,
            'name' => 'Cloud Services',
            'icon' => 'ico ico-cloud'
        ],
        self::GROUP_ACCOUNTING => [
            'value' => self::GROUP_ACCOUNTING,
            'name' => 'Accounting<br/>Services',
            'icon' => 'ico ico-marketing'
        ],
        self::GROUP_BRAND_CONSULTING => [
            'value' => self::GROUP_BRAND_CONSULTING,
            'name' => 'Brand<br/>Consulting',
            'icon' => 'ico ico-operator'
        ],
        self::GROUP_WORKSPACE_SUPPORT => [
            'value' => self::GROUP_WORKSPACE_SUPPORT,
            'name' => 'Workspace Support',
            'icon' => 'ico ico-support'
        ],
        self::GROUP_LEGAL_SUPPORT => [
            'value' => self::GROUP_LEGAL_SUPPORT,
            'name' => 'Legal Support',
            'icon' => 'ico ico-legal'
        ],
        self::GROUP_PICKDECK_DESIGN => [
            'value' => self::GROUP_PICKDECK_DESIGN,
            'name' => 'Pickdeck Design',
            'icon' => 'ico ico-design'
        ],
        self::GROUP_SALE_MARKETING => [
            'value' => self::GROUP_SALE_MARKETING,
            'name' => 'Sale & Marketing Support',
            'icon' => 'ico ico-sales'
        ],
        self::GROUP_INVESTMENT => [
            'value' => self::GROUP_INVESTMENT,
            'name' => 'Recruitment',
            'icon' => 'ico ico-sales'
        ],
        self::GROUP_DATA_ANALITICS => [
            'value' => self::GROUP_DATA_ANALITICS,
            'name' => 'Data analytics',
            'icon' => 'ico ico-legal'
        ]
    ];

    public function getListAcceleratorGroup($group='')
    {
        return ($group) ? $this->acceleratorGroup[ $group ] : $this->acceleratorGroup;
    }

    public function getAgroupOptions($nullText='chọn nhóm')
    {
        $keys = array_keys($this->acceleratorGroup);
        $values = array_column($this->acceleratorGroup, 'name');
        return ['' => "--- {$nullText} ---"] + array_combine($keys, $values);
    }

    public function getPortfolioStatusFilter($status=NULL)
    {
        return ($status) ? $this->acceleratorStatus[$status] : $this->acceleratorStatus;
    }

    public function __construct(){
        parent::__construct();
    }

    public function getNew()
    {
        $data = parent::getNew();
        $data->createTime = date('Y-m-d H:i:s', time());
        $data->status = self::STATUS_ACTIVE;
        $data->type = '';
        $data->order = $this->getNextOrder();
        return $data;
    }

    public function acceleratorForm($data)
    {
        return [
            'name' => [
                'name' => 'name',
                'value' => $data->name,
                'type' => 'text',
                'class' => 'form-control',
                'required' => TRUE
            ],
            'type' => [
                'name' => 'type',
                'value' => $data->type,
                'type' => 'select',
                'options' => $this->getAgroupOptions(),
                'class' => 'form-control',
                'required' => TRUE
            ],
            'logo' => [
                'name' => 'logo',
                'value' => $data->logo,
                'type' => 'fileupload',
                'button_label' => 'chọn ảnh',
            ],
            'status' => [
                'name' => 'status',
                'type' => 'checkbox',
                'value' => self::STATUS_ACTIVE,
                'class' => 'simple',
                'checked' => !!($data->status == self::STATUS_ACTIVE)
            ],
            'order' => [
                'name' => 'order',
                'value' => intval($data->order),
                'type' => 'number',
                'class' => 'form-control',
            ],
            'intro' => [
                'name' => 'intro',
                'value' => $data->intro,
                'type' => 'text',
                'class' => 'form-control',
            ],
            'description' => [
                'name' => 'description',
                'value' => $data->description,
                'type' => 'textarea',
                'rows' => 3,
                'class' => 'form-control',
            ]
        ];
    }

    public function getAcceleratorById($id)
    {
    	if (!$id) return NULL;
    	return $this->get($id, TRUE);
    }

    public function getAcceleratorData()
    {
    	$filter = [
    		'status' => ($this->input->post('status')) ? intval($this->input->post('status')) : NULL,
    		'keyword' => ($this->input->post('keyword')) ? trim($this->input->post('keyword')) : NULL,
    	];
    	$offset = ($this->input->post('start')) ? intval($this->input->post('start')) : 0;
    	$limit = ($this->input->post('length')) ? intval($this->input->post('length')) : 500;

    	$where = [];
    	if ($filter['status']) 
    		$where['a.status'] = $filter['status'];

    	if ($filter['keyword'])
    	{
    		if ($id = intval($filter['keyword'])) 
    			$where['a.id'] = $id;
    		else
    			$where["a.name LIKE '{$filter['keyword']}%'"] = NULL;
    	}

    	$this->db->select('a.id, a.name, a.slugname, a.type, a.logo, a.intro, a.status, a.order');
    	$this->db->from("{$this->_table_name} AS a");
    	if ($where) $this->db->where($where);
    	$this->db->limit($limit, $offset);
    	$data = $this->db->get()->result();
    	if (!$data) 
    		return NULL;

    	foreach ($data as $key => $value) 
    	{
    		$value->status_name = $this->acceleratorStatus[ $value->status ];
    		$value->logo = getImageUrl( $value->logo );
    		$value->id = intval( $value->id );
    		$value->status = intval( $value->status );
            $value->type_name = $this->acceleratorGroup[ $value->type ]['name'];
    		$value->order = intval( $value->order );
    		$data[$key] = $value;
    	}
    	return $data;
    }

    public function saveAccelerator($id = NULL)
    {
    	$fields = ['name', 'type', 'logo', 'intro', 'description', 'status', 'order'];
    	$data = $this->array_from_post($fields);
    	$data['status'] = ($data['status']) ? self::STATUS_ACTIVE : self::STATUS_IN_ACTIVE;
    	$data['order'] = intval($data['order']);
    	$data['slugname'] = build_slug($data['name']);
    	$data = array_filter($data);
    	return ($id) ? $this->save($data, $id) : $this->save($data, NULL);
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
}

/* End of file Accelerator_model.php */
/* Location: ./application/backend/models/Accelerator_model.php */