<?php
class UnitTest extends MY_Controller {

	public function __construct() {
		parent::__construct();
	}

	public function getDetailNews($id) {
		$this->load->model('news_model');
		$news = $this->news_model->getDetailNews(1);
		print_r($news);
		exit();
	}

	public function getListNewsWithNoCategory() {
		$this->load->model('news_model');
		$catId = 1;
		$offset = 0;
		$limit = 5;
		$list = $this->news_model->getListNews($catId,$offset,$limit);
		print_r($list);
		exit();
	}
    
    public function testLog()
    {
    	echo date('d/m/Y H:i:s', strtotime('first day of last month')), '<br>';
    	echo date('d/m/Y H:i:s', strtotime('last day of last month'));
    }

    public function getNewSalary()
    {
    	$this->load->model('news_salary_model');
    	$args = array();
    	$args['join_type'] = 'left';
    	print_r('<pre>');
    	print_r($this->news_salary_model->getListNews2SalaryByAuthor($args));
    	print_r('<pre>');
    	exit();
    }

    public function testLogView($id)
    {
    	$this->load->model('log_view_model');
    	print_r('<pre>');
    	print_r($this->log_view_model->getViewByNews($id));
    	print_r('<pre>');
    	exit();
    }

    public function testMyLog()
    {
        $this->load->library('mylog');
        $this->mylog->add_application_log('tesst log');
    }

    public function testGetListNewsByTime()
    {
        $this->load->model('news_model');
        $today = '2018-10-18';
        $day = explode('-', $today);
        $_startTime = mktime(0, 0, 0, $day[1], $day[2], $day[0]);
        $_endTime = mktime(23, 59, 59, $day[1], $day[2], $day[0]);
        $listNews = $this->news_model->getListNewsByTime($_startTime, $_endTime);
        print_r('<pre>');
        print_r($listNews);
        print_r('<pre>');
        exit();
    }

    public function reportViewByAuthor()
    {
        $params = Array
                    (
                        'author_id' => intval($this->input->get_post('author_id')),
                        'offset' => 0,
                        'limit' => 20,
                        'join_type' => 'left',
                        'is_writer' => NULL,
                        'start_date' => '2018-11-1',
                        'end_date' => '2018-11-30'
                    );
        $this->load->model('news_salary_model');
        print_r('<pre>');
        print_r($this->data['listNews'] = $this->news_salary_model->getListNews2SalaryByAuthor($params));
        print_r('<pre>');
        exit();

    }

    public function getPreviousMonth($month='', $year)
    {
        $prevMonth = $month - 1%12;
        echo ($prevMonth==0?($year-1):$year)."-".($prevMonth==0?'12':$prevMonth);
        exit();
    }

    public function getTime()
    {
        echo '2018-9-21 00:00:00 - ', strtotime('2018-9-21 00:00:00'), '<br>';
        echo '2018-10-20 23:59:59 - ', strtotime('2018-10-20 23:59:59');
    }

    public function getAuthorsNotRegSalary()
    {
        $args = array(
            'from_time' => '2018-9-20 00:00:00',
            'to_time' => '2018-10-21 23:59:59'
        );
        $this->load->model('news_model');
        print_r('<pre>');
        print_r($this->news_model->getListAuthorNotRegSalary($args));
        print_r('<pre>');
        exit();
    }

}