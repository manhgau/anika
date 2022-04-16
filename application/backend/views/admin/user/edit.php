<section class="content">
    <div class="row">
        <div class="col-md-12">
            <?php if( isset($out_of_power) ): ?>
            <h3 class="error">Bạn không đủ quyền để thực hiện thao tác này!</h3>
            <?php else: ?>
            <div class="box box-primary">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="box-body row">
                        <div class="col-md-9">
                            <div class="form-group">
                                <label for="name">Name</label> <?php echo my_form_error('name');?>
                                <?php echo form_input('name', set_value('name', $user->name),'class="form-control" id="name"'); ?>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label> <?php echo my_form_error('email');?>
                                <?php echo form_input('email', set_value('email', $user->email),'class="form-control" id="email"'); ?>
                            </div>
                            <div class="form-group">
                                <label for="email">Lời tựa</label> <?php echo my_form_error('email');?>
                                <textarea name="intro" class="form-control" id="tinymce"><?php echo ($user->intro); ?></textarea>
                            </div>
                             
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="input-status">Trạng thái</label> <?php echo my_form_error('status');?>
                                <select name="status" id="input-status" class="form-control" <?php if($userdata['level'] > 1) echo 'readonly="readonly"';?>>
                                    <option value="1" <?php if($user->status==1) echo 'selected="selected"';?>>Activated</option>
                                    <option value="2" <?php if($user->status==2) echo 'selected="selected"';?>>Disabled</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="level">Level</label> <?php echo my_form_error('level');?>
                                <?php 
                                if($userdata['level']==1)
                                    echo form_dropdown('level',$user_levels,$user->level,'class="form-control" id="level"'); 
                                else
                                    echo form_dropdown('level',$user_levels,$user->level,'class="form-control" readonly id="level"');
                                ?>
                            </div>       
                            <div class="form-group">
                                <label for="uploadFile">Ảnh đại diện</label> 
                                <?php echo my_form_error('image');?>
                                <input type="file" id="uploadFile" name="image" accept="image/*" />
                                <div id="imagePreview" style="background-image:url('<?=get_image($user->image);?>');"></div>
                            </div>

                            <div class="form-group">
                                <label for="password">Password</label> <?php echo my_form_error('password');?>
                                <?php echo form_password('password','','class="form-control" id="password"'); ?>
                            </div>                        
                            <div class="form-group">
                                <label for="password_confirm">Confirm Password</label> <?php echo my_form_error('password_confirm');?>
                                <?php echo form_password('password_confirm','','class="form-control" id="password_confirm"');?>
                            </div>
                        </div>
                        
                    </div><!-- /.box-body -->
                    <div class="box-footer">
                        <?php echo form_submit('submit','Save','class="btn btn-primary"');?>
                    </div>
                </form>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>