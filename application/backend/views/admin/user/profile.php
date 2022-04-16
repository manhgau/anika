<section class="content">
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <form action="" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="name">Name</label> <?php echo my_form_error('name');?>
                            <?php echo form_input('name',set_value('name',$user->name),'class="form-control" id="name"'); ?>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label> <?php echo my_form_error('email');?>
                            <?php echo form_input('email',set_value('email',$user->email),'class="form-control" id="email"'); ?>
                        </div>
                        <div class="form-group">
                            <label for="input-status">Trạng thái: </label> <?php echo my_form_error('status');?>
                            <?php echo ($user->status==1) ? 'Enabled' : 'Disabled' ;?>
                        </div>
                        <div class="form-group">
                            <label for="level">Level: </label> <?php echo my_form_error('level');?>
                            <?php 
                                echo config_item('user_levels')[$user->level];
                            ?>
                        </div> 
                        <div class="form-group">
                            <label for="uploadFile">Ảnh đại diện</label> 
                            <?php echo my_form_error('image');?>
                            <input type="file" id="uploadFile" name="image" accept="image/*" />
                            <div id="imagePreview" style="background-image:url('<?=get_image($user->image);?>');"></div>
                        </div>                       
                        <hr>
                        <h3 class="box-title" onclick="toggle_seo();" id="seo-box-title">Đổi mật khẩu</h3>
                        <div class="seo-box">
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
        </div>
    </div>
</section>