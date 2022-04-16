<?php
    class Product extends MY_Controller {

        public function __construct() {
            parent::__construct();
            $this->load->model('product_category_model');
            $this->load->model('bussiness_model');
            $this->load->model('product_model');
            $this->load->model('product_detail_model');
            $this->load->model('product_price_model');
            $this->load->model('location_model');
            $this->load->model('file_model');
            $this->data['breadcrumbs'] = array('Sản phẩm' => base_url('product'));
        }

        public function index() 
        {
            $this->data['sub_view'] = 'admin/product/index';
            $this->data['sub_js'] = $this->data['sub_view'] . '-js';
            $this->data['meta_title'] = 'Quản lý sản phẩm';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function getProductData()
        {
            $productCategories = $this->product_category_model->getListCategory();
            foreach ($productCategories as $key => $value) {
                $listCategory[$value->id] = $value;
            }
            
            //Filter params
            $filters = array();
            $filters['keyword'] = ($this->input->get_post('keyword')) ? ($this->input->get_post('keyword')) : NULL;
            $filters['product_type'] = ($this->input->get_post('product_type')) ? trim($this->input->get_post('product_type')) : NULL;
            $filters['created_date'] = ($this->input->get_post('created_date')) ? trim($this->input->get_post('created_date')) : NULL;
            $filters['bussiness_id'] = ($this->input->get_post('bussiness_id')) ? trim($this->input->get_post('bussiness_id')) : NULL;
            $filters['location_id'] = ($this->input->get_post('location_id')) ? trim($this->input->get_post('location_id')) : NULL;
            $filters['status'] = ($this->input->get_post('status')) ? intval($this->input->get_post('status')) : NULL;
            $filters['offset'] = ($this->input->get_post('start')) ? intval($this->input->get_post('start')) : 0;
            $filters['limit'] = ($this->input->get_post('length')) ? intval($this->input->get_post('length')) : 5;

            $data = array('data' => array());
            $_countWhere = array();
            $data['recordsTotal'] = $this->product_model->countProduct();
            $data['recordsFiltered'] = $this->product_model->countProductFilter($filters);

            if ($filters['location_id']) 
            {
                $location = $this->location_model->get($filters['location_id'], TRUE);
                $filters['location_level'] = $location->level;
            }

            $listProduct = $this->product_model->getFilterProductData($filters);
            
            //rebuild data for datatables
            if ($listProduct) {
                foreach($listProduct as $key => $val)
                {
                    $val['created_time'] = date('H:i d/m/Y', strtotime($val['created_time']));
                    //fetch category option
                    $_categoryId = $val['product_category'];
                    if (isset($listCategory[ $_categoryId ]))
                    {
                        $_cate = $listCategory[ $_categoryId ];
                        $val['category'] = array(
                            'id' => $_cate->id,
                            'title' => $_cate->title,
                        );
                    }
                    else
                    {
                        $val['category'] = array(
                            'id' => NULL,
                            'title' => 'updating...',
                        );
                    }
                    //fetch bussiness
                    if ($val['bussiness_id'] && $bussiness = $this->bussiness_model->get($val['bussiness_id'], TRUE)) 
                    {
                        $val['bussiness'] = array(
                            'id' => $bussiness->id,
                            'title' => $bussiness->title,
                            'display_name' => $bussiness->display_name
                        );
                    }
                    else
                    {
                        $val['bussiness'] = array(
                            'id' => 0,
                            'title' => '...',
                            'display_name' => '...'
                        );
                    }
                    $listProduct[$key] = $val;
                }
                $data['data'] = $listProduct;
            }
            echo json_encode($data);
            exit();
        }

        public function select_product_type($id=null)
        {
            $args = array(
                'parent_id' => 0
            );
            $this->data['mainType'] = $this->product_category_model->get_by($args);
            $this->data['selected'] = $id;

            //Load view
            $this->data['sub_view'] = 'admin/product/select-type';
            $this->data['sub_js'] = 'admin/product/select-type-js';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function edit($id = NULL) 
        {

            $productType = ($this->input->get_post('product_type')) ? intval($this->input->get_post('product_type')) : 3;

            if ( ! $productType && ! $id) {
                redirect( base_url('product/select_product_type') ,'refresh');
            }

            $this->data['meta_title'] = 'Thêm sản phẩm mới';
            $this->data['breadcrumbs'] = array('Sản phẩm' => base_url('product'));
            $this->data['product'] = $product = $this->product_model->getDetailProduct($id);
            
            if($id) 
            {    
                if(! $this->data['product']) $this->data['errors'][] = 'Product could not be found!';
                $this->data['meta_title'] = $product->title;
            }

            //validate form
            $rules = $this->product_model->rules;
            $this->form_validation->set_rules($rules);
            if($this->form_validation->run() == TRUE) {

                //save product
                $args = array('title','description','content','include','exclude','pruduct_category','bussiness_id','locations','status','thumbnail','images','video','meta_title','meta_keyword','meta_description','language','policy','price','amount','duration','public_time','start_time','sale_expired');
                
                $data = $this->product_model->array_from_post($args);                
                $data['slugname'] = build_slug($data['title']);
                if ( ! $data['meta_title']) $data['meta_title'] = $data['title'];
                if ( ! $data['meta_keyword']) $data['meta_keyword'] = $data['title'];
                if ( ! $data['meta_description']) $data['meta_description'] = $data['title'];
                if ( ! $data['status']) $data['status'] = 3;
                
                if ( ! $savedId = $this->product_model->save($data, $id)) 
                    $this->session->set_flashdata('flash_error', 'Không thể cập nhật dữ liệu!');
                else
                    $this->session->set_flashdata('flash_msg', 'Cập nhật dữ liệu thành công.');
                redirect(base_url('product'));
            }

            //fetch list product Type
            $this->data['appProductCategories'] = $this->product_category_model->get();

            $this->data['product_categories'] = $this->product_category_model->get_by( array('parent_id' => $productType) );

            //Fetch list image for news
            $imageIds = $product->images;
            $this->data['listImages'] = $this->file_model->get_list_file_by_str_ids($imageIds);
            
            //Fetch bussiness
            if ($product->bussiness_id) {
                $__bussiness = $this->bussiness_model->getDetailBussiness($product->bussiness_id);
                $_tokenBussiness = array(
                    'id' => $__bussiness->id,
                    'name' => $__bussiness->title
                );
                $this->data['tokenBussiness'] = json_encode( $_tokenBussiness );
            }

            // Load Product detail
            $__detailArgs = array();
            $__detailArgs['product_id'] = $product->id;
            if ($product->id) 
            {
                $this->data['productDetail'] = $productDetail = $this->product_detail_model->get_by($__detailArgs, TRUE);
            }
            else
            {
                $this->data['productDetail'] = $productDetail = $this->product_detail_model->getNew();
            }
            if ($productDetail->country_id) {
                $__countryIds = substr($productDetail->country_id, 1, -1);
                $__countryArgs = array('id IN ('.$__countryIds.')' => NULL);
                $__countries = $this->location_model->get_by($__countryArgs);
                foreach ($__countries as $key => $value) {
                    $__tokenItem = array(
                        'id' => $value->id,
                        'name' => $value->name
                    );
                    $__tokenCountries[] = $__tokenItem;
                }
                $this->data['tokenCountries'] = json_encode($__tokenCountries);
            }

            if ($__provinceIds = substr($productDetail->province_id, 1, -1)) {
                $__provinceArgs = array('id IN ('.$__provinceIds.')' => NULL);
                $__provinces = $this->location_model->get_by($__provinceArgs);
                foreach ($__provinces as $key => $value) {
                    $__tokenItem = array(
                        'id' => $value->id,
                        'name' => $value->name
                    );
                    $__tokenProvinces[] = $__tokenItem;
                }
                $this->data['tokenProvinces'] = json_encode($__tokenProvinces);
            }

            if ($__locationIds = substr($productDetail->location_id, 1, -1)) {
                $__locationArgs = array('id IN ('.$__locationIds.')' => NULL);
                $__locations = $this->location_model->get_by($__locationArgs);
                foreach ($__locations as $key => $value) {
                    $__tokenItem = array(
                        'id' => $value->id,
                        'name' => $value->name
                    );
                    $__tokenlocations[] = $__tokenItem;
                }
                $this->data['tokenLocations'] = json_encode($__tokenlocations);
            }

            // Fetch prices of product
            $this->data['productPrices'] = $this->product_price_model->getListPriceByProduct($product->id);
            
            // Load view
            $this->data['sub_view'] = 'admin/product/edit';
            $this->data['sub_js'] = 'admin/product/edit-js';
            $this->load->view('admin/_layout_main',$this->data);
        }

        public function delete($id = NULL) 
        {
            if ( ! $this->has_permission('delete')) $this->not_permission();
            $post_id = $this->input->post('ids');
            
            if ($id) $post_id[] = $id;
            
            if ($this->banner_model->updateStatus($post_id,3))
            {
                foreach ($post_id as $key => $val) {
                    $this->history_model->add_history(NULL,'Deleted',$val,'banner');
                }
                $this->session->set_flashdata('session_msg','Xóa dữ liệu thành công');
            }
            else
            {
                $this->session->set_flashdata('session_error','Không xóa được dữ liệu');
            }
            redirect(base_url('banner'));
        }
}