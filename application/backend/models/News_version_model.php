<?php
class News_version_model extends MY_Model
{

    protected $_table_name = 'news_version';
    protected $_primary_key = 'id';
    protected $_order_by = 'id DESC, public_time DESC';
    public    $rules = array(
        'news_id' => array(
            'field'   => 'news_id',
            'rules'   => 'intval|required' ),
        'title' => array(
            'field'   => 'title',
            'rules'   => 'trim|required' )
    );

    public function __construct(){
        parent::__construct();
    }

    public function getNew(){
        $data = new stdClass();
        $data->news_id = NULL;
        $data->title = '';
        $data->slug = '';
        $data->description = '';
        $data->content = '';
        $data->meta_title = '';
        $data->meta_description = '';
        $data->meta_keyword = '';
        $data->tags_id = '';
        $data->public_time = time();
        $data->create_time = time();
        $data->update_time = time();
        $data->create_by = $this->session->userdata['id'];
        $data->update_by = $this->session->userdata['id'];
        $data->thumbnail = '';
        $data->category = 0;
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

    public function getBackupByNews($id)
    {
        $this->db->select('id, news_id, title, description, content, meta_title, meta_description, meta_keyword, tags_id, create_time, create_by, update_by, thumbnail, category, status, is_hot, is_popular, relate_news, source_url, audio_file');
        $this->db->where('news_id', $id);
        $this->db->order_by('create_time ASC');
        return $this->get();
    }
}