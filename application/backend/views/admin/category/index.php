<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body table-responsive">
                    <table id="datatable" class="table table-bordered" data-controller="<?=$this->router->class;?>">
                        <thead>
                            <tr>
                                <th><input name="select_all" value="1" id="example-select-all" type="checkbox" /></th>
                                <th>Tên</th>
                                <th>Link</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($categories)) : foreach($categories as $category) : ?>
                            <tr>
                                <td><?=$category->id;?></td>
                                <td><?php for($i=1;$i<$category->level;$i++){echo '&mdash;';} echo '&nbsp;' . $category->title; ?></td>
                                <td><?php echo link_preview_news_category($category->id, $category->slugname); ?></td>
                                <td class="text-center"><?=$category->status;?></td>
                                <td class="text-right">
                                    <?php echo btn_edit('category/edit/'.$category->id); ?>
                                    <?php echo btn_delete('category/delete/' . $category->id); ?>
                                        
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr><td colspan="5"><h3>Chưa có chuyên mục nào!!!</h3></td></tr>
                            <?php endif; ?>                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>