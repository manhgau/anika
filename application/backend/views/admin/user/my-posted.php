<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header" style="margin: 10px 0 0 0;padding: 10px 0 0px 0;">
                    <strong style="margin:0 10px">Lọc </strong>&nbsp;
                    <?php if(!empty($tree_categories)):?>
                        <select id="category-filter" class="form-control filter" style="width:200px;display:inline-block">
                            <option value="0" <?php if($category_id==0) echo 'selected="selected"'; ?>> -- Danh mục -- </option>
                            <?php foreach ($tree_categories as $key => $val) : ?>
                                <option value="<?php echo $val->id?>" <?php if($val->id == $category_id) echo 'selected="selected"';?>> <?php for($i=1;$i<$val->level;$i++){echo '&mdash;';} echo '&nbsp;' . $val->title; ?> </option>
                                <?php endforeach; ?>
                        </select>
                        <?php endif;?>
                    <select id="status-filter" class="form-control filter" style="width:200px;display:inline-block">
                        <option value="0" <?php if($filters['status']==0) echo 'selected="selected"'; ?>> -- Trạng thái -- </option>
                        <option value="1" <?php if($filters['status']==1) echo 'selected="selected"'; ?>> Đã duyệt </option>
                        <option value="2" <?php if($filters['status']==2) echo 'selected="selected"'; ?>> Chờ duyệt </option>
                        <option value="3" <?php if($filters['status']==3) echo 'selected="selected"'; ?>> Đã xóa </option>
                    </select>
                    <select id="hot-filter" class="form-control filter" style="width:200px;display:inline-block">
                        <option value="0" <?php if($filters['is_hot']==0) echo 'selected="selected"'; ?>> -- HOT hoặc không -- </option>
                        <option value="1" <?php if($filters['is_hot']==1) echo 'selected="selected"'; ?>> Tin HOT </option>
                    </select>
                    <select id="popular-filter" class="form-control filter" style="width:200px;display:inline-block">
                        <option value="0" <?php if($filters['is_popular']==0) echo 'selected="selected"'; ?>> -- Tất cả -- </option>
                        <option value="1" <?php if($filters['is_popular']==1) echo 'selected="selected"'; ?>> Tin đọc nhiều </option>
                    </select>
                </div>
                <hr class="line">
                <div class="box-body table-responsive">
                    <table id="datatable" class="table table-bordered" data-controller="<?=$this->router->class;?>">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="check-all" name="select_all"></th>
                                <th>Tiêu đề</th>
                                <th>Chuyên mục</th>
                                <th>Giờ viết</th>
                                <th>Giờ hiển thị</th>
                                <th>Trạng thái</th>
                                <th>HOT</th>
                                <th>Đọc nhiều</th>
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
                                    <td><?php $_this_cat = $list_categories[$article->category]; if($_this_cat) echo '<a href="'.base_url('news').'/?cat='.@$_this_cat->id.'">' . @$_this_cat->title . '</a>'; ?></td>
                                    <td><?=date('H:i:s d/m/Y',$article->create_time);?></td>
                                    <td><?=date('H:i:s d/m/Y',$article->public_time);?></td>
                                    <td><?=$article->status;?></td>
                                    <td><?=$article->is_hot;?></td>
                                    <td><?=$article->is_popular;?></td>
                                    <td>
                                        <p>
                                        <?php 
                                        echo btn_edit('news/edit/'.$article->id);
                                        $_view_url = config_item('domain').$article->slugname . '-a'.$article->id.'.html';
                                        echo btn_view($_view_url);
                                        echo btn_delete('news/delete/'.$article->id);
                                        ?>
                                        </p> 
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                <tr><td colspan="5"><h3>We could not found any your posted!!!</h3></td></tr>
                                </tr>
                                <?php endif; ?>                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>