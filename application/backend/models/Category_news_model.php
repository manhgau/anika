<?php
class Category_news_model extends MY_Model{
    
    protected $_table_name  = 'category_news';
    protected $_primary_key = 'id';
    protected $_order_by    = 'id ASC';
    public    $rules        = array (
        'news_id'            => array(
            'field'   => 'news_id',
            'rules'   => 'intval|required' ),
        'category_id'           => array(
            'field'   => 'category_id',
            'rules'   => 'trim|intval' )
        );
    
    
    public function __construct() {
        parent::__construct();
    }
    
    public function get_new() {
        $data = new stdClass();
        $data->news_id = NULL;
        $data->category_id = NULL;
        return $data;
    }
    
    public function updateCategoryNews($oldCategoryNews, $newCategoryNews)
    {

    }

    public function getCategoryByNews($newsId)
    {
        $this->db->select('news_id, category_id');
        $this->db->from($this->_table_name);
        $this->db->where('news_id', $newsId);
        return $this->db->get()->result();
    }

    public function removeCategoryByNews($newsId)
    {
        $this->db->where('news_id', $newsId);
        $this->db->delete($this->_table_name);
    }

    public function addCategoryNews($newsId, $categoryId)
    {
        // Fetch all category 
        $this->db->select('id, parent_id, title');
        $this->db->from('category');
        $categories = $this->db->get()->result();
        foreach ($categories as $key => $value) {
            $allCategories[$value->id] = $value;
        }

        foreach ($categoryId as $key => $_catId) 
        {
            $_thisCat = $allCategories[$_catId];
            if ($_thisCat->parent_id) 
            {
                $data = [
                    'news_id' => $newsId,
                    'category_id' => $_thisCat->parent_id
                ];
                $this->save($data, NULL);
            }
            $data = [
                'news_id' => $newsId,
                'category_id' => $_catId
            ];
            $this->save($data, NULL);
        }
    }
}