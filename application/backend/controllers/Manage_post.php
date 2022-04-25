<?php
require_once APPPATH . 'third_party/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Manage_post extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('manage_post_model');
        $this->load->model('category_post_model');
        $this->load->model('member_model');

        //Breadcrumbs
        $this->data['breadcrumbs']['Bài viết sản phẩm'] = base_url('manage_post');
    }

    public function index()
    {
        $this->data['category_post'] = $this->category_post_model->get();

        //load view template
        $this->data['meta_title'] = 'Bài viết sản phẩm';
        $this->data['sub_view'] = 'admin/manage_post/index';
        $this->data['sub_js'] = 'admin/manage_post/index-js';
        $this->load->view('admin/_layout_main', $this->data);
    }

    public function token_search()
    {
        $q = $_GET['q'];
        $list_post = $this->manage_post_model->get_by('name LIKE "%' . $q . '%"');
        foreach ($list_post as $key => $val) {
            $data[] = array(
                'id' => $val->id,
                'name' => $val->title
            );
        }
        print_r(json_encode($data));
        die();
    }
    public function edit($id = NULL)
    {


        $this->data['post'] = ($id) ? $this->manage_post_model->get($id) : $this->manage_post_model->getList();
        //validate form
        $rules = $this->manage_post_model->rules;
        $this->form_validation->set_rules($rules);
        if ($this->form_validation->run() == TRUE) {
            $data = $this->manage_post_model->array_from_post(array('title', 'description', 'category_id', 'thumbnail',  'content',  'status','fb_page_url', 'member_id', 'is_public'));

            $data['rent_enddate'] = ($data['rent_enddate']) ? date('Y-m-d', strtotime(str_replace('/', '-', $data['rent_enddate']))) : null;

            $data['slugname'] = build_slug($data['title']);
            if (!$data['title']) $data['title'] = $data['title'];
            if (!$data['description']) $data['description'] = $data['description'];
            $data['is_public'] = ($data['is_public']) ? 1 : 0;
            if (!$data['category_id']) $data['category_id'] = $data['category_id'];
            if (!$data['content']) $data['content'] = $data['content'];
            $data['member_id'] = ($data['member_id']) ? intval($data['member_id']) : 0;
            if (!$data['thumbnail']) unset($data['thumbnail']);


            if (!$id) {
                $data['created_by'] = $this->data['userdata']['id'];
            }

            if ($id = $this->manage_post_model->save($data, $id)) {

                $this->session->set_flashdata('session_msg', 'Cập nhật thành công.');
            } else {
                $this->session->set_flashdata('session_error', 'Không thể cập nhật dữ liệu.');
            }

            // print_r($data);
            // exit();
            redirect(base_url('manage_post'));;
        }
        //Load View
        $this->data['meta_title'] = ($id) ? 'Sửa bài viết' : 'Viết bài mới';
        $this->data['sub_view'] = 'admin/manage_post/edit';
        $this->data['sub_js'] = 'admin/manage_post/edit-js';
        $this->load->view('admin/_layout_main', $this->data);
    }

    public function delete($id = NULL)
    {
        $post = $this->manage_post_model->get($id, true);

        if (!$this->has_permission('delete', $post->category)) $this->not_permission();
        $post_id = $this->input->post('ids');
        if ($id) {
            $post_id[] = $id;
        }
        if ($this->manage_post_model->updateStatus($post_id, 3)) {

            //save history
            $_action = 'Deleted';
            foreach ($post_id as $key => $val) {
                $this->history_model->add_history(NULL, $_action, $val, 'post');
            }

            $this->session->set_flashdata('session_msg', 'Xóa dữ liệu thành công');
            return true;
        } else {
            $this->session->set_flashdata('session_error', 'Không xóa được dữ liệu');
            return false;
        }
        return false;
    }

    public function _unique_slug($str)
    {
        //Don't validate form if this slug already
        $id = $this->uri->segment(3);
        $this->db->where('slug', $this->input->post('slug'));
        !$id || $this->db->where('id !=', $id);
        $article = $this->manage_post_model->get();
        if (count($article)) {
            $this->form_validation->set_message('_unique_slug', '%s should be Unique');
            return FALSE;
        }
        return TRUE;
    }

    public function getListpostData()
    {
        $result = $this->manage_post_model->dataGrid();
        header('Content-Type: application/json');
        echo json_encode($result);
    }

    public function apis($action)
    {
        $fnc = "__{$action}";
        $this->$fnc();
    }

    private function __removeNews()
    {
        if ($this->data['userdata']['level'] > 1)
            $this->jsonResponse(400, lang('not_permission'), []);

        $id = intval($this->input->post('id'));
        $this->manage_post_model->removeNews($id);
        $this->jsonResponse(200, 'success', []);
    }

    private function __togglePublic()
    {
        $id = intval($this->input->post('id'));
        $post = $this->manage_post_model->get($id);
        $data = [
            'is_public' => ($post->is_public) ? 0 : 1
        ];
        $this->manage_post_model->save($data, $id);
        $this->jsonResponse(200, 'success');
    }
}
