<section class="content">
    <div class="row">
        <form method="post">
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"><?php if(isset($link->id)) echo 'Sửa: <strong>' . $link->keyword . '</strong>'; else echo 'Thêm mới'?></h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="keyword">Keyword</label> <?php echo my_form_error('keyword');?>
                            <?php echo form_input('keyword',set_value('keyword',$link->keyword),'class="form-control" id="keyword"'); ?>
                        </div>                        
                        <div class="form-group">
                            <label for="link">Link</label> <?php echo my_form_error('link');?>
                            <?php echo form_input('link',set_value('link',$link->link),'class="form-control" id="link"'); ?>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label> <?php echo my_form_error('status');?>
                            <?php echo form_checkbox('status','1',($link->status==1) ? TRUE : FALSE,'class="form-control" id="status"')?>
                        </div> 
                    </div>
                    <div class="box-footer">
                        <?php echo form_submit('submit','Lưu','class="btn btn-primary"');?>
                    </div>
                </div>
            </div>
        </form>

        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Danh sách Link</h3>
                </div>
                <div class="box-body">
                    <table id="datatable" class="table table-bordered table-striped dataTable" data-controller="<?=$this->router->class;?>">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="check-all" name="select_all"></th>
                                <th>Từ khóa</th>
                                <th>Link</th>
                                <th>Status</th>
                                <th>Sửa/xóa</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($links)) : foreach($links as $key => $link) : ?>
                                <tr>
                                    <td><?=$link->id; ?></td>
                                    <td><a href="<?=base_url('backlink/index/'.$link->id);?>"><?php echo $link->keyword; ?></a>
</td>
                                    <td><?php echo $link->link; ?></td>
                                    <td><?php echo $link->status;?></td>
                                    <td><?php echo btn_edit('backlink/index/'.$link->id); echo btn_delete('backlink/delete/'.$link->id); ?></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                <tr><td colspan="5"><h3>We could not found any Backlinks!!!</h3></td></tr>
                                </tr>
                                <?php endif; ?>                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>