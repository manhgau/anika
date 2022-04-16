<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <?php if( ! $feedbacks) : ?>
                    <div class="box-header">
                        <a class="btn btn-success btn-sm" href="<?php echo base_url('admin/feedback/edit'); ?>" style="color:#fff;"><i class="fa fa-plus"></i> Thêm mới </a>
                    </div><!-- /.box-header -->
                    <?php endif; ?>
                <div class="box-body table-responsive">
                    <table id="datatable" class="table table-bordered" data-controller="<?=$this->router->class;?>">
                        <thead>
                            <tr>
                                <th><input name="select_all" value="1" id="example-select-all" type="checkbox" /></th>
                                <th>UserName</th>
                                <th>UserInfo</th>
                                <th>Title</th>
                                <th>Message</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if( ! empty($feedbacks)) : 
                                    foreach($feedbacks as $key => $val) : ?>
                                    <tr>
                                        <td><?php echo $val->id;?></td>
                                        <td><?php echo $val->customer_name; ?></td>
                                        <td><?php echo $val->email; ?></td>
                                        <td><?php echo $val->title; ?></td>
                                        <td><?php echo $val->message; ?></td>
                                        <td>
                                            <?php echo btn_edit('feedback/edit/' . $val->id); ?>&nbsp;
                                            <?php echo btn_delete('feedback/delete/' . $val->id); ?>
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