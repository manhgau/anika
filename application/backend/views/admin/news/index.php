<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <form action="" method="get" style="padding:15px;background:#eaf7ff">
                    <div class="box-header">
                        <div class="row form-group">
                            <div class="col-xs-3">
                                <label for="find-keyword">Từ khóa</label>
                                <input id="find-keyword" class="form-control" name="keyword" value="<?php echo $filters['keyword']; ?>">
                            </div>
                            <div class="col-xs-3">
                                <?php if(!empty($tree_categories)):?>
                                <label>Chuyên mục</label>
                                <select id="category-filter" class="form-control filter" name="cat">
                                    <option value="0" <?php if($category_id==0) echo 'selected="selected"'; ?>> -- Tất cả chuyên mục -- </option>
                                    <?php foreach ($tree_categories as $key => $val) : ?>
                                        <option value="<?php echo $val->id?>" <?php if($val->id == $category_id) echo 'selected="selected"';?>> <?php for($i=1;$i<$val->level;$i++){echo '&mdash;';} echo '&nbsp;' . $val->title; ?> </option>
                                        <?php endforeach; ?>
                                </select>
                                <?php endif;?>
                            </div>
                            <div class="col-xs-3">
                                <label>Tác giả</label>
                                <input id="autoComplete" class="form-control" name="authorName" value="<?php echo $filters['authorName']; ?>">
                            </div>
                            <div class="col-xs-3">
                                <label>Trạng thái</label>
                                <select id="status-filter" class="form-control filter" name="status">
                                    <option value="0" <?php if($filters['status']==0) echo 'selected="selected"'; ?>> -- Trạng thái -- </option>
                                    <option value="1" <?php if($filters['status']==1) echo 'selected="selected"'; ?>> Đã duyệt </option>
                                    <option value="2" <?php if($filters['status']==2) echo 'selected="selected"'; ?>> Chờ duyệt </option>
                                    <option value="3" <?php if($filters['status']==3) echo 'selected="selected"'; ?>> Đã xóa </option>
                                </select>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-3">
                                <label><input type="checkbox" name="is_hot" value="1" <?php if($filters['is_hot']==1) echo 'checked="checked"'; ?>> Bài HOT</label>
                            </div>
                        </div>
                        <hr class="line" style="margin:0 0 10px;border-color:#e4e4e4">
                        <div class="row">
                            <div class="col-xs-12">
                            <button type="submit" class="btn btn-sm btn-primary"> <i class="fa fa-search"></i> Tìm kiếm</button>
                            <a class="btn btn-sm btn-default" href="<?php echo base_url('news');?>"> <i class="fa fa-refresh"></i> Reset</a>
                            </div>
                        </div>
                    </div>
                </form>
                <hr class="line">
                <div class="box-body table-responsive">
                    <table id="datatable" class="table table-bordered table-striped dataTable" data-controller="<?=$this->router->class;?>">
                        <thead>
                            <tr>
                                <th><input type="checkbox" class="simple" id="check-all" name="select_all"></th>
                                <th>Ảnh</th>
                                <th>Tiêu đề</th>
                                <th>Chuyên mục</th>
                                <th>Ngày tạo</th>
                                <th>Trạng thái</th>
                                <th>HOT</th>
                                <th>Lượt xem</th>
                                <th>Action</th>
                                <th>Tác giả</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($articles)) : foreach($articles as $key => $article) ?>
                                

                                <tr id="row-<?php echo $article->id; ?>">
                                    <td><?php echo $article->id; ?></td>
                                    <td style="max-width:150px">
                                        <img src="<?php echo getImageUrl($article->highlight_image);?>" alt="Image" style="max-width:200px;height:60px">
                                    </td>
                                    <td>
                                        <p><a href="<?php echo base_url('news/edit/'.$article->id);?>"><?php echo $article->title; ?></a></p>                               
                                    </td>
                                    <td>
                                        <?php if($article->categories) : foreach($article->categories as $_catKey => $_cat) : ?>
                                            <a href="<?php echo base_url('news/?cat='. $_cat->id);?>"><?php echo '- ', $_cat->title, '<br/>'; ?></a>
                                        <?php endforeach; endif; ?>
                                    </td>
                                    <td><?php echo date('H:i:s d/m/Y',strtotime($article->create_time));?></td>

                                    <td><?php echo $article->status;?></td>
                                    <td><?php echo $article->is_hot;?></td>
                                    <td>
                                        <?php echo ($article->status != 3) ? $article->hit_view : '0'; ?>
                                    </td>
                                    <td>
                                        <p>
                                            <?php 
                                                echo btn_edit('news/edit/'.$article->id);
                                                $_view_url = config_item('main_domain') .$article->slugname . '-a'.$article->id.'.html';
                                                if($article->status != 1 || ($article->status==1 && $userdata['level']==1))
                                                    echo btn_delete('news/delete/'.$article->id);
                                            ?>
                                            <?php if($userdata['level']<=3) : ?>
                                                <?php if($article->status != 1 || ($article->status==1 && $userdata['level']==1)) : ?>
                                                <a href="javascript:;" class="btn btn-default btn-xs btn-return-news" data-id="<?php echo $article->id;?>" title="Trả bài"> <i class="fa fa-retweet" style="color:#f00;"></i> </a>
                                                <?php endif; ?>

                                                <?php if($article->update_by) : ?>
                                                    <a href="<?php echo base_url('news/compareVersion/'.$article->id); ?>" class="btn btn-default btn-xs" title="Lịch sử thay đổi"> <i class="fa fa-history"></i> </a>
                                                <?php endif;?>
                                            <?php endif; ?>
                                            <?php if($article->status==1) : ?>
                                                <a href="<?php echo link_preview_detail_news($article->slugname, $article->id);?>" class="btn btn-info btn-xs" title="Xem chi tiết" target="_blank"> <i class="fa fa-eye"></i> </a>
                                                <?php else : ?>
                                                <button type="button" class="btn btn-xs btn-info" data-id="<?php echo $article->id;?>" data-toggle="modal" data-target="#modal-preview-content">xem trước</button>
                                                <?php endif; ?>
                                        </p> 
                                    </td>
                                    <td><?php echo (isset($authors[$article->create_by])) ? $authors[$article->create_by]->name : '';?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                <tr><td colspan="5"><h3>We could not found any articles!!!</h3></td></tr>
                                </tr>
                                <?php endif; ?>                            
                        </tbody>
                    </table>

                    <div class="dataTables_paginate paging_simple_numbers" id="datatable_paginate">
                        <?php 
                            $strFilter = array();
                            if($filters)
                            {
                                foreach($filters as $key => $val)
                                {
                                    $strFilter[] = "{$key}={$val}";
                                }
                            }
                            if($paging['current'] > 1) : ?>
                            <a class="paginate_button previous disabled" aria-controls="datatable" data-dt-idx="0" tabindex="0" id="datatable_previous" href="<?php echo base_url("news/index/?" . implode('&',$strFilter)) . '&page='.$paging['prev']; ?>">Previous</a>
                            <a class="paginate_button previous disabled" aria-controls="datatable" data-dt-idx="0" tabindex="0" id="datatable_previous" href="<?php echo base_url("news/index/?" . implode('&',$strFilter)) . '&page='.$paging['prev']; ?>"><?php echo $paging['prev']?></a>
                            <?php endif; ?>
                        <a class="paginate_button current" href="<?php echo base_url("news/index/?" . implode('&',$strFilter)) . '&page='.$paging['prev']; ?>"><?php echo $paging['current']; ?></a>
                        <?php if(count($articles) >= $paging['limit']) : ?>
                            <a class="paginate_button next" href="<?php echo base_url("news/index/?" . implode('&',$strFilter)) . '&page='.$paging['next']; ?>"><?php echo $paging['next']; ?></a>
                            <a class="paginate_button next" href="<?php echo base_url("news/index/?" . implode('&',$strFilter)) . '&page='.$paging['next']; ?>">Next</a>
                            <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade bd-example-modal-lg" id="modal-preview-content" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" style="font-weight:600;font-size:1.7rem" id="exampleModalLongTitle">Modal title</h5>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>