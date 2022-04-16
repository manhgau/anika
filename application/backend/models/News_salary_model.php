<?php
class News_salary_model extends MY_Model {

    protected $_table_name  = 'news_salary';
    protected $_primary_key = 'id';
    protected $_order_by    = 'id DESC, created_time DESC';
    public    $rules        = array (
        'news_id' => array(
            'field'   => 'news_id',
            'rules'   => 'intval|required' ),
        'type_id' => array(
            'field'   => 'type_id',
            'rules'   => 'intval|required' ),
    );

    public function __construct(){
        parent::__construct();
    }

    public function get_new()
    {
        $data = new stdClass();
        $data->news_id = '';
        $data->type_id = '';
        $data->money = NULL;
        $data->note = NULL;
        $data->view_count = START_COUNTER;
        $data->status = STATUS_SALARY_WAITING;
        $data->created_time = date('Y-m-d H:i:s', time());
        $data->paid_date = NULL;
        return $data;
    }

    public function updateSalaryStatusByNews($status=STATUS_SALARY_PAID, $newsId=NULL)
    {
        if ( ! $newsId) 
            return FALSE;
        $dataUpdate = array('status' => $status);
        if ( is_array($newsId) ) {
            $this->db->where_in('news_id', $newsId);
            $this->db->where('status', STATUS_SALARY_WAITING);
        }
        else {
            $this->db->where('news_id', $newsId);
            $this->db->where('status', STATUS_SALARY_WAITING);
        }
        return $this->db->update($this->_table_name, $dataUpdate);
    }

    public function insertMultiRecord($data)
    {
        return $this->db->insert_batch($this->_table_name, $data);
    }

    public function getListSalaryByNewsId($newsId)
    {
        if (!$newsId)
            return FALSE;
        $this->db->select('GROUP_CONCAT(news_id) AS newsIds');
        $this->db->where_in('news_id', $newsId);
        $data = $this->get(NULL, TRUE);
        return $data->newsIds;
    }

    public function getAuthorHasConfirmSalaryArticle($args)
    {
        $defaults = array(
            'status' => STATUS_SALARY_PAID,
            'from_time' => strtotime('first day of this month'),
            'to_time' => strtotime('last day of this month')
        );
        $params = array_merge($defaults, $args);

        $where = array();
        $where['n.status'] = $params['status'];
        $where['n.public_time >='] = $params['from_time'];
        $where['n.public_time <='] = $params['to_time'];
        $where['ns.status !='] = STATUS_SALARY_WAITING;

        $this->db->distinct();
        $this->db->select('n.create_by AS user_id');
        $this->db->from('news AS n');
        $this->db->join('news_salary AS ns', 'n.id=ns.news_id', 'both');
        $this->db->where($where);
        $this->db->group_by('user_id');
        $this->db->limit(100);
        
        if (! $resultQuery = $this->db->get()->result()) {
            return NULL;
        }
        $data = array();
        foreach ($resultQuery as $key => $value) {
            $data[] = $value->user_id;
        }
        return $data;
    }

    public function getDetail($news_id)
    {
        $data = $this->get_by( array('news_id' => $news_id) , TRUE);
        return ($data) ? $data : $this->get_new();
    }


    public function getListNews2SalaryByAuthor($params=array())
    {
        $defaults = array(
            'start_date' => date('Y-m-d', strtotime('first day of last month')),
            'end_date' => date('Y-m-d', strtotime('last day of last month')),
            'author_id' => AUTHOR_ID,
            'status' => STATUS_PUBLISHED,
            'type_id' => NULL,
            'offset' => OFFSET,
            'limit' => LIMIT,
            'join_type' => 'inner'
        );

        $conds = array_merge($defaults, $params);
        if ($conds['author_id'] == 9) {
            $conds['status'] = 3;
        }

        $where = array();
        if ($conds['author_id']) 
            $where['n.create_by'] = $conds['author_id'];
        if ($conds['status']) 
            $where['n.status'] = $conds['status'];
        if ($conds['type_id']) 
            $where['ns.type_id'] = $conds['type_id'];
        if ($conds['start_date']) 
            $where['n.public_time >'] = strtotime( $conds['start_date'] . ' 00:00:00' );
        if ($conds['start_date']) 
            $where['n.public_time <'] = strtotime( $conds['end_date'] . ' 23:59:59' );
        if( isset($conds['min_view']) && $conds['min_view'] )
            $where['n.hit_view >='] = $conds['min_view'];
        if( isset($conds['max_view']) && $conds['max_view'] )
            $where['n.hit_view <'] = $conds['max_view'];
        if( isset($conds['is_writer']) && $conds['is_writer']=='true')
            $where['n.source_url IS NULL'] = NULL;
        if( isset($conds['is_writer']) && $conds['is_writer']=='false')
            $where['n.source_url IS NOT NULL'] = NULL;

        $newsSelectedFields = 'n.id, n.title, n.slugname, n.status AS n_status, n.create_by, n.public_time, n.create_time, n.category, n.hit_view, n.source_url';
        $salarySelectedFields = 'ns.id AS ns_id, ns.type_id, ns.money, ns.status AS ns_status, ns.view_count, ns.note';
        
        $this->db->select($newsSelectedFields . ', '. $salarySelectedFields);
        $this->db->from('news AS n');
        $this->db->join('news_salary AS ns', 'n.id = ns.news_id', $conds['join_type']);
        $this->db->where($where);
        $this->db->order_by('n.hit_view DESC, n.public_time DESC');
        $this->db->limit($conds['limit'], $conds['offset']);
        $data = $this->db->get()->result();

        return $data;
    }

    public function getReportByAuthor($args=array())
    {
        $defaults = array(
            'from_time' => strtotime('first day of last month'),
            'to_time' => strtotime('last day of last month'),
            'author_id' => AUTHOR_ID,
            'status' => STATUS_PUBLISHED,
            'type_id' => NULL,
            'offset' => OFFSET,
            'limit' => LIMIT,
            'join_type' => 'inner'
        );

        $params = array_merge($defaults, $args);
        $where = array();
        $where['n.status'] = 1;
        $where['n.public_time >='] = $params['from_time'];
        $where['n.public_time <='] = $params['to_time'];
        $where['ns.status !='] = STATUS_SALARY_WAITING;

        $this->db->select('n.create_by AS user_id, u.name, u.email, SUM(money) AS sum_money, COUNT(ns.news_id) AS news_number');
        $this->db->from('news AS n');
        $this->db->join('user AS u', 'n.create_by=u.id');
        $this->db->join('news_salary AS ns', 'n.id=ns.news_id');
        $this->db->where($where);
        $this->db->order_by('sum_money DESC');
        $this->db->group_by('user_id');
        $this->db->limit(100);
        return $this->db->get()->result();
    }

    public function updateNewsSalaryStatus($args = array())
    {
        if ( ! $args) 
            return FALSE;

        $_startPublicTime = strtotime( $args['start_date'] . ' 00:00:00' );
        $_endPublicTime = strtotime( $args['end_date'] . ' 23:59:59' );
        $updatedStatus = STATUS_SALARY_PAID;

        $queryStr = 'UPDATE news_salary SET `status`='.$updatedStatus.' WHERE news_id IN (SELECT n.id FROM news AS n INNER JOIN news_salary AS ns ON n.id=ns.news_id AND n.public_time >= '. $_startPublicTime .' AND n.public_time <= '.$_endPublicTime.' AND n.create_by='. $args['author_id'] .')';
        return $queryStr;

        if ($this->db->query($queryStr)) {
            return TRUE;
        }
        return FALSE;
    }
}