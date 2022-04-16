<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <table id="datatable" class="table table-bordered table-hover" data-controller="<?php echo $this->router->fetch_class();?>">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="check-all" class="simple" name="select_all"></th>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Vai trò</th>
                                <th>Trạng thái</th>
                                <?php if ($userdata['level']==1) :?>
                                <th>Thao tác</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($users)) : foreach($users as $user) : ?>
                            <tr>
                                <td>
                                    <?php echo $user->id; ?>
                                </td>
                                <td>
                                <img src="<?php echo ($user->image) ? get_image($user->image) : base_url('admin/assets/img/avatar3.png');?>" alt="" width="40"> <span style="margin-left:15px"><?php echo $user->name; ?></span>
                                </td>
                                <td><?php echo $user->email; ?></td>
                                <td><?php $user_levels = config_item('user_levels'); echo $user_levels[$user->level]; ?></td>
                                <td><?php echo $user->status; ?></td>
                                <?php if ($userdata['level']==1) :?>
                                <td>
                                    <?php echo btn_edit('user/edit/'.$user->id); ?>
                                    <?php echo btn_delete('user/delete/' . $user->id); ?>                                    
                                </td>
                                <?php endif; ?>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>