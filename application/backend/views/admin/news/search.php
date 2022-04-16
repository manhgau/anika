<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body table-responsive">
                    <table id="datatable" class="table table-bordered table-striped dataTable" data-controller="<?=$this->router->class;?>">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="check-all" name="select_all"></th>
                                <th>Tiêu đề</th>
                                <th>Chuyên mục</th>
                                <th>Giờ viết</th>
                                <th>Giờ hiển thị</th>
                                <th>Trạng thái</th>
                                <th>Tác giả</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($articles)) : foreach($articles as $key => $article) : ?>
                                <tr>
                                    <td><?=$article->id; ?></td>
                                    <td>
                                        <p><a href="<?=base_url('news/edit/'.$article->id);?>"><?php echo $article->title; ?></a></p>                               
                                    </td>
                                    <td><?php if(isset($list_categories[$article->category])) {$_this_cat = $list_categories[$article->category]; if($_this_cat) echo '<a href="'.base_url('news').'/?cat='.$_this_cat->id.'">' . $_this_cat->title . '</a>';}  ?></td>
                                    <td><?=date('H:i:s d/m/Y',$article->create_time);?></td>
                                    <td><?=date('H:i:s d/m/Y',$article->public_time);?></td>
                                    <td><?=$article->status;?></td>
                                    <td><?php echo (isset($authors[$article->create_by])) ? $authors[$article->create_by]->name : '';?></td>
                                    <td>
                                        <p>
                                        <?php 
                                        echo btn_edit('news/edit/'.$article->id);
                                        $_view_url = config_item('main_domain') .$article->slugname . '-a'.$article->id.'.html';
                                        echo btn_view($_view_url);
                                        echo btn_delete('news/delete/'.$article->id);
                                        ?>
                                        </p> 
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                <tr><td colspan="5"><h3>We could not found any articles!!!</h3></td></tr>
                                </tr>
                                <?php endif; ?>                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>