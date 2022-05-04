<section class="content">
    <div class="row">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="col-md-8 col-md-offset-2">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo lang('member_infomation') ?></h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <?php echo form_element([
                                'label' => 'Họ và tên',
                                'name' => 'fullname',
                                'value' => $member->fullname,
                                'required' => true,
                            ]) ?>
                        </div>
                        <div class="form-group">
                            <?php echo form_element([
                                'label' => 'Email',
                                'name' => 'email',
                                'value' => $member->email,
                                'type' => 'email',
                                'class' => 'form-control',
                                'required' => true,
                            ]) ?>
                        </div>
                        <div class="form-group">
                            <?php echo form_element([
                                'label' => 'Số điện thoại',
                                'name' => 'phone',
                                'value' => $member->phone,
                                'required' => true,
                            ]) ?>
                        </div>
                        <div class="form-group">
                            <?php 
                            $allStatus = $this->member_model->getStatus();
                            $options = ['' => '--- chọn trạng thái ---'] + array_combine(array_keys($allStatus), array_column($allStatus, 'name'));
                            echo form_element([
                                'name' => 'status',
                                'value' => $member->status,
                                'label' => 'Trạng thái',
                                'type' => 'select',
                                'options' => $options,
                                'required' => true
                            ]);
                            ?>
                        </div>
                        <div class="form-group">
                            <?php
                            $allType = $this->setting_department_model->getList();
                            $options = ['' => 'Chọn phòng ban'] + array_combine(array_column($allType, 'id'), array_column($allType, 'name'));
                            echo form_element([
                                'name' => 'department_id',
                                'value' => $member->department_id,
                                'label' => 'Danh mục phòng ban',
                                'type' => 'select',
                                'options' => $options,
                                'required' => true,
                            ]);
                            ?>
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
                    </div>
                    <div class="box-footer">
                        <?php 
                            echo form_hidden('id', $member->id);
                            echo form_submit('publish','Cập nhật','class="btn btn-success"');
                        ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>