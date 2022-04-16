<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ourteam_model extends MY_Model 
{
	protected $_table_name  = 'our_team';
    protected $_primary_key = 'id';
    protected $_order_by = '`order` ASC, id DESC';
    protected $_data_type = [
    	'id' => 'int',
    	'status' => 'int',
    	'order' => 'int',
    	'name' => 'string',
    	'slugname' => 'string',
    	'group' => 'string',
    	'job_title' => 'string',
    	'description' => 'string',
    	'logo_worked' => 'string',
    	'image' => 'string',
    	'imageUrl' => 'file',
    ];

    public $rules = [
    	'name' => [
    		'field' => 'name',
    		'rules' => 'required|trim'
    	],
    	'status' => [
    		'field' => 'status',
    		'rules' => 'intval'
    	],
    	'order' => [
    		'field' => 'order',
    		'rules' => 'intval'
    	],
    ];
	
	const STATUS_ACTIVE = 1;
	const STATUS_IN_ACTIVE = 2;
	protected $modelStatus = [
		self::STATUS_ACTIVE => 'Công khai',
		self::STATUS_IN_ACTIVE => 'Ẩn',
	];

	public function getNew()
	{
		$data = parent::getNew();
		$data->order = $this->getNextOrder();
		$data->status = self::STATUS_ACTIVE;
		return $this->setData($data, TRUE);
	}

	public function getOurteamStatus($status)
	{
		return ($status) ? $this->modelStatus[$status] : $this->modelStatus;
	}

	const GROUP_MANAGER = 'manager';
	const GROUP_MEMBER = 'member';
	const GROUP_ADVISOR = 'advisor';
	const GROUP_INVESTMENT = 'investment';
	protected $teamGroup = [
		self::GROUP_MANAGER => [
			'value' => self::GROUP_MANAGER,
			'name' => 'Management team'
		],
		self::GROUP_MEMBER => [
			'value' => self::GROUP_MEMBER,
			'name' => 'Team member'
		],
		self::GROUP_ADVISOR => [
			'value' => self::GROUP_ADVISOR,
			'name' => 'Board of Advisor'
		],
		self::GROUP_INVESTMENT => [
			'value' => self::GROUP_INVESTMENT,
			'name' => 'Board of investment'
		],
	];

	public function getTeamGroup($group=NULL)
	{
		return ($group) ? $this->teamGroup[$group] : $this->teamGroup;
	}

	public function getTeamGroupFilter($defaultLabel='select group')
	{
		$keys = array_keys($this->teamGroup);
		$values = array_column($this->teamGroup, 'name');
		return ['' => "--- {$defaultLabel} ---"] + array_combine($keys, $values);
	}

	public function ourteamForm($data)
	{
		return [
			'name' => [
				'name' => 'name',
				'value' => $data->name,
				'type' => 'text',
				'required' => TRUE,
				'class' => 'form-control'
			],
			'group' => [
				'name' => 'group',
				'value' => $data->group,
				'type' => 'select',
				'options' => $this->getTeamGroupFilter(),
				'class' => 'form-control',
				'required' => TRUE
			],
			'job_title' => [
				'name' => 'job_title',
				'value' => $data->job_title,
				'type' => 'text',
				'class' => 'form-control'
			],
			'description' => [
				'name' => 'description',
				'value' => $data->description,
				'type' => 'textarea',
				'rows' => 3,
				'class' => 'form-control'
			],
			'status' => [
				'name' => 'status',
				'value' => $data->status,
				'type' => 'checkbox',
				'checked' => ($data->status==self::STATUS_ACTIVE),
				'class' => 'simple'
			],
			'order' => [
				'name' => 'order',
				'value' => $data->order,
				'type' => 'number',
				'class' => 'form-control'
			],
			'logo_worked' => [
				'name' => 'logo_worked',
				'value' => $data->logo_worked,
				'type' => 'fileupload',
				'button_label' => 'Chọn ảnh',
			],
			'image' => [
				'name' => 'image',
				'value' => $data->image,
				'type' => 'fileupload',
				'button_label' => 'chọn ảnh'
			],
			'linkedin' => [
				'name' => 'linkedin',
				'value' => $data->linkedin,
				'label' => 'LinkedIn',
				'type' => 'text',
				'class' => 'form-control'
			],
			'facebook' => [
				'name' => 'facebook',
				'value' => $data->facebook,
				'label' => 'Facebook',
				'type' => 'text',
				'class' => 'form-control'
			],
		];
	}

	public function saveMember($id=NULL)
	{
		$fields = $this->db->list_fields($this->_table_name);
		$fields = array_diff($fields, ['id', 'slugname']);
		// $fields[] = 'listImage';
		$data = $this->array_from_post($fields);
		$data['status'] = ($data['status']) ? self::STATUS_ACTIVE : self::STATUS_IN_ACTIVE;
		$data['slugname'] = build_slug($data['name']);
		// $data['logo_worked'] = implode(',', $data['listImage']);
		// unset($data['listImage']);
		if (!$data['order']) $data['order'] = $this->getNextOrder();

		return ($id) ? $this->save($data, $id) : $this->save($data, NULL);
	}

    public function getNextOrder($status=NULL)
    {
        $this->db->select('IF(`order` IS NULL, 0, MAX(`order`)) AS maxOrder');
        $this->db->from($this->_table_name);
        if ($status) 
            $this->db->where('status', intval($status));
        $result = $this->db->get()->row();
        return intval($result->maxOrder)+1;
    }

	public function getMemberById($id)
	{
		if (! $id) 
			return NULL;
		else {
			$data = $this->get($id, TRUE);
			return $this->setData($data, TRUE);
		}
	}

	public function getListMember()
	{
		$where = $filter = [];
		$filter['keyword'] = ($this->input->get_post('q')) ? $this->input->get_post('q') : NULL;
		$filter['status'] = ($this->input->get_post('status')) ? intval($this->input->get_post('status')) : NULL;
		$filter['group'] = ($this->input->get_post('group')) ? trim($this->input->get_post('group')) : NULL;
		$filter['offset'] = ($this->input->get_post('start')) ? trim($this->input->get_post('start')) : 0;
		$filter['limit'] = ($this->input->get_post('length')) ? trim($this->input->get_post('length')) : 500;

		if ($filter['status']) $where['a.status'] = $filter['status'];
		if ($filter['group']) $where['a.group'] = $filter['group'];
		if ($filter['keyword']) 
		{
			if ( $id=intval($filter['keyword']) )
				$where['a.id'] = $id;
			else
				$where["a.name LIKE '{$filter['keyword']}%'"] = NULL;
		}

		$this->db->select('a.id, a.name, a.slugname, a.group, a.status, a.image, a.image AS imageUrl, a.job_title, a.`order`');
		$this->db->from("{$this->_table_name} AS a");
		if ($where) $this->db->where($where);
		$this->db->limit($filter['limit'], $filter['offset']);
		$data = $this->db->get()->result();
		if (!$data) 
			return NULL;

		foreach ($data as $key => $value) 
		{
			$value = $this->setData($value, TRUE);
			$value->status_name = $this->modelStatus[ $value->status ];
			$value->group_name = $this->teamGroup[ $value->group ]['name'];
			$data[$key] = $value;
		}
		return $data;
	}

}

/* End of file Ourteam_model.php */
/* Location: ./application/backend/models/Ourteam_model.php */