<section class="content">
    <div class="row">
        <section class="content">
            <div class="row">
                <style type="text/css">.small-box > .inner{padding:0 10px}</style>
                <div class="col-lg-2 col-xs-6">
                    <!-- small box -->
                    <div class="small-box <?php echo (!$status) ? 'bg-gray' : 'bg-aqua';?>">
                        <div class="inner">
                            <p>Tất cả: <strong style="font-size:1.4em"><?php echo $newsReport['myNews']; ?></strong></p>
                        </div>
                        <a href="<?php echo link_to_my_news($author->id); ?>" class="small-box-footer">
                            Xem danh sách <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-2 col-xs-6">
                    <!-- small box -->
                    <div class="small-box <?php echo ($status==1) ? 'bg-gray' : 'bg-green';?>">
                        <div class="inner">
                            <p>Đã duyệt: <strong style="font-size:1.4em"><?php echo $newsReport['myNewsApproved']; ?></strong></p>
                        </div>
                        <a href="<?php echo link_to_my_news($author->id,1); ?>" class="small-box-footer">
                            Xem danh sách <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-2 col-xs-6">
                    <!-- small box -->
                    <div class="small-box <?php echo ($status==2) ? 'bg-gray' : 'bg-yellow';?>">
                        <div class="inner">
                            <p>Chờ duyệt: <strong style="font-size:1.4em"><?php echo $newsReport['myNewsPending']; ?></strong></p>
                        </div>
                        <a href="<?php echo link_to_my_news($author->id,2); ?>" class="small-box-footer">
                            Xem danh sách <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-2 col-xs-6">
                    <!-- small box -->
                    <div class="small-box <?php echo ($status==4) ? 'bg-gray' : 'bg-blue';?>">
                        <div class="inner">
                            <p>Đang viết: <strong style="font-size:1.4em"><?php echo $newsReport['myNewsWritting']; ?></strong></p>
                        </div>
                        <a href="<?php echo link_to_my_news($author->id,4); ?>" class="small-box-footer">
                            Xem danh sách <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-2 col-xs-6">
                    <!-- small box -->
                    <div class="small-box <?php echo ($status==5) ? 'bg-gray' : 'bg-black';?>">
                        <div class="inner">
                            <p>Bị trả lại: <strong style="font-size:1.4em"><?php echo $newsReport['myNewsReturn']; ?></strong></p>
                        </div>
                        <a href="<?php echo link_to_my_news($author->id,5); ?>" class="small-box-footer">
                            Xem danh sách <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-2 col-xs-6">
                    <!-- small box -->
                    <div class="small-box <?php echo ($status==3) ? 'bg-gray' : 'bg-red';?>">
                        <div class="inner">
                            <p>Thùng rác: <strong style="font-size:1.4em"><?php echo $newsReport['myNewsTrash']; ?></strong></p>
                        </div>
                        <a href="<?php echo link_to_my_news($author->id,3); ?>" class="small-box-footer">
                            Xem danh sách <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
        </section>
    </div>

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
                                <th>HOT</th>
                                <th>Đọc nhiều</th>
                                <th>Lượt xem</th>
                                <th>Action</th>
                                <th>Tác giả</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($news)) : foreach($news as $key => $article) : ?>
                                <tr>
                                    <td><?=$article->id; ?></td>
                                    <td>
                                        <p><strong><?php echo number_format(++$key + (($paging['current']-1) * $paging['limit']));?></strong> - <a href="<?=base_url('news/edit/'.$article->id);?>"><?php echo $article->title; ?></a></p>                               
                                    </td>
                                    <td><?php $_this_cat = $list_categories[$article->category]; if($_this_cat) echo '<a href="'.base_url('news').'/?cat='.@$_this_cat->id.'">' . @$_this_cat->title . '</a>'; ?></td>
                                    <td><?=date('H:i:s d/m/Y',$article->create_time);?></td>
                                    <td><?=date('H:i:s d/m/Y',$article->public_time);?></td>
                                    <td><?=$article->status;?></td>
                                    <td><?=$article->is_hot;?></td>
                                    <td><?=$article->is_popular;?></td> 
                                    <td><?=$article->hit_view;?></td> 
                                    <td>
                                        <p>
                                            <?php 
                                                echo btn_edit('news/edit/'.$article->id);
                                                $_view_url = config_item('main_domain') .$article->slugname . '-a'.$article->id.'.html';
                                                //echo btn_view($_view_url);
                                                echo btn_delete('news/delete/'.$article->id);
                                            ?>
                                        </p> 
                                    </td>
                                    <td><?php echo $author->name;?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                <tr><td colspan="5"><h3>We could not found any articles!!!</h3></td></tr>
                                </tr>
                                <?php endif; ?>                            
                        </tbody>
                    </table>
                    <div class="row">
                        <nav aria-label="Page navigation">
                          <ul class="pagination pull-right">
                            <?php if($paging['current'] > 1) : ?>
                            <li>
                              <a href="<?php echo link_to_my_news($author->id,$status,$paging['prev']);?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                              </a>
                            </li>
                            <li><a href="<?php echo link_to_my_news($author->id,$status,$paging['prev']);?>"><?php echo $paging['prev']; ?></a></li>
                            <?php endif; ?>
                            <li class="active"><a href="javascript:;"><span><?php echo $paging['current']; ?> <span class="sr-only">(current)</span></span></a></li>
                            <?php if($paging['limit'] <= count($news)) : ?>
                            <li><a href="<?php echo link_to_my_news($author->id,$status,$paging['next']);?>"><?php echo $paging['next']; ?></a></li>
                            <li>
                              <a href="<?php echo link_to_my_news($author->id,$status,$paging['next']); ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                              </a>
                            </li>
                            <?php endif;?>
                          </ul>
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>