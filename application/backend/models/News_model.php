<?php
    class News_model extends MY_Model{

        protected $_table_name = 'news';
        protected $_primary_key = 'id';
        protected $_order_by = 'id DESC, public_time DESC';
        public    $rules = array(
            'title' => array(
                'field'   => 'title',
                'rules'   => 'trim|required' ),
            'description' => array(
                'field'   => 'description',
                'rules'   => 'trim' ),        
            'content' => array(
                'field'   => 'content',
                'rules'   => 'trim' ),     
            'meta_title' => array(
                'field'   => 'meta_title',
                'rules'   => 'trim' ),   
            'meta_description' => array(
                'field'   => 'meta_description',
                'rules'   => 'trim' ),   
            'meta_keyword' => array(
                'field'   => 'meta_keyword',
                'rules'   => 'trim|max_length[250]' ),
            'tags_id' => array(
                'field'   => 'meta_keyword',
                'rules'   => 'trim|max_length[250]' ),
            'public_time' => array(
                'field'   => 'public_time',
                'rules'   => 'trim' ),
            'thumbnail' => array(
                'field'   => 'thumbnail',
                'rules'   => 'trim' ),
        );

        public function __construct(){
            parent::__construct();
        }

        public function get_new(){
            $data = new stdClass();
            $data->id = NULL;
            $data->title = '';
            $data->slugname = '';
            $data->description = '';
            $data->content = '';
            $data->meta_title = '';
            $data->meta_description = '';
            $data->meta_keyword = config_item('default_meta_keyword');
            $data->tags_id = '';
            $data->public_time = date('Y-m-d H:i:s');
            $data->create_time = date('Y-m-d H:i:s');
            $data->update_time = date('Y-m-d H:i:s');
            $data->create_by = $this->session->userdata['id'];
            $data->update_by = $this->session->userdata['id'];
            $data->thumbnail = '';
            $data->category = 1;
            $data->status = 2;
            $data->hit_view = 0;
            $data->is_hot = 0;
            $data->images = '';
            $data->is_bot = 0;
            $data->source_bot = '';
            $data->source_url = '';
            $data->relate_news = '';
            $data->is_hot = 0;
            $data->is_popular = 0;
            $data->highlight_image = NULL;
            $data->highlight_alt = NULL;
            $data->display_author = 1;
            $data->display_ads_box = 1;
            return $data;
        }

        public function getAuthorHasArticle($args)
        {
            $default = array(
                'status' => STATUS_PUBLISHED,
                'from_time' => strtotime('first day of this month'),
                'to_time' => strtotime('last day of this month')
            );
            $params = array_merge($default, $args);

            $where = array();
            $where['status'] = $params['status'];
            $where['public_time >='] = $params['from_time'];
            $where['public_time <='] = $params['to_time'];

            $this->db->distinct();
            $this->db->select('create_by AS user_id');
            $this->db->where($where);
            $this->db->group_by('user_id');
            $this->db->limit(200);
            
            if (! $resultQuery = $this->get()) {
                return FALSE;
            }
            $data = array();
            foreach ($resultQuery as $key => $value) {
                $data[] = $value->user_id;
            }
            return $data;
        }

        public function get_detail_news($article_id) {
            return parent::get($article_id, true);
        }

        public function get_number_news($status=1,$category = 1) {
            $this->db->select('sum(status) as count');
            $this->db->where(array('status'=>1,'category'=>$category));
            $data = parent::get();
            return $data[0]->count;
        }

        public function get_list_news($offset=0,$limit=20,$status=array(1),$cat_id=array(),$is_hot=0,$is_popular=0,$authorId=NULL, $keyword=NULL) {
            $this->db->distinct();
            $this->db->select('a.*');
            $this->db->from('news AS a');
            $this->db->join('category_news AS b', 'a.id=b.news_id');
            $this->db->where_in('a.status', $status);
            if($cat_id) 
            {
                $this->db->where_in('b.category_id', $cat_id);
            }
            if($is_hot==1) $this->db->where('a.is_hot',1);
            if($is_popular==1) $this->db->where('ia.s_popular',1);
            if($authorId) $this->db->where('a.create_by',$authorId);
            if($keyword) $this->db->like('a.title',$keyword);
            $this->db->order_by('a.create_time DESC');
            $this->db->group_by('id');
            $this->db->limit($limit,$offset);
            $data = $this->db->get()->result();
            return $data;
        }
        
        public function reportNewsByUser($userId, $status=NULL)
        {
            $this->db->select('count(id) as number');
            $args = array('create_by' => $userId);
            if($status)
            {
                $args['status'] = $status;
            }
            $this->db->where($args);
            if($data = $this->get())
            {
                $result = $data[0];
                return $result->number;
            }
            return FALSE;
        }

        public function get_list_news_by_tag($tag_id,$offset=OFFSET,$limit=LIMIT) {
            $str_query = "SELECT * FROM article WHERE CONCAT(',',tags_id,',') LIKE '%,{$tag_id},%' AND status=1 ORDER BY id DESC LIMIT {$offset},{$limit}";
            $data = $this->db->query($str_query);
            return $data->result();
        }
        
        public function updateStatus($ids,$status) {
            $this->db->where_in('id',$ids);
            $args = array('status' => $status);
            if($this->db->update($this->_table_name,$args)) {
                return true;
            }
            return false;
        }
        
        public function getNewsWithIds($ids) {
            $args = explode(',',$ids);
            $this->db->where_in('id',$args);
            return $this->get();
        }
        
        public function search($q) {
            $this->db->distinct();
            $this->db->select('id, title, slugname, status, category, create_by, public_time, create_time');
            $this->db->like('title',$q);
            $this->db->group_by('id');
            $this->db->limit(100, 0);
            return $this->get();
        }
        
        public function get_hot_news() {
            $this->db->select('id,title,slugname');
            $this->db->where('is_hot',1);
            $this->db->limit(10,0);
            return $this->get();
        }
        
        public function get_popular_news() {
            $this->db->select('id,title,slugname');
            $this->db->where('is_popular',1);
            $this->db->limit(10,0);
            return $this->get();
        }
        
        public function get_my_posted($user_id,$offset,$limit, $status=NULL)
        {
            $this->db->select('id,title,slugname,thumbnail,category,tags_id,status,is_hot,is_popular,create_time,public_time,hit_view');
            $this->db->where('create_by',$user_id);
            if($status)
            {
                $this->db->where('status', $status);
            }
            $this->db->limit($limit,$offset);
            return $this->get();
        }
        
        public function news_history_by_id($ids=array())
        {  
            $this->db->select('id, title');
            $this->db->where_in('id', $ids);
            $data = $this->get();
            foreach ($data as $key => $val) {
                $result[$val->id] = $val;
            }
            return $result;
        }
        
        public function getReportByAuthor($startTime, $endTime)
        {
            $where = array(
                'public_time <=' => $endTime,
                'public_time >=' => $startTime
            );
            $this->db->select('create_by, status, count(id) AS number');
            $this->db->where($where);
            $this->db->group_by('create_by, status');
            return $this->get();
        }
        
        public function getListNewsData($params=array())
        {
            $defaultParams = ['offset'=>0, 'limit'=>20];
            $params = array_merge($defaultParams, $params);
            $where = array();
            if(isset($params['status']) && $params['status'])
                $where['status'] = $params['status'];
            else {
                $this->db->where_in('status', array(1,2,3));
            }
            if(isset($params['create_by']) && $params['create_by'])
                $where['create_by'] = $params['create_by'];
            if(isset($params['category']) && $params['category'])
                $where['category'] = $params['category'];
            
            if($where) $this->db->where($where);
            if(isset($params['keyword']) && $params['keyword'])
                $this->db->like('title', $params['keyword']);
            $this->db->order_by('create_time DESC');
            $this->db->limit($params['limit'], $params['offset']);
            $result = $this->db->get($this->_table_name);
            return $result->result_array();
        }

        public function getListNewsByTime($start_time, $end_time)
        {
            $where = array();
            $where['public_time >='] = $start_time;
            $where['public_time <='] = $end_time;
            $where['status'] = 1;
            //$where['public_time <='] = time();
            $this->db->select('id, slugname, title, create_time, public_time');
            $this->db->from($this->_table_name);
            $this->db->where($where);
            $this->db->order_by('public_time DESC');
            $query = $this->db->get();
            $this->db->reset_query();
            return $query->result_array();
        }

        public function getReportNewsByStatus()
        {
            $this->db->select('COUNT(id) AS number, status');
            $this->db->from($this->_table_name);
            $this->db->group_by('status');
            $data = $this->db->get()->result();
            $result = array();
            foreach ($data as $key => $value) {
                $result[$value->status] = $value->number;
            }
            return $result;
        }

        public function countNewsNumber($params=NULL)
        {
            $defaults = array(
                'status' => STATUS_PUBLISHED
            );
            $filters = array_merge($defaults, $params);

            if ($filters['create_by']) 
                $where['create_by'] = $filters['create_by'];
            if (isset($filters['start_time'])) 
                $where['public_time >='] = $filters['start_time'];
            if (isset($filters['end_time'])) 
                $where['public_time <'] = $filters['end_time'];
            if (isset($filters['writer']) && $filters['writer'] == '0') 
                $where['source_url !='] = '';
            if (isset($filters['writer']) && $filters['writer'] == '1') 
                $where['source_url'] = '';

            $where['status'] = STATUS_PUBLISHED;
            $minViewCatchMoney = min( config_item('pageview_quota') );
            // $where['hit_view <'] = $minViewCatchMoney;

            $this->db->select('SUM(IF(news.hit_view > '.$minViewCatchMoney.', news.status, 0)) AS gt_number, SUM(IF(news.hit_view < '.$minViewCatchMoney.', news.status, 0)) AS lt_number, SUM(IF(news.source_url IS NULL, 1, 0)) AS tu_viet,  SUM(IF(news.source_url IS NOT NULL, 1, 0)) AS tong_hop, SUM(hit_view) AS sum_view');
            $this->db->where($where);
            $data = $this->get(NULL, TRUE);
            return $data;
        }

        public function reportBySource($params=array())
        {
            $defaults = array(
                'status' => STATUS_PUBLISHED,
                'create_by' => AUTHOR_ID
            );
            $filters = array_merge($defaults, $params);
            if ($filters['create_by']) 
                $where['create_by'] = $filters['create_by'];
            if (isset($filters['start_time'])) 
                $where['public_time >='] = $filters['start_time'];
            if (isset($filters['end_time'])) 
                $where['public_time <'] = $filters['end_time'];
            if (isset($filters['status'])) 
                $where['status'] = $filters['status'];

            $this->db->select('COUNT(id) AS number, source_url');
            $this->db->from($this->_table_name);
            $this->db->where($where);
            $this->db->group_by('source_url');
            $resutlQuery = $this->db->get()->result_array();
            $data = array();

        }

        public function updateView($newsId='')
        {
            $queryStr = "UPDATE news SET hit_view = (SELECT SUM(view) FROM log_view WHERE news_id={$newsId}) WHERE id={$newsId}";
            $query = $this->db->query($queryStr);
        }

        public function getListAuthorNotRegSalary($args=array())
        {
            $defaults = array(
                'from_time' => strtotime('first day of this month'),
                'to_time' => strtotime('last day of this month')
            );
            $params = array_merge($defaults, $args);

            $publicStart = $params['from_time'];
            $publicEnd = $params['to_time'];
            $dateStart = date('Y-m-d', $publicStart);

            $queryStr = 'SELECT DISTINCT n.create_by';
            $queryStr .= ' FROM news AS n INNER JOIN user AS u ON n.create_by=u.id';
            $queryStr .= ' WHERE n.status=1 AND n.public_time >=' . $publicStart . ' AND n.public_time <=' . $publicEnd;
            $queryStr .= ' AND n.id NOT IN (SELECT news_id FROM news_salary WHERE DATE(created_time) >= \''.$dateStart.'\')';
            $queryStr .= ' LIMIT 100';

            $result = $this->db->query($queryStr)->result();
            if ( ! $result) 
                return FALSE;
            $data = array();
            foreach ($result as $key => $value) {
                $data[] = $value->create_by;
            }
            return $data;
        }

        public function getListNewsIdByAuthor($args)
        {
            $defaults = array(
                'start_time' => strtotime('first day of this month'),
                'end_time' => strtotime('last day of this month')
            );
            $params = array_merge($defaults, $args);
            $where = array(
                'status' => STATUS_PUBLISHED,
                'create_by' => $params['author_id'],
                'public_time >=' => $params['start_time'],
                'public_time <=' => $params['end_time']
                // 'hit_view <' => min( config_item('pageview_quota') )
            );
            //Default: GROUP_CONCAT has max lenght: 1024
            $this->db->query('SET @@group_concat_max_len = 100000');
            $this->db->select('GROUP_CONCAT(id) AS id_str');
            $this->db->where($where);
            $resultQuery = $this->get(NULL, TRUE);
            return ($resultQuery) ? $resultQuery->id_str : NULL;
        }

        public function getViewByNewsId($id)
        {
            $this->db->select('hit_view');
            $data = $this->get($id, TRUE);
            return $data->hit_view;
        }
    }