<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <a class="btn btn-success btn-sm" href="<?php echo base_url('admin/saleoff/edit'); ?>" style="color:#fff;"><i class="fa fa-plus"></i> Thêm mới </a>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Slugname</th>
                                <th>Parent</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($saleoffs)) : foreach($saleoffs as $saleoff) : ?>
                            <tr>
                                <td><?php echo $saleoff->name; ?></td>
                                <td><?php echo $saleoff->slug; ?></td>
                                <td><?php echo $saleoff->off_percent; ?></td>
                                <td><?php echo btn_edit('admin/saleoff/edit/'.$saleoff->id); ?></td>
                                <td><?php echo btn_delete('admin/saleoff/delete/' . $saleoff->id); ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <tr><td colspan="5"><h3>We could not found any saleoffs!!!</h3></td></tr>
                            </tr>
                            <?php endif; ?>                            
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>