<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <?php if( ! $comments) : ?>
                    <div class="box-header">
                        <a class="btn btn-success btn-sm" href="<?php echo base_url('admin/comment/edit'); ?>" style="color:#fff;"><i class="fa fa-plus"></i> Thêm mới </a>
                    </div>
                    <?php endif; ?>
                <div class="box-body table-responsive">
                    <table id="datatable" class="table table-bordered" data-controller="<?=$this->router->class;?>">
                        <thead>
                            <tr>
                                <th><input name="select_all" value="1" id="example-select-all" type="checkbox" /></th>
                                <th>UserName</th>
                                <th>Email</th>
                                <th>Message</th>
                                <th>Trạng thái</th>
                                <th>Bài viết</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if( ! empty($comments)) : 
                                    foreach($comments as $key => $val) : ?>
                                    <tr>
                                        <td><?php echo $val->id;?></td>
                                        <td><?php echo $val->username; ?></td>
                                        <td><?php echo $val->email; ?></td>
                                        <td><pre><?php echo $val->comment; ?></pre></td>
                                        <td><?php echo ($val->status); ?></td>
                                        <td> <a href="<?php echo base_url('news/edit/'.$val->newsId); ?>" target="_blank"><?php $article = $news[$val->newsId]; echo $article->title;?></a> </td>
                                        <td>
                                            <!--<?php echo btn_edit('comments/edit/' . $val->id); ?>&nbsp;-->
                                            <?php echo btn_delete('comments/delete/' . $val->id); ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                <tr><td colspan="6"><h3>We could not found any feedbacks!!!</h3></td></tr>
                                <?php endif; ?>                            
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>