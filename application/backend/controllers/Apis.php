<?php
class Apis extends MY_Controller {
    
    public $result;
    
    function __construct() {
        parent::__construct();
        $this->result = array('code' => 0, 'msg' => 'success', 'data' => NULL);
    }

    public function appCounter()
    {
        $this->load->model('postrequest_model');
        $this->load->model('pointrefund_model');
        $data['post_pending_number'] = $this->postrequest_model->pendingNumber();
        $data['refund_pending_number'] = $this->pointrefund_model->pendingNumber();
        $this->jsonOutput(200, 'success', $data);
    }

    public function removeJourneyMilestone()
    {
        $data = $this->input->post();
        $id = ($data['id']) ? intval($data['id']) : NULL;
        
        try {
            $this->load->model('journey_milestone_model');
            
            if ( ! $this->journey_milestone_model->delete($id)) {
                throw new Exception("Can not save data", 1);
            }
            
        } catch (Exception $e) {
            $this->json_output($e->getCode(), $e->getMessage());
        }

        $this->json_output();
    }

    public function saveJourneyMilestone()
    {
        $data = $this->input->post();
        $id = ($data['id']) ? intval($data['id']) : NULL;
        $data['position'] = intval($data['position']);

        unset($data['id']);
        if ( ! $data['position']) $data['position'] = 1;
        if ($id) unset($data['journey_id']);

        $this->load->model('journey_model');
        $this->load->model('journey_milestone_model');
        
        try {
            if ( ! $savedId = $this->journey_milestone_model->save($data, $id)) {
                throw new Exception("Can not save data", 1);
            }
            
        } catch (Exception $e) {
            $this->json_output($e->getCode(), $e->getMessage());
        }

        $this->json_output();
    }
    
    function json_output($code=0,$msg='success',$data=NULL)
    {
        $this->result['code'] = $code;
        $this->result['msg'] = $msg;
        $this->result['data'] = $data;
        echo json_encode($this->result);
        exit();
    }
    
    function jsonOutput($code=0,$msg='success',$data=NULL)
    {
        $this->result['code'] = $code;
        $this->result['msg'] = $msg;
        $this->result['data'] = $data;
        echo json_encode($this->result);
        exit();
    }

    public function saveBatchNewSalary()
    {
        $authorId = ($this->input->get_post('author')) ? intval($this->input->get_post('author')) : NULL;
        $month = ($this->input->get_post('month')) ? intval($this->input->get_post('month')) : NULL;
        $year = ($this->input->get_post('year')) ? intval($this->input->get_post('year')) : NULL;
        if (! ($authorId && $month && $year)) {
            $this->json_output(-1, $this->lang->line('args_missing'));
        }
        if ($year>=date('Y') && $month>=date('m') && date('d') <= (DAY_OF_COUNTER+END_DAY_OF_MONTH)) {
            $this->json_output(-1, $this->lang->line('input_not_valid'));
        }

        //fetch previous month
        $lastMonth = $month-1%12;
        $prevYear = ($lastMonth == 0) ? ($year-1) : $year;
        $prevMonth = ($lastMonth==0) ? '12' : $lastMonth;
        $prevDay = END_DAY_OF_MONTH+1;
        $_startDate = "{$prevYear}-{$prevMonth}-{$prevDay}";
        $_endDate = $year . '-' . $month . '-' . END_DAY_OF_MONTH;

        $this->load->model('user_model');
        $this->load->model('news_model');
        $this->load->model('news_salary_model');

        if ( ! $author = $this->user_model->get($authorId, TRUE)) {
            $this->json_output(-1, $this->lang->line('author_not_exist'));
        }

        //duyet tat ca bai tac gia da chon nhom nhuan but
        $args = array(
            'start_date' => $_startDate,
            'end_date' => $_endDate,
            'author_id' => $author->id
        );
        $where = array();
        $where['author_id'] = $author->id;
        $where['start_time'] = strtotime($_startDate . ' 00:00:00');
        $where['end_time'] = strtotime($_endDate . ' 23:59:59');
        $allNewsByAuthorInTime = $this->news_model->getListNewsIdByAuthor($where);

        //Xac nhan thanh toan cho tat ca bai viet cha duoc xac nhan nhuan but
        $_byWhere = array(
            'news_id IN('. $allNewsByAuthorInTime .')' => NULL,
            'status' => STATUS_SALARY_WAITING
        );
        $listNewsIDSelectSalaryType = $this->news_salary_model->get_by($_byWhere);
        if ($listNewsIDSelectSalaryType) {
            foreach ($listNewsIDSelectSalaryType as $key => $val) {
                $_viewCount = $this->news_model->getViewByNewsId($val->news_id);
                $_dataUpdate = array();
                $_dataUpdate['view_count'] = $_viewCount;
                $_dataUpdate['status'] = STATUS_SALARY_PAID;
                $_dataUpdate['money'] = $this->__getMoneyQuotaByNewsType($val->type_id, $_viewCount);
                
                $this->news_salary_model->save($_dataUpdate, $val->id);
            }
        }
        /*
        if (! $this->news_salary_model->updateSalaryStatusByNews( STATUS_SALARY_PAID, explode(',', $allNewsByAuthorInTime) )) 
        {
            $this->json_output(-4, $this->lang->line('db_query_failed'));
        }*/
        
        //Duyet tat ca bai tac gia viet ma chua chon nhom nhuan but
        $_listNewsIdHasSalaryType = $this->news_salary_model->getListSalaryByNewsId(explode(',', $allNewsByAuthorInTime));
        if (!$_listNewsIdHasSalaryType) $_listNewsIdHasSalaryType = array();
        else
            $_listNewsIdHasSalaryType = explode(',', $_listNewsIdHasSalaryType);

        $newsIdNotSelectedSalaryType = array_diff( explode(',', $allNewsByAuthorInTime), $_listNewsIdHasSalaryType);
        
        if ($newsIdNotSelectedSalaryType) {
            //insert batch
            $insertData = array();
            foreach ($newsIdNotSelectedSalaryType as $_id) {
                $_news = $this->news_model->get($_id, TRUE);
                $insertData[] = array(
                    'news_id' => $_id,
                    'type_id' => 0,
                    'money' => 0,
                    'note' => '',
                    'status' => STATUS_SALARY_PAID,
                    'created_time' => date('Y-m-d H:i:s', time()),
                    'view_count' => $_news->hit_view,
                    'paid_date' => NULL
                );
            }
            if (! $this->news_salary_model->insertMultiRecord($insertData)) {
                $this->json_output(-4, $this->lang->line('db_query_failed'));
            }
        }
        $this->json_output();
    }
    
    function token_search_event()
    {
        $this->load->model('event_model');
        $str = $this->input->get('q');
        $data = $this->event_model->search($str);
        if(!$data) {
            $output[] = array('id' => 0, 'name' => 'not found');
            echo json_encode($output);
            exit();
        }
        foreach ($data as $key => $val) {
            $output[] = array(
                'id' => $val->id,
                'name' => $val->title
            );
        }
        echo json_encode($output);
        exit();
    }
    
    function token_search_golfer()
    {
        $this->load->model('golfer_model');
        $str = $this->input->get('q');
        $data = $this->golfer_model->search($str);
        if(!$data) {
            $output[] = array('id' => 0, 'name' => 'not found');
            echo json_encode($output);
            exit();
        }
        foreach ($data as $key => $val) {
            $output[] = array(
                'id' => $val->id,
                'name' => $val->name
            );
        }
        echo json_encode($output);
        exit();
    }
    
    function token_search_news()
    {
        $this->load->model('news_model');
        $str = $this->input->get('q');
        $data = $this->news_model->search($str);
        if(!$data) {
            $output[] = array('id' => 0, 'name' => 'not found');
            echo json_encode($output);
            exit();
        }
        foreach ($data as $key => $val) {
            $output[] = array(
                'id' => $val->id,
                'name' => $val->title
            );
        }
        echo json_encode($output);
        exit();
    }
    
    function token_search_video()
    {
        $this->load->model('video_model');
        $str = $this->input->get('q');
        $data = $this->video_model->search($str);
        if(!$data) {
            $output[] = array('id' => 0, 'name' => 'not found');
            echo json_encode($output);
            exit();
        }
        foreach ($data as $key => $val) {
            $output[] = array(
                'id' => $val->id,
                'name' => $val->title
            );
        }
        echo json_encode($output);
        exit();
    }
    
    function save_seo_option()
    {
        $this->load->model('seo_option_model');
        $id = (int)$this->input->post('id');
        if ( ! $id) $id = NULL;
        $type = $this->input->post('type');
        $meta_title = $this->input->post('meta_title');
        $meta_keyword = $this->input->post('meta_keyword');
        $meta_description = $this->input->post('meta_description');
        
        //check type already
        $_args = array('type' => $type);
        $check = $this->seo_option_model->get_by($_args);
        if ($check && ! $id)
            $this->json_output(-1,'Type đã tồn tại. Vui lòng sửa thông tin nếu cần');
        
        //Save data
        $data = array(
            'type' => $type,
            'meta_title' => $meta_title,
            'meta_keyword' => $meta_keyword,
            'meta_description' => $meta_description,
        );
        if ($this->seo_option_model->save($data,$id))
        {
            if($id) $_act = 'Updated';
            else $_act = 'Added';
            $this->history_model->add_history(NULL,$_act,$id,'seo_option');
            $this->json_output();
        }
        $this->json_output(-2,'Không thể cập nhật dữ liệu');
    }
    
    function returnNews()
    {
        $id = (int)$this->input->post('id');
        if(!$id)
        {
            $this->json_output(-1,'Lỗi! ID bài viết không đúng');
        }
        $me = $this->data['userdata'];
        
        $this->load->model('news_model');
        $this->load->model('history_model');
        $news = $this->news_model->get($id, true);
        
        //Neu bai da duoc dang, thi chi quyen Admin moi duoc quyen tra lai
        if($me['level'] > 1 && $news->status==1)
        {
            $this->json_output(-2,'Lỗi! Bài này đã được đăng, bạn không có quyền trả lại bài viết này.');
        }
        
        if($me['level'] > 3)
        {
            $this->json_output(-2,'Lỗi! Bạn không có quyền thực hiện thao tác này');
        }
        
        $data = array('status'=>STATUS_PENDING);
        if($this->news_model->save($data,$id))
        {
            $this->history_model->add_history(NULL,'return_news',$id,'news');
            $this->json_output();
        }
        $this->json_output(-2,'Lỗi! Không thể trả bài viết này');
    }

    public function getNews2Preview($id)
    {
        $this->load->model('news_model');
        $news = $this->news_model->get($id, true);
        $data = array('title' => $news->title, 'content' => $news->content, 'description' => $news->description);
        $this->json_output(0, 'success', $data);
    }
    
    public function getMyIp()
    {
        print_r('<pre>');
        print_r($_SERVER['REMOTE_ADDR']);
        print_r('</pre>');
        exit();
    }

    private function __getMoneyQuotaByNewsType($typeId, $view)
    {
        $this->load->model('news_type_model');

        if ( ! $typeId) 
            return 0;
        if( ! $type = $this->news_type_model->get($typeId, TRUE))
            return 0;
        if ( ! $type->view_money) 
            return 0;

        $moneyQuota = explode(',', $type->view_money);

        $viewQuota = config_item('pageview_quota'); 
        if ($view < min($viewQuota)) {
            return $type->fixed_money;
        }
        $_startView = 0;
        foreach ($viewQuota as $key => $value) {
            $moneyIndex = --$key;
            if ( $view < $value) {
                $_endView = $value;
                break;
            }
            $_startView = $value;
        }
        if ( ! isset($moneyQuota[$moneyIndex])) 
            return 0;

        $thisMoney = explode(':', $moneyQuota[$moneyIndex]);

        //Tinh so tien chinh xac theo view
        $fixed_money = intval($type->fixed_money);
        $_moneyStep = ($thisMoney[1]-$thisMoney[0]) / ($_endView-$_startView);
        $newsMoney = ceil(($view - $_startView)*$_moneyStep) + $thisMoney[0] + $fixed_money;
        
        return $newsMoney;
    }

    public function getMoneyQuotaByNewsType()
    {
        $this->load->model('news_type_model');
        $typeId = ($this->input->get_post('type')) ? intval($this->input->get_post('type')) : NULL;
        $view = ($this->input->get_post('view')) ? intval($this->input->get_post('view')) : 0;

        if ( ! $typeId) 
            $this->json_output(-1, 'Phân loại bài viết không tồn tại!');
        if( ! $type = $this->news_type_model->get($typeId, TRUE))
            $this->json_output(-2, 'Loại bài viết không tồn tại');
        if ( ! $type->view_money) 
            $this->json_output(-2, 'Loại bài viết chưa được định giá');

        $moneyQuota = explode(',', $type->view_money);

        $viewQuota = config_item('pageview_quota'); 
        if ($view < min($viewQuota)) {
            $data = array(
                'money_hint' => 'chưa đủ view',
                'money_auto' => intval($type->fixed_money)
            );
            $this->json_output(0, 'success', $data );
        }
        $_startView = 0;
        foreach ($viewQuota as $key => $value) {
            $moneyIndex = --$key;
            if ( $view < $value) {
                $_endView = $value;
                break;
            }
            $_startView = $value;
        }
        if ( ! isset($moneyQuota[$moneyIndex])) 
            $this->json_output(-2, 'Định mức chưa xác định');

        $thisMoney = explode(':', $moneyQuota[$moneyIndex]);

        //Tinh so tien chinh xac theo view
        $fixed_money = intval($type->fixed_money);
        $_moneyStep = ($thisMoney[1]-$thisMoney[0]) / ($_endView-$_startView);
        $newsMoney = ceil(($view - $_startView)*$_moneyStep) + $thisMoney[0] + $fixed_money;
        $data = array(
            'money_hint' => number_format($thisMoney[0]). ' - ' . number_format($thisMoney[1]),
            'money_auto' => $newsMoney
        );
        $this->json_output(0, 'success', $data );
    }

    public function updateNewsSalary()
    {

        $newsId = ($this->input->get_post('news_id')) ? intval($this->input->get_post('news_id')) : NULL;
        $news_type = ($this->input->get_post('news_type')) ? intval($this->input->get_post('news_type')) : NULL;
        $money = ($this->input->get_post('money')) ? intval($this->input->get_post('money')) : NULL;
        $note = ($this->input->get_post('note')) ? intval($this->input->get_post('note')) : NULL;
        $view = ($this->input->get_post('view')) ? intval($this->input->get_post('view')) : 0;
        $allowPayment = ($this->input->get_post('allowPayment')) ? intval($this->input->get_post('allowPayment')) : NULL;
        
        $this->load->model('news_salary_model');
        if ($recorded = $this->news_salary_model->get_by( array('news_id' => $newsId), TRUE)) {
            $data = array(
                'news_id' => $newsId,
                'type_id'=> $news_type,
                'money'=> $money,
                'view_count'=> $view,
                // 'note'=> $note,
                'status'=> $allowPayment
            );
            if ( ! $this->news_salary_model->save($data, $recorded->id))
            {
                $this->json_output(-4, 'Lỗi! Không cập nhật được dữ liệu');
            }
        }
        else {
            $data = array(
                'news_id'=> $newsId,
                'type_id'=> $news_type,
                'money' =>$money,
                // 'note'=> $note,
                'view_count'=> $view,
                'status'=> $allowPayment,
                'created_time'=> date('Y-m-d H:i:s', time()),
                'paid_date' =>NULL,
            );
            
            if ( ! $this->news_salary_model->save($data, NULL))
            {
                $this->json_output(-4, 'Lỗi! Không cập nhật được dữ liệu');
            }
        }
        $this->json_output();

    }

    public function saveNewsNote4Salary()
    {
        $newsId = intval($this->input->get_post('news_id'));
        $note = trim($this->input->get_post('note'));

        $this->load->model('news_salary_model');
        $data = array();
        $data['note'] = $note;
        if ( ! $recorded = $this->news_salary_model->get_by( array('news_id' => $newsId), TRUE )) {
            $data['news_id'] = $newsId;
            $this->news_salary_model->save($data, NULL);
        }
        else 
        {
            $this->news_salary_model->save($data, $recorded->id);
        }
        $this->json_output();
    }

    public function getPost()
    {
        $code = $this->input->get('code');
        $this->load->model('realnews_model');
        $news = $this->realnews_model->getPublicNewsByCode($code);
        if (!$news) 
            $this->jsonResponse(404, 'not found');
        else
            $this->jsonResponse(200, 'success', $news);
    }

    public function buyPost()
    {
        $code = $this->input->get('code');
        $accessToken = $this->input->get('accessToken');
        $userId = $this->input->get('userId');
        if (! $accessToken) 
            $this->jsonResponse(401, 'user not login');

        if ($userId) {
            $member = $this->member_model->get($userId, true);
        }


        $user = $this->userInfoByAccessToken();

        $this->load->model('realnews_model');
        $news = $this->realnews_model->getPublicNewsByCode($code);
        if (!$news) 
            $this->jsonResponse(404, 'not found');
        else
            $this->jsonResponse(200, 'success', $news);
    }
}