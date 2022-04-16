<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <form action="" method="post">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Avatar</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Level</th>
                                <th>Status</th>
                                <th>Xem</th>
                                <th>Thêm mới</th>
                                <th>Sửa</th>
                                <th>Xóa</th>
                                <th>Chuyên mục</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $default_perms = config_item('permission');
                                if(!empty($users)) : foreach($users as $user) : 
                                $_action_perm = (isset($list_permission[$user->id])) ? $list_permission[$user->id]->action_perm : 1;
                                $_category_perm = (isset($list_permission[$user->id])) ? $list_permission[$user->id]->category_perm : 0;
                            ?>
                            <tr>
                                <td>
                                    <img src="<?php echo ($user->image) ? get_image($user->image) : base_url('admin/assets/img/avatar3.png');?>" alt="" width="40">
                                </td>
                                <td>
                                <p><?php echo $user->name; ?></p>
                                </td>
                                <td><?php echo $user->email; ?></td>
                                <td><?php $user_levels = config_item('user_levels'); echo $user_levels[$user->level]; ?></td>
                                <td><i class="glyphicon <?php if($user->status == 1) echo 'glyphicon-ok blue'; else echo 'glyphicon-minus orange'; ?>"></i></td>
                                <?php if ($userdata['level']==1) :?>
                                <td> <?php if($_action_perm & $default_perms['view']) echo '<i class="fa fa-check" style="color:green;"></i>'; ?></td>
                                <td> <?php if($_action_perm & $default_perms['add']) echo '<i class="fa fa-check" style="color:green;"></i>'; ?></td>
                                <td> <?php if($_action_perm & $default_perms['edit']) echo '<i class="fa fa-check" style="color:green;"></i>'; ?></td>
                                <td> <?php if($_action_perm & $default_perms['delete']) echo '<i class="fa fa-check" style="color:green;"></i>'; ?></td>
                               
                                <td>
                                    <select class="form-control" name="category_perm[<?php echo $user->id;?>][]" multiple="multiple" style="height:150px;">
                                        <option value="0">- Tất cả chuyên mục -</option>
                                        <?php 
                                        foreach($list_category as $key => $val)
                                        {
                                            if($val->parent_id==0)
                                            {
                                                if(in_array($val->id,explode(',',$_category_perm)))
                                                    echo '<option value="'.$val->id.'" selected="selected">'.$val->title.'</option>';
                                                else
                                                    echo '<option value="'.$val->id.'">'.$val->title.'</option>'; 
                                                if(has_cat_child($list_category, $val->id))
                                                {
                                                    foreach ($list_category as $k => $child) {
                                                        if($child->parent_id==$val->id) {
                                                            if(in_array($child->id,explode(',',$_category_perm)))
                                                                echo '<option value="'.$child->id.'" selected="selected"> &mdash; '.$child->title.'</option>';
                                                            else
                                                                echo '<option value="'.$child->id.'">&mdash; '.$child->title.'</option>';   
                                                        }   
                                                    }
                                                }
                                            }
                                            
                                        }
                                        ?>
                                    </select>
                                </td>
                                <?php else: endif; ?>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <p style="margin:20px 0;">
                        <button type="submit" class="btn btn-success btn-large"> <i class="fa fa-floppy-o"></i> Lưu</button>
                    </p>
                    </form>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>