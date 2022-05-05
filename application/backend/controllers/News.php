<?php
    class News extends MY_Controller {        
        public function __construct() 
        {
            parent::__construct();
            $this->load->model('news_model');
            $this->load->model('category_model');
            $this->load->model('category_news_model');
            $this->load->model('tag_model');
            $this->load->model('event_news_model');
            $this->load->model('golfer_news_model');
            $this->load->model('user_model');
            $this->load->model('news_type_model');
            $this->load->model('log_view_model');
            $this->load->model('news_salary_model');
            $this->load->model('news_version_model');

            //Breadcrumbs
            $this->data['breadcrumbs']['Tin tức'] = base_url('news');
            $this->allAuthor = $this->user_model->get_list_author();
        }

        public function compareVersion($id)
        {
            $id = intval($id);
            if ( ! $news = $this->news_model->get($id, TRUE)) {
                redirect(base_url());
            }
            $this->data['news'] = $news;
            
            /*if (! $oldVersionNews = $this->news_version_model->getBackupByNews($id))
            {
                echo 'Bài viết chưa được sửa lần nào!';
                exit();
            }*/

            $leftId = ($this->input->get_post('left_version')) ? $this->input->get_post('left_version') : NULL;

            if ($oldVersionNews = $this->news_version_model->getBackupByNews($id)) {
                $this->data['versions'] = $oldVersionNews;
                $this->data['leftId'] = $leftId;
                if(!$leftId)
                {
                    //Fetch lastest updated
                    $lastestUpdate = end($oldVersionNews);
                    $leftId = $lastestUpdate->id;
                }

                foreach ($oldVersionNews as $key => $value) {
                    if ($value->id == $leftId) {
                        $leftNews = $value;
                        $rightIndex = ++$key;
                        $rightNews = (isset($oldVersionNews[$rightIndex])) ? $oldVersionNews[$rightIndex] : $news;
                        break;
                    }
                }
                $this->data['leftNews'] = $leftNews;
                $this->data['rightNews'] = $rightNews;
                $this->data['leftAuthor'] = $this->user_model->get($leftNews->create_by, TRUE);
                if ($leftNews->category) {
                    $this->data['leftCat'] = $this->category_model->get($leftNews->category, TRUE);
                }
                if ($rightNews->category) {
                    $this->data['rightCat'] = $this->category_model->get($rightNews->category, TRUE);
                }
            }

            //load view template
            $this->data['meta_title'] = 'Tra cứu lịch sử bài viết: ' . $news->id;
            $this->data['sub_view'] = 'admin/news/compare-version';
            $this->data['sub_js'] = $this->data['sub_view'] . '-js';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function index() 
        {

            if ( ! $this->has_permission('view')) $this->not_permission();

            //Fetch category
            $this->data['category_id'] = $category_id = isset($_GET['cat']) ? $_GET['cat'] : 0;
            $_filter_category = array();
            if($category_id!=0) {
                $category = $this->category_model->get($category_id,TRUE);
                $list_categories[$category_id] = $category;
                $this->data['breadcrumbs'][$category->title] = base_url('admin/news/?cat='.$category->id);
                $_filter_category[] = $category_id;
            }
            $is_hot = ($this->input->get_post('is_hot')) ? $this->input->get_post('is_hot') : 0 ;
            $is_popular = ($this->input->get_post('is_popular')) ? $this->input->get_post('is_popular') : 0 ;
            $status = ($this->input->get_post('status')) ? $this->input->get_post('status') : 0 ;
            $authorName = ($this->input->get_post('authorName')) ? $this->input->get_post('authorName') : '' ;
            $keyword = ($this->input->get_post('keyword')) ? $this->input->get_post('keyword') : '' ;

            $this->data['filters']['category'] = $category_id;
            $this->data['filters']['is_hot'] = $is_hot;
            $this->data['filters']['is_popular'] = $is_popular;
            $this->data['filters']['status'] = $status;
            $this->data['filters']['authorName'] = $authorName;
            $this->data['filters']['keyword'] = $keyword;

            $_status_filters = array(STATUS_PUBLISHED, STATUS_PENDING);
            if($status) $_status_filters = array($status);

            //Fetch all author
            $authorFilterId = NULL;
            $this->data['authors'] = $authors = $this->user_model->get_list_author();
            foreach ($authors as $key => $val) {
                if($val->name == $authorName)
                {
                    $authorFilterId = $val->id;
                }
            }

            //Pagination Action
            $paging['current'] = (int)$this->input->get_post('page');
            if( ! $paging['current']) $paging['current'] = 1;
            $paging['limit'] = 50;
            $paging['next'] = 1+$paging['current'];
            $paging['prev'] = $paging['current']-1;
            if($paging['current'] <= 1) $paging['prev'] = 0;
            $this->data['paging'] = $paging;
            //fetch all news
            $offset = ($paging['current']-1)*$paging['limit'];

            $this->data['articles'] = array();
            $list_articles = $this->news_model->get_list_news($offset,$paging['limit'],$_status_filters,$_filter_category,$is_hot,$is_popular,$authorFilterId, $keyword);

            //Fetch tree category filter
            $this->data['tree_categories'] = $this->category_model->get_tree_categories();

            //fetch category for article
            foreach ($list_articles as $key => $val) {
                $_itemCats = NULL;
                $_categoryId = $this->category_news_model->getCategoryByNews($val->id);
                if ($_categoryId) {
                    foreach ($_categoryId as $_key => $_val) {
                        if( ! isset($list_categories[$_val->category_id]))
                            $list_categories[$_val->category_id] = $this->category_model->get($_val->category_id, TRUE);
                        $_itemCats[] = $list_categories[$_val->category_id];
                    }
                }

                $item = $val;
                $item->categories = $_itemCats;
                $this->data['articles'][] = $item;
            }
            if(isset($list_categories))
                $this->data['list_categories'] = $list_categories;

            //load view template
            $this->data['meta_title'] = 'Tin tức';
            $this->data['sub_view'] = 'admin/news/index';
            $this->data['sub_js'] = 'admin/news/index-js';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function token_search() 
        {
            $q = $_GET['q'];
            $list_product = $this->news_model->get_by('name LIKE "%'.$q.'%"');
            foreach ( $list_product as $key => $val ) {
                $data[] = array(
                    'id' => $val->id,
                    'name' => $val->title
                );
            }
            print_r (json_encode($data));
            die();
        }

        public function edit($id = NULL) 
        {
            //if ( ! $this->has_permission('edit')) $this->not_permission();
            //Fetch a article or set a new one
            if($id) {
                $this->data['article'] = $article = $this->news_model->get($id);
                if ( ! $this->has_permission('edit',$article->category) && $article->create_by != $this->data['userdata']['id']) $this->not_permission('Bạn không có quyền sửa bài viết thuộc chuyên mục này');

                if(! $this->data['article'] ) {
                    $this->data['errors'][] = 'article could not be found!';
                    redirect(base_url('news'));
                }
                $action = 'update';

                //Bai da xuat ban: chi cho phep admin sua noi dung bai viet
                if($article->status == 1 && $this->data['userdata']['level'] != 1)
                {
                    $this->not_permission('Bài viết đã xuất bản. Bạn không được quyền sửa bài viết này!');
                }

                //Check log: neu co nguoi dang sua thi khong duoc sua
                $checkLog = checkNewsEditAlready($id);
                if($checkLog){
                    $_parse = explode('-', $checkLog);
                    if ($_parse[1] != $this->data['userdata']['id']) {
                        $userEdit = $this->user_model->get($_parse[1],TRUE);
                        $this->not_permission('Bài viết đang được sửa bởi thành viên: ' . $userEdit->name);
                    }
                }
            }
            else {
                if ( ! $this->has_permission('add')) $this->not_permission();
                $this->data['article'] = $article = $this->news_model->get_new();
                $action = 'insert';
            }
            $old_status = $article->status;
          
            //validate form
            $rules = $this->news_model->rules;
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run() == TRUE) {
                $data = $this->news_model->array_from_post(array('title','description','content','meta_title','meta_description','meta_keyword','public_time','category','status','is_hot','is_popular','source_url','relate_news', 'highlight_image', 'highlight_alt', 'display_author', 'display_ads_box', 'slugname'));

                $data['display_author'] = intval($data['display_author']);
                $data['display_ads_box'] = intval($data['display_ads_box']);

                $__inputCategory = $data['category'];
                unset($data['category']);

             
                if(!isset($data['status'])) $data['status'] = STATUS_PENDING;
                if($this->input->post('sentNews'))
                {
                    $data['status'] = STATUS_PENDING;
                }
                if($this->input->post('saving'))
                {
                    $data['status'] = STATUS_WRITING;
                }
                if($this->input->post('publish'))
                {
                    $data['status'] = STATUS_PUBLISHED;
                }
                if($this->input->post('un_publish'))
                {
                    $data['status'] = STATUS_PENDING;
                }
                if($this->input->post('saveContentOnly'))
                {
                    unset($data['status']);
                }

                if(!isset($data['is_hot'])) $data['is_hot'] = 0;
                if(!isset($data['is_popular'])) $data['is_popular'] = 0;

                if ($data['slugname']) 
                    $data['slugname'] = build_slug($data['slugname']);
                else
                    $data['slugname'] = build_slug($data['title']);
                
                $data['public_time'] = to_dbDateTime($data['public_time']);

                $data['meta_title']  = ($this->input->post('meta_title') != '') ? $this->input->post('meta_title') : $data['title'];
                $data['meta_description']  = ($this->input->post('meta_description') != '') ? $this->input->post('meta_description') : $data['description'];
                $data['meta_keyword'] = ($this->input->post('meta_keyword') != '') ? $this->input->post('meta_keyword') : $data['title'];
                //upload thumbnail image
                if($_FILES['thumbnail']['size'] > 0) {
                    $_thumnail_uploaded = parent::upload_file('thumbnail', '', false);
                    $_thumb_parse = array('path'=>'');
                    if($_thumnail_uploaded['image_url'] !=''){
                        $_thumb_parse = parse_url($_thumnail_uploaded['image_url']);
                    }
                    $data['thumbnail'] = $_thumb_parse['path'];
                }
                //Get input tags
                $_tags_id = array();
                $_input_tags = $this->news_model->array_from_post(array('tags'));
                $_input_tags = json_decode($_input_tags['tags']);
                if($_input_tags) {
                    foreach ($_input_tags as $val) {
                        $_exist_tag = $this->tag_model->check_exist_tag($val);
                        if ( count($_exist_tag)>0 ) {
                            $_tags_id[] = $_exist_tag[0]->id;
                        } else {
                            $_insert_tag = array(
                                'tag' => $val,
                                'tag_md5' => md5($val),
                                'status' => 1
                            );
                            $_tags_id[] = $this->tag_model->save($_insert_tag, NULL);
                        }
                    }
                }
                $data['tags_id'] = implode(',',$_tags_id);
                if($action == 'insert') {
                    $data['create_time'] = date('Y-m-d H:i:s', time());
                    $data['create_by'] = $this->data['userdata']['id'];
                    // if($data['public_time'] < $data['create_time']) $data['public_time'] = $data['create_time'] + 60;
                }
                elseif ($action == 'update') {
                    $data['update_by'] = $this->data['userdata']['id'];
                    $data['update_time'] = date('Y-m-d H:i:s', time());
                }

                if($id) $_action = 'Updated';
                else $_action = 'Added';

                print_r($article);
                exit();
                if ($_action == 'Updated') {
                    # Luu ban backup tin sang table: news_version
                    $backupNews = array (
                        'news_id' => $article->id,
                        'title' => $article->title,
                        'slugname' => $article->slugname,
                        'description' => $article->description,
                        'content' => $article->content,
                        'meta_title' => $article->meta_title,
                        'meta_description' => $article->meta_description,
                        'meta_keyword' => $article->meta_keyword,
                        'tags_id' => $article->tags_id,
                        'create_time' => time(),
                        'public_time' => $article->public_time,
                        'update_time' => NULL,
                        'create_by' => $this->data['userdata']['id'],
                        'update_by' => ($article->update_by) ? $article->update_by : $article->create_by,
                        'thumbnail' => $article->thumbnail,
                        'category' => $article->category,
                        'status' => (isset($article->status)) ? $article->status : NULL,
                        'hit_view' => $article->hit_view,
                        'is_hot' => $article->is_hot,
                        'is_popular' => $article->is_popular,
                        'relate_news' => $article->relate_news,
                        'audio_file' => (isset($article->audio_file)) ? $article->audio_file : NULL,
                        'source_url' => $article->source_url,
                        'highlight_alt' => $article->highlight_alt,
                        'highlight_image' => $article->highlight_image,
                        'display_author' => $article->display_author,
                        'display_ads_box' => $article->display_ads_box
                    );
                    $this->news_version_model->save($backupNews, NULL);
                }

                if($id = $this->news_model->save($data,$id)) {
                    //save history
                    $this->history_model->add_history(NULL,$_action,$id,'news');
                    if($old_status != 1 && isset($data['status']) && $data['status']==1)
                    {
                        $this->history_model->add_history(NULL,'Published',$id,'news');
                    }
                    elseif($old_status == 1 && isset($data['status']) && $data['status']!=1)
                    {
                        $this->history_model->add_history(NULL,'UnPublished',$id,'news');
                    }

                    //save news_type
                    $existChk = $this->news_salary_model->get_by( array('news_id' => $id), TRUE );
                    $newsTypePost = $this->news_salary_model->array_from_post( array('news_type') );
                    if( isset($newsTypePost['news_type']) && $newsTypePost['news_type']) 
                    {
                        $newsTypePost['type_id'] = $newsTypePost['news_type'];
                        unset($newsTypePost['news_type']);
                        if ( ! $existChk) {
                            $typeNewsCfg = $this->news_type_model->get($newsTypePost['type_id'], TRUE);
                            if($typeNewsCfg) {
                                $newsTypePost['news_id'] = $id;
                                $newsTypePost['view_count'] = 0;
                                $newsTypePost['created_time'] = date('Y-m-d H:i:s', time());
                                $newsTypePost['status'] = STATUS_SALARY_WAITING;
                                $newsTypePost['note'] = NULL;
                                $newsTypePost['money'] = $typeNewsCfg->fixed_money;
                                $newsTypePost['paid_date'] = NULL;
                                $this->news_salary_model->save($newsTypePost, NULL);
                            }
                        }
                        else
                        {
                            $this->news_salary_model->save($newsTypePost, $existChk->id);
                        }
                    }

                    //Save to event_news datatable
                    $this->event_news_model->removeEventByNews($id);
                    $_events_args = $this->event_news_model->array_from_post(array('event'));
                    if($_events_args['event']) {
                        $_event_ids = explode(',',$_events_args['event']);
                        $this->event_news_model->saveEventByNews($id,$_event_ids);
                    }

                   
                    // Save golfer for news
                    // $this->golfer_news_model->removeGolferByNews($id);
                    // $_golfer_input = $this->golfer_news_model->array_from_post( array('golfer') );
                    // if($_golfer_input['golfer']) {
                    //     $_golfer_ids = explode(',',$_golfer_input['golfer']);
                    //     $this->golfer_news_model->saveGolferByNews($id,$_golfer_ids);
                    // }
                    $this->session->set_flashdata('session_msg','Cập nhật thành công.');

                    // Save category_news
                    
                    $this->category_news_model->removeCategoryByNews($id);
                    $this->category_news_model->addCategoryNews($id, $__inputCategory);
                }
                else {
                    $this->session->set_flashdata('session_error','Không thể cập nhật dữ liệu.');
                }
                removeEditLog($id,$this->data['userdata']['id']);
                redirect(base_url('news'));
            }

            //Fetch category_perms for user
            $_cat_perms = $this->category_model->get_category_perm_in($this->data['userdata']['category_perm']);

            //fetch tree category
            $this->data['tree_categories'] = $this->category_model->get_all_category();
            foreach ($this->data['tree_categories'] as $key => $val) {
                if(in_array($val->id, $_cat_perms))
                {
                    $this->data['category_for_user'][] = $val;
                }
            }

            //fetch news type
            $this->data['newsSalaryRecord'] = NULL;
            if ($id && $newsSalaryRecord = $this->news_salary_model->get_by( array('news_id' => $id), TRUE ) ) {
                $this->data['newsSalaryRecord'] = $newsSalaryRecord;
            }

            //Fetch tags
            $this->data['tags'] ='';
            if ($this->data['article']->tags_id != '') 
            {
                $tags = $this->tag_model->getTagsInIds($this->data['article']->tags_id);
                $_tags_name = array();
                if($tags) {
                    foreach ($tags as $key => $val) {
                        $_tags_name[] = $val->tag;
                    }
                }
                $this->data['tags'] = $_tags_name;
            }

            //Fetch event for this article
            if($id) 
            {
                $events = $this->event_news_model->getEventByNews($id);
                if($events) {
                    foreach ($events as $key => $val) {
                        $_args[] = array(
                            'id' => $val->id,
                            'name' => $val->title
                        );
                    }
                    $this->data['events'] = json_encode($_args);
                }
            }

            //Fetch golfer by news
            // if($id) 
            // {
            //     $golfers = $this->golfer_news_model->getGolferByNews($id);
            //     if($golfers) {
            //         foreach ($golfers as $key => $val) {
            //             $_golfers[] = array(
            //                 'id' => $val->id,
            //                 'name' => $val->name
            //             );
            //         }
            //         $this->data['golfers'] = json_encode($_golfers);
            //     }
            // }

            //Fetch relate news
            $includes = $article->relate_news;
            $relate = $this->news_model->getNewsWithIds($includes);
            if($relate) 
            {
                $array = array();
                foreach ($relate as $key => $val) {
                    $array[] = array(
                        'id' => $val->id,
                        'name' => $val->title
                    );
                }
                $this->data['relate_news'] = json_encode($array);
            }

            //Fetch news_type to config Salary
            $this->data['salaryNewsType'] = $this->news_type_model->getAllType();

            // Fetch news_category
            if ($id) {
                $this->data['categoryNews'] = $this->category_news_model->getCategoryByNews($id);
                if ($this->data['categoryNews']) {
                    foreach ($this->data['categoryNews'] as $key => $value) {
                        $this->data['selectedCatIds'][] = $value->category_id;
                    }
                }
            }

            //Save editLogs
            if($id)
            {
                setLogEditNews($id, $this->data['userdata']['id']);
            }

            //Load View
            $this->data['meta_title'] = ($id) ? 'Sửa bài viết' : 'Viết tin mới';            
            $this->data['sub_view'] = 'admin/news/edit';
            $this->data['sub_js'] = 'admin/news/edit-js';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function delete($id = NULL) 
        {
            $news = $this->news_model->get($id,true);
            if ( ! $this->has_permission('delete',$news->category)) $this->not_permission();     
            $post_id = $this->input->post('ids');
            if($id) {
                $post_id[] = $id;
            }
            if($this->news_model->updateStatus($post_id,3)) {

                //save history
                $_action = 'Deleted';
                foreach ($post_id as $key => $val) {
                    $this->history_model->add_history(NULL,$_action,$val,'news');
                }

                $this->session->set_flashdata('session_msg','Xóa dữ liệu thành công');
            }
            else {
                $this->session->set_flashdata('session_error','Không xóa được dữ liệu');
            }
            redirect(base_url('news'));
        }

        public function _unique_slug($str) 
        {
            //Don't validate form if this slug already
            $id = $this->uri->segment(3);
            $this->db->where('slug',$this->input->post('slug'));
            !$id || $this->db->where('id !=', $id);
            $article = $this->news_model->get();
            if(count($article)) {
                $this->form_validation->set_message('_unique_slug','%s should be Unique');
                return FALSE;
            }
            return TRUE;
        }

        public function publish() 
        {
            $result = array('code'=>0 , 'msg' => 'success', 'data' => NULL);

            $userdata = $this->data['userdata'];
            if($userdata['level'] > 2)
            {
                $result['code'] = -2;
                $result['msg'] = 'Bạn không có quyền thực hiện thao tác này';
                echo json_encode($result);
                exit();
            }

            if ( ! $this->has_permission('edit'))
            {
                $result['code'] = -2;
                $result['msg'] = 'Bạn không có quyền thực hiện thao tác này';
                echo json_encode($result);
                exit();
            }

            $ids = $this->input->post_get('ids');
            $status = $this->input->post_get('status');
            if($this->news_model->updateStatus($ids,$status)) 
            {

                //save history
                if($status == 1) $_action = 'Published';
                else $_action = 'UnPublished';
                foreach ($ids as $key => $val) {
                    $this->history_model->add_history(NULL,$_action,$val,'news');
                }

                $result['msg'] = 'Cập nhật dữ liệu thành công';
                echo json_encode($result);                
                exit();
            }
            $result['code'] = -1;
            $result['msg'] = 'Không thành công!';
            echo json_encode($result);                
            exit();
        }

        public function search()
        {
            $keyword = trim($this->input->get('q'));
            $this->data['articles'] = $this->news_model->search($keyword);

            //Fetch all category
            $this->data['list_categories'] = $this->category_model->get_all_category();

            //Fetch all author
            $this->data['authors'] = $this->user_model->get_list_author();

            //Load View
            $this->data['meta_title'] = 'Kết quả tìm kiếm: '. $keyword;            
            $this->data['sub_view'] = 'admin/news/search';
            $this->data['sub_js'] = 'admin/news/search-js';
            $this->load->view('admin/_layout_main',$this->data);

        }

        public function myNews()
        {
            $me = $this->data['userdata'];
            $userId = ($this->input->get_post('userId')) ? (int)$this->input->get_post('userId') : $me['id'];
            if($userId != $me['id'] && $me['level'] > 2)
            {
                $this->not_permission('Bạn không có quyền xem thông tin của thành viên: ' . $userId);
            }
            $status = ($this->input->get_post('status')) ? $this->input->get_post('status') : NULL ;
            $this->data['status'] = $status;
            //Fetch all author
            $this->data['author'] = $author = $this->user_model->get($userId, TRUE);

            //get report news
            $this->data['newsReport'] = array(
                'myNews' => $this->news_model->reportNewsByUser($userId),
                'myNewsPending' => $this->news_model->reportNewsByUser($userId,2),
                'myNewsTrash' => $this->news_model->reportNewsByUser($userId,3),
                'myNewsWritting' => $this->news_model->reportNewsByUser($userId,4),
                'myNewsReturn' => $this->news_model->reportNewsByUser($userId,5),
                'myNewsApproved' => $this->news_model->reportNewsByUser($userId,1)
            );


            //Pagination Action
            $paging['current'] = (int)$this->input->get_post('page');
            if( ! $paging['current']) $paging['current'] = 1;
            $paging['limit'] = 50;
            $paging['next'] = 1+$paging['current'];
            $paging['prev'] = $paging['current']-1;
            if($paging['current'] <= 1) $paging['prev'] = 0;
            $paging['offset'] = ($paging['current']-1)*$paging['limit'];
            $this->data['paging'] = $paging;
            //fetch all news
            $offset = ($paging['current']-1)*$paging['limit'];
            $this->data['news'] = $list_articles = $this->news_model->get_my_posted($userId, $paging['offset'], $paging['limit'], $status);

            //Fetch tree category filter
            $this->data['tree_categories'] = $this->category_model->get_tree_categories();

            //fetch category for article
            foreach ($list_articles as $key => $val) {
                $list_categories[$val->category] = $this->category_model->get($val->category,true);
            }
            if(isset($list_categories))
                $this->data['list_categories'] = $list_categories;

            //load view template
            $this->data['meta_title'] = 'Bài viết của <strong style="text-transform:uppercase">tôi</strong>';
            if($me['id'] != $userId)
            {
                $this->data['meta_title'] = 'Bài viết của <strong style="text-transform:uppercase">'.$author->name.'</strong>';
            }
            if($status==STATUS_PUBLISHED)
            {
                $this->data['meta_title'] .= ': Đã duyệt';
            }
            if($status==STATUS_PENDING)
            {
                $this->data['meta_title'] .= ': Chờ duyệt';
            }
            if($status==STATUS_DELETED)
            {
                $this->data['meta_title'] .= ': Đã xóa';
            }
            if($status==STATUS_WRITING)
            {
                $this->data['meta_title'] .= ': Đang viết';
            }
            if($status==STATUS_COMEBACK)
            {
                $this->data['meta_title'] .= ': Bị trả lại';
            }

            $this->data['sub_view'] = 'admin/news/my-news';
            $this->data['sub_js'] = 'admin/news/my-news-js';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function reportNewsByAuthor()
        {

            //fetch report all news
            $allNewsReport = $this->news_model->getReportNewsByStatus();
            if ( ! isset($allNewsReport[STATUS_PUBLISHED])) $allNewsReport[STATUS_PUBLISHED] = 0;
            if ( ! isset($allNewsReport[STATUS_PENDING])) $allNewsReport[STATUS_PENDING] = 0;
            if ( ! isset($allNewsReport[STATUS_WRITING])) $allNewsReport[STATUS_WRITING] = 0;
            if ( ! isset($allNewsReport[STATUS_COMEBACK])) $allNewsReport[STATUS_COMEBACK] = 0;
            if ( ! isset($allNewsReport[STATUS_DELETED])) $allNewsReport[STATUS_DELETED] = 0;
            $this->data['allNewsReport'] = $allNewsReport;

            $me = $this->data['userdata'];
            if($me['level'] > 2)
            {
                $this->not_permission('Bạn không có quyền xem thông tin của thành viên: ' . $userId);
            }

            $createTimeFilter = ($this->input->get_post('createTimeFilter')) ? trim($this->input->get_post('createTimeFilter')) : '';
            if($createTimeFilter) {
                $_parseTime = explode(' - ', $createTimeFilter);
                $_startTime = explode('/', $_parseTime[0]);
                $_endTime = explode('/', $_parseTime[1]);
                $_startTime = mktime(0,0,0,$_startTime[0], $_startTime[1], $_startTime[2]);
                $_endTime = mktime(23,59,59,$_endTime[0], $_endTime[1], $_endTime[2]);
            }
            else {
                $firstDay = strtotime('first day of this month');
                $lastDay = strtotime('last day of this month');
                $_startTime = mktime(0,0,0, date('m', $firstDay), 1, date('Y', $firstDay));
                $_endTime = mktime(23,59,59, date('m', $lastDay) , date('d', $lastDay), date('Y', $lastDay));
            }

            $this->data['timeFilter'] = array(
                'start' => date('m/d/Y', $_startTime),
                'end' => date('m/d/Y', $_endTime)
            );

            $authors = $this->user_model->get_list_author();
            //Fetch all author
            $this->data['authors'] = $authors;
            
            //get report news
            $reportsNews = $this->news_model->getReportByAuthor($_startTime, $_endTime);
            $arrKey = array(0=>'all','approved','pending','trash','writting','return');
            foreach ($reportsNews as $key => $val) {
                if(isset($arrKey[$val->status]))
                {
                    $statusName = $arrKey[$val->status];
                    $this->data['reports'][$val->create_by][$statusName] = $val->number;
                }
                else {
                    $this->data['reports'][$val->create_by][$statusName] = 0;
                }
            }

            //load view
            $this->data['meta_title'] = 'Thống kê bài viết ';
            $this->data['meta_title_1'] = 'Thống kê từ: ' . date('d/m/Y', $_startTime) .' đến ' . date('d/m/Y', $_endTime);
            $this->data['sub_view'] = 'admin/news/report-news';
            $this->data['sub_js'] = 'admin/news/report-news-js';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function listNews()
        {
            $this->data['tree_categories'] = $this->category_model->get_tree_categories();
            $this->data['category_id']=0;
            $this->data['authors'] = $this->user_model->get_list_author();
            //Load view
            $this->data['meta_title'] = 'Quản lý bài viết';
            $this->data['sub_view'] = 'admin/news/list-news';
            $this->data['sub_js'] = 'admin/news/list-news-js';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function getListNewsData()
        {
            $inputs = $this->input->post();
            $params = [];
            $params['offset'] = $inputs['start'];
            $params['limit'] = $inputs['length'];
            $params['keyword'] = $inputs['search']['value'];
            $params['create_by'] = $inputs['create_by'];
            $params['category'] = $inputs['category'];
            $params['status'] = $inputs['status'];
            
            $this->load->model('user_model');
            $listNews = $this->news_model->getListNewsData($params);
            $allAuthor = $this->user_model->get_list_author();
            $allCategory = $this->category_model->get_all_category();
            foreach ($listNews as $key => $item) {
                $item['public_time'] = date('H:i d/m/Y',$item['public_time']);
                $item['create_time'] = date('H:i d/m/Y',$item['create_time']);
                $_author = $allAuthor[$item['create_by']];
                $item['author'] = [
                    'id' => $_author->id,
                    'name' => $_author->name,
                ];
                if(isset($allCategory[ $item['category'] ]))
                {
                    $_category = $allCategory[ $item['category'] ];
                    $item['category'] = array(
                        'id' => $_category->id,
                        'name' => $_category->title,
                    );
                }
                else
                {
                    $item['category'] = array(
                        'id' => null,
                        'name' => '...',
                    );
                }
                $data[] = $item;
            }
            
            $response = array();
            $response['data'] = $data;
            $response['recordsFiltered'] = 50;
            $response['recordsTotal'] = 1000;
            echo json_encode( $response );
        }
}