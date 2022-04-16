<?php
    class Setting extends MY_Controller {

        public function __construct() {
            parent::__construct();
            //$this->load->model('setting_model');
            $this->load->model('file_model');
            $this->load->model('menu_model');
            $this->load->model('page_model');
            $this->load->model('category_model');
            //$this->load->model('banner_model');
            $this->load->model('option_model');
            $this->load->model('seo_option_model');
        }

        public function configOption($id)
        {
            $this->data['breadcrumbs']['Option'] = '/setting/option';

            $option = $this->option_model->get($id);
            $name = $option->name;
            $this->data['option'] = $option;

            switch ($name) {
                default:
                    redirect('/setting/edit_option/' . $id);
                    break;
            }
        }

        public function index() 
        {
            if ( ! $this->has_permission('view')) $this->not_permission();
            $this->data['meta_title'] = 'Cài đặt website';
            $this->data['breadcrumbs']['Cài đặt'] = base_url('admin/setting');
            //fetch setting field
            $this->data['setting'] = $setting = $this->setting_m->get(1,true);
            if($setting->image_slider != '') {
                $slide_image_array = explode(',',$setting->image_slider);
                if(count($slide_image_array)) {
                    $this->data['list_slider_image'] = $this->file_m->get_list_file_by_str_ids($setting->image_slider);
                }
            }
            //Fetch list message waitting reply
            $this->data['message_waiting'] = $this->message_m->get_by('status = 2');
            //Fetch Top banner
            $banner = $this->banner_m->get_banner_by_group(1);
            if( count($banner)>0 ) {
                $this->data['top_banners'] = $banner;
            }
            //Save setting
            $rules = $this->setting_m->rules;
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run() == TRUE) {
                $data = $this->setting_m->array_from_post(array('address', 'phone', 'telephone', 'slogan', 'facebook_fanpage', 'gplus_page', 'youtube_chanel', 'twiter_page', 'fb_app_id', 'rss_link','sale_support_phone','sale_support_yahoo','sale_support_skype','tech_support_phone','tech_support_yahoo','tech_support_skype','footer_text_1','footer_text_2','email','email_password'));
                //get data supporter account
                $suppoter = $this->setting_m->array_from_post(array('sale_yahoo_name','sale_yahoo_acc','sale_skype_acc','tech_yahoo_name','tech_yahoo_acc','tech_skype_acc'));

                if(!empty($suppoter['sale_yahoo_name']))
                {
                    foreach ($suppoter['sale_yahoo_name'] as $key => $val)
                    {
                        if(trim($val) != '')
                        {
                            $sale_yahoo_support[$key] = array(
                                'name' => $val,
                                'acc'  => $suppoter['sale_yahoo_acc'][$key]
                            );
                            $sale_skype_support[$key] = array(
                                'name' => $val,
                                'acc'  => $suppoter['sale_skype_acc'][$key]
                            );
                        }
                    }
                }
                $data['sale_support_yahoo'] = json_encode($sale_yahoo_support);
                $data['sale_support_skype'] = json_encode($sale_skype_support);

                if(! empty($suppoter['tech_yahoo_name']))
                {
                    foreach ($suppoter['tech_yahoo_name'] as $key => $val) 
                    {
                        if(trim($val) != '')
                        {
                            $tech_yahoo_support[$key] = array(
                                'name' => $val,
                                'acc'  => $suppoter['tech_yahoo_acc'][$key]
                            );
                            $tech_skype_support[$key] = array(
                                'name' => $val,
                                'acc'  => $suppoter['tech_skype_acc'][$key]
                            );
                        }
                    }
                }
                $data['tech_support_yahoo'] = json_encode($tech_yahoo_support);
                $data['tech_support_skype'] = json_encode($tech_skype_support);

                $this->setting_m->save($data,1);
                //Update Top banner
                $banner = $this->banner_m->array_from_post(array('bannerId','bannerImage','bannerTitle','bannerLink','bannerOrder'));
                foreach ( $banner['bannerId'] as $key => $val ) {
                    $banner_id = NULL;
                    if( (int)$val != 0) $banner_id = $val;
                    $_banner_data = array(
                        'title' => $banner['bannerTitle'][$key],
                        'out_link' => trim($banner['bannerLink'][$key]),
                        'img_url' => trim($banner['bannerImage'][$key]),
                        'status' => 1,
                        'banner_group' => 1,
                        'order' => $banner['bannerOrder'][$key],
                    );
                    $this->banner_m->save($_banner_data,$banner_id);
                }
                redirect('setting');
            }
            //load view template
            $this->data['sub_view'] = 'admin/setting/index';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function setting_menu ( $menu_group=1 ) 
        {
            if ( ! $this->has_permission('view')) $this->not_permission();
            $this->data['tree_menu']  = $this->menu_model->get_group_menu($menu_group);
            $this->data['meta_title'] = 'Quản lý menu';
            $this->data['breadcrumbs']['Cài đặt'] = base_url('setting');
            $this->data['breadcrumbs']['Menu'] = base_url('setting/setting_menu');
            $this->data['menu_group'] = $menu_group;
            
            //load view template
            $this->data['sub_view'] = 'admin/setting/menu';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function edit_menu($menu_id) 
        {
            if ( ! $this->has_permission('edit')) $this->not_permission();
            $this->data['menu']= $menu = $this->menu_model->get($menu_id,true);
            $this->data['tree_menu'] = $this->menu_model->get_group_menu($menu->group);
            //$this->data['parent_menu'] = $this->menu_m->get($menu->parent_id,true);  
            $this->data['menu_group'] = $menu->group;          
            $this->data['breadcrumbs']['Cài đặt'] = base_url('setting');
            $this->data['breadcrumbs']['Menu'] = base_url('setting/setting_menu');
            $this->data['breadcrumbs']['Sửa menu'] = base_url('setting/edit_menu/' . $menu->id);

            //load view template
            $this->data['sub_view'] = 'admin/setting/edit_menu';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function add_menu() 
        {
            if ( ! $this->has_permission('add')) $this->not_permission();
            $arr_post = $this->menu_model->array_from_post(array('group','parent','name','url','order','img'));
            $data['title'] = $arr_post['name'];
            $data['url'] = $arr_post['url'];
            $data['parent_id'] = $arr_post['parent'];
            $data['group'] = $arr_post['group'];
            $data['order'] = $arr_post['order'];
            $_path_icon = parse_url($arr_post['img']);
            $data['icon_url'] = $_path_icon['path'];
            
            if($arr_post['parent']==0) {
                $data['level'] = 1;
            } else {
                $parent = $this->menu_model->get($arr_post['parent'],true);
                $data['level'] = $parent->level+1;   
            }
            $id = $this->menu_model->save($data);
            if ($id){
                echo 'success';die();
            } else {
                echo 'error';die();
            }
        }

        public function save_menu()
        {
            $arr_post = $this->menu_model->array_from_post(array('id','parent','name','url','order','img'));
            $data['title'] = $arr_post['name'];
            $data['url'] = $arr_post['url'];
            $data['parent_id'] = $arr_post['parent'];
            $data['order'] = $arr_post['order'];
            if($arr_post['img'] != '') {
                $_path_icon = parse_url($arr_post['img']);
                $data['icon_url'] = $_path_icon['path'];
            }
            if($arr_post['parent']==0) {
                $data['level'] = 1;
            } else {
                $parent = $this->menu_model->get($arr_post['parent'],true);
                $data['level'] = $parent->level+1;
            }
            $id = $this->menu_model->save($data,$arr_post['id']);
            if ($id){
                echo 'success';die();
            } else {
                echo 'error';die();
            }

        }

        public function remove_menu($id) 
        {
            if ( ! $this->has_permission('delete')) $this->not_permission();
            //check menu exist
            $menu = $this->menu_model->get($id,TRUE);
            if(!$menu) {
                echo 'Menu không tồn tại';
                die();
            }            
            //check this childrent menu
            $childs_menu = $this->menu_model->get_by('parent_id = ' . $id);
            if(count($childs_menu) > 0) {
                echo 'Có menu con. Bạn không thể xóa menu này!';
                die();
            }
            $this->menu_model->delete($id);
            echo 'success';
            die();
        }
        
        public function option() 
        {
            $this->data['options'] = $options = $this->option_model->get_site_option();
            
            //breadcrumbs 
            $this->data['breadcrumbs']['Cài đặt'] = base_url('setting');
            $this->data['breadcrumbs']['Thông tin'] = base_url('setting/option');

            //load view template
            $this->data['sub_view'] = 'admin/setting/option';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function we_offer() 
        {
            $args = [
                "name LIKE 'offer_%'" => NULL
            ];
            $offers = $this->option_model->get_by($args);
            foreach ($offers as $key => $value) {
                $this->data['offerCfg'][$value->name] = $value->value;
                $this->data['offerCfgKey'][] = $value->name;
                $this->data['offerCfgId'][$value->name] = $value->id;
            }
            
            if ($this->input->post()) 
            {
                $data = $this->option_model->array_from_post($this->data['offerCfgKey']);
                $this->data['offerCfg'] = $data;
                foreach ($data as $key => $value) 
                {
                    $dataUpdate[] = [
                        'name' => $key,
                        'value' => $value
                    ];
                }
                if ($this->option_model->updateMulti($dataUpdate, 'name')) 
                    $this->session->set_flashdata('session_msg','Cập nhật thành công!');
                else
                    $this->session->set_flashdata('session_error','Failed!');
            }

            //load view template
            $this->data['sub_view'] = 'admin/setting/we-offer';
            $this->data['sub_js'] = $this->data['sub_view'] . '-js';
            $this->load->view('admin/_layout_main',$this->data);
        }
        
        public function add_option()
        {
            $data = $this->option_model->array_from_post(array('name','value','var_type', 'description'));
            
            if($data['var_type'] == 'int') {
                $data['value'] = (int)$data['value'];
            } elseif ($data['var_type'] == 'string') {
                $data['value'] = (string)$data['value'];
            }
            if($data['name']=='') {
                $response['msg'] = 'error';
            }
            $data['name'] = strtolower($data['name']);
            $data['name_desc'] = trim($data['description']);
            $data['value'] = ($data['value']) ? $data['value'] : 'null';
            $this->option_model->save($data,null);
            $response['msg'] = 'success';
            echo json_encode($response);
        }
        
        public function edit_option($id)
        {
            $option = $this->option_model->get($id);
            $this->data['option'] = $option;
            $rules = $this->option_model->rules;
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run() == TRUE) {
                $data = $this->option_model->array_from_post(array('name','value','var_type', 'name_desc'));
                if($data['var_type'] == 'int') {
                    $data['value'] = (int)$data['value'];
                } else {
                    $data['value'] = (string)$data['value'];
                }
                if($data['name']=='') {
                    $response['msg'] = 'error';
                }
                $data['name'] = strtolower($data['name']);
                $data['value'] = ($data['value']) ? $data['value'] : 'null';
                $this->option_model->save($data,$id);
                $this->session->set_flashdata('session_msg','Cập nhật thành công!');
                redirect(base_url('setting/option'));
            }
            
            //breadcrumbs 
            $this->data['breadcrumbs']['Cài đặt'] = base_url('setting');
            $this->data['breadcrumbs']['Thông tin'] = base_url('setting/option');
            $this->data['breadcrumbs']['cập nhật'] = base_url('setting/edit_option/'.$id);

            //load view template
            $this->data['sub_view'] = 'admin/setting/edit_option';
            $this->load->view('admin/_layout_main',$this->data);
            
        }
        
        public function delete_option($id)
        {
            if ($this->option_model->delete($id))
                $this->session->set_flashdata('session_msg','Xóa thành công!');
            else    
                $this->session->set_flashdata('session_error','Không thể xóa thông tin');
            
            redirect(base_url('setting/option'));
        }
        
        public function seo_option($id=NULL)
        {
            if ($this->data['userdata']['level'] > 1) $this->not_permission();
            
            $this->data['list_seo'] = $this->seo_option_model->get_list_seo_option();
            
            if ($id)
                $this->data['seo'] = $this->seo_option_model->get($id,TRUE);
            else
                $this->data['seo'] = $this->seo_option_model->get_new();
            
            $this->data['meta_title'] = 'SEO Options';
            $this->data['breadcrumbs']['Cài đặt'] = base_url('setting');
            $this->data['breadcrumbs']['SEO Options'] = base_url('setting/seo_option');
            
            //Load view
            $this->data['sub_view'] = 'admin/setting/seo-option';
            $this->load->view('admin/_layout_main',$this->data);
        }
        
        public function editor_choise()
        {
            //Fetch all editor choise
            $_args = array('name' => 'editor_choise');
            $_settings = $this->option_model->get_by($_args);
            $_setting_id = $_settings[0]->id;
            
            if($this->input->post('editor_choise'))
            {
                $data = array('value' => implode(',',$this->input->post('editor_choise')));
                if($this->option_model->save($data,$_setting_id))
                {
                    $this->session->set_flashdata('session_msg','Cập nhật thành công');
                    $_settings = $this->option_model->get_by($_args);
                }       
            }
            $this->load->model('news_model');
            $_news = $this->news_model->getNewsWithIds($_settings[0]->value);
            $this->data['editor_order_ids'] = explode(',', $_settings[0]->value);
            foreach ($_news as $key => $val) {
                $this->data['editor_choise'][$val->id] = $val;
            }
            
            //Load view
            $this->data['sub_view'] = 'admin/setting/editor-choise';
            $this->data['sub_js'] = 'admin/setting/editor-choise-js';
            $this->load->view('admin/_layout_main',$this->data);
        }
        
        public function home_feature()
        {
            //Fetch all editor choise
            $_args = array('name' => 'home_feature');
            $_settings = $this->option_model->get_by($_args);
            $_setting_id = $_settings[0]->id;
            
            if($this->input->post('home_feature'))
            {
                $data = array('value' => implode(',',$this->input->post('home_feature')));
                if($this->option_model->save($data,$_setting_id))
                {
                    $this->session->set_flashdata('session_msg','Cập nhật thành công');
                    $_settings = $this->option_model->get_by($_args);
                }       
            }
            $this->load->model('news_model');
            $_news = $this->news_model->getNewsWithIds($_settings[0]->value);
            $this->data['order_ids'] = explode(',', $_settings[0]->value);
            foreach ($_news as $key => $val) {
                $this->data['home_feature'][$val->id] = $val;
            }
            
            //Load view
            $this->data['sub_view'] = 'admin/setting/home-feature';
            $this->data['sub_js'] = 'admin/setting/home-feature-js';
            $this->load->view('admin/_layout_main',$this->data);
        }
        
        public function home_news()
        {
            //Fetch all editor choise
            $_args = array('name' => 'home_news');
            $_settings = $this->option_model->get_by($_args);
            $_setting_id = $_settings[0]->id;
            
            if($this->input->post('home_news'))
            {
                $data = array('value' => implode(',',$this->input->post('home_news')));
                if($this->option_model->save($data,$_setting_id))
                {
                    $this->session->set_flashdata('session_msg','Cập nhật thành công');
                    $_settings = $this->option_model->get_by($_args);
                }       
            }
            $this->load->model('news_model');
            $_news = $this->news_model->getNewsWithIds($_settings[0]->value);
            $this->data['order_ids'] = explode(',', $_settings[0]->value);
            foreach ($_news as $key => $val) {
                $this->data['home_news'][$val->id] = $val;
            }
            
            //Load view
            $this->data['sub_view'] = 'admin/setting/home-news';
            $this->data['sub_js'] = 'admin/setting/home-news-js';
            $this->load->view('admin/_layout_main',$this->data);
        }
        
        public function static_lastest_news()
        {
            //Fetch all editor choise
            $_args = array('name' => 'static_lastest_news');
            $_settings = $this->option_model->get_by($_args);
            $_setting_id = $_settings[0]->id;
            
            if($this->input->post('static_lastest_news'))
            {
                $data = array('value' => implode(',',$this->input->post('static_lastest_news')));
                
                if($this->option_model->save($data,$_setting_id))
                {
                    $this->session->set_flashdata('session_msg','Cập nhật thành công');
                    $_settings = $this->option_model->get_by($_args);
                }       
            }
            $this->load->model('news_model');
            $_news = $this->news_model->getNewsWithIds($_settings[0]->value);
            $this->data['order_ids'] = explode(',', $_settings[0]->value);
            foreach ($_news as $key => $val) {
                $this->data['static_lastest_news'][$val->id] = $val;
            }
            
            //Load view
            $this->data['sub_view'] = 'admin/setting/static_lastest_news';
            $this->data['sub_js'] = 'admin/setting/static_lastest_news-js';
            $this->load->view('admin/_layout_main',$this->data);
        }
        
        public function static_videos()
        {
            //Fetch all editor choise
            $_args = array('name' => 'static_videos');
            $_settings = $this->option_model->get_by($_args);
            $_setting_id = $_settings[0]->id;
            
            if($this->input->post('static_videos'))
            {
                $data = array('value' => implode(',',$this->input->post('static_videos')));
                if($this->option_model->save($data,$_setting_id))
                {
                    $this->session->set_flashdata('session_msg','Cập nhật thành công');
                    $_settings = $this->option_model->get_by($_args);
                }       
            }
            $this->load->model('video_model');
            $_news = $this->video_model->get_videos_with_ids($_settings[0]->value);
            $this->data['order_ids'] = explode(',', $_settings[0]->value);
            foreach ($_news as $key => $val) {
                $this->data['static_videos'][$val->id] = $val;
            }
            
            //Load view
            $this->data['sub_view'] = 'admin/setting/static_videos';
            $this->data['sub_js'] = 'admin/setting/static_videos-js';
            $this->load->view('admin/_layout_main',$this->data);
        }
}