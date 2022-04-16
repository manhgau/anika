<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <a class="btn btn-success btn-sm" href="<?php echo base_url('admin/customer/edit'); ?>" style="color:#fff;"><i class="fa fa-plus"></i> Add New </a>
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Customer Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Company</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($customers)) : foreach($customers as $customer) : ?>
                            <tr>
                                <td><a href="<?php echo base_url('customer/edit/' . $customer->id);?>"><?php echo $customer->fullname; ?></a></td>
                                <td><?php echo $customer->email; ?></td>
                                <td><input type="checkbox" <?php if($customer->status==1) : ?>checked="checked"<?php else: echo('disable="true"'); endif; ?> /></td>
                                <td><?php echo $customer->company; ?></td>
                                <td><?php echo $customer->address; ?></td>
                                <td><?php echo $customer->phone; ?></td>
                                <td><?php echo btn_delete('customer/delete/' . $customer->id); ?></td>
                            </tr>
                            <?php endforeach; else: ?>
                            <tr><td colspan="7"><h3>We could not found any customers!</h3></td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>