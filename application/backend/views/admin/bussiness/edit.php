<section class="content">

    <?php /*
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="#summary" aria-controls="summary" role="tab" data-toggle="tab">Thông tin công ty</a></li>
        <li role="presentation"><a href="#payment" aria-controls="payment" role="tab" data-toggle="tab">Tài khoản thanh toán</a></li>
        <li role="presentation"><a href="#social" aria-controls="social" role="tab" data-toggle="tab">Liên kết xã hội</a></li>
        <li role="presentation"><a href="#account" aria-controls="account" role="tab" data-toggle="tab">Tài khoản hệ thống</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div role="tabpanel" class="tab-pane active" id="summary">
            
        </div>
        <div role="tabpanel" class="tab-pane" id="payment">

        </div>
        <div role="tabpanel" class="tab-pane" id="social">

        </div>
        <div role="tabpanel" class="tab-pane" id="account">

        </div>
    </div>
    */ ?>
    <div class="row">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header">
                        <h4 class="box-title">Thông tin công ty</h4>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="input-title">Tên đầy đủ</label> <?php echo my_form_error('title');?>
                            <input type="text" class="form-control" id="input-title" value="<?php echo htmlspecialchars($bussiness->title);?>" name="title">
                        </div> 
                        <div class="form-group row">
                            <div class="col-xs-6">
                                <label for="input-display_name">Tên viết tắt (tên hiển thị)</label> <?php echo my_form_error('display_name');?>
                                <input type="text" class="form-control" id="input-display_name" value="<?php echo htmlspecialchars($bussiness->display_name);?>" name="display_name" required>
                            </div>
                            <div class="col-xs-6">
                                <label>Người đại diện (Giám đốc)</label>
                                <input type="text" name="director_name" class="form-control" value="<?php echo ($bussiness->director_name); ?>">
                            </div>
                        </div> 
                        <div class="form-group row">
                            <div class="col-xs-4">
                                <label for="input-description">Địa điểm đăng ký kinh doanh</label> <?php echo my_form_error('province_id');?>
                                <input type="text" class="form-control" name="province_id" id="token-input-location">
                            </div>
                            <div class="col-xs-4">
                                <label for="input-description">Mã số đăng ký kinh doanh</label> <?php echo my_form_error('province_id');?>
                                <input type="text" class="form-control" name="bussiness_code" value="<?php echo $bussiness->bussiness_code; ?>">
                            </div>
                            <div class="col-xs-4">
                                <label for="input-tax_code">Mã số thuế</label> <?php echo my_form_error('tax_code');?>
                                <input type="text" class="form-control" name="tax_code" value="<?php echo $bussiness->tax_code; ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-xs-4">
                                <label>Email</label>
                                <input type="text" name="email" class="form-control" value="<?php echo ($bussiness->email); ?>">
                            </div>
                            <div class="col-xs-4">
                                <label>Số điện thoại</label>
                                <input type="text" name="phone" class="form-control" value="<?php echo ($bussiness->phone); ?>">
                            </div>
                            <div class="col-xs-4">
                                <label>Fax</label>
                                <input type="text" name="fax" class="form-control" value="<?php echo ($bussiness->fax); ?>">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-xs-6">
                                <label>Địa chỉ</label>
                                <input type="text" name="address" class="form-control" value="<?php echo ($bussiness->address); ?>">
                            </div>
                            <div class="col-xs-6">
                                <label>Website</label>
                                <input type="text" name="website" class="form-control" value="<?php echo ($bussiness->website); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="tinymce1">Giới thiệu công ty</label> <?php echo my_form_error('description');?>
                            <textarea name="description" rows="5" class="form-control" id="tinymce1"><?php echo $bussiness->description;?></textarea>
                        </div>
                    </div>
                    <div class="box-footer">
                        <?php echo form_submit('submit','Save','class="btn btn-primary"');?>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">Tài khoản hệ thống</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Tên đăng nhập</label>
                            <input type="text" name="login_name" class="form-control" required value="<?php echo $bussiness->login_name; ?>">
                        </div>
                        <div class="form-group">
                            <label>Mật khẩu <small>(default: 123abc456)</small></label>
                            <input type="password" name="password" class="form-control" value="" >
                        </div>
                        <div class="form-group">
                            <label for="thumbnail">Ảnh đại diện <span class="required">*</span></label>
                              <?php echo form_error('image');?>
                             <p><button id="upload-single" type="button"><span>Tải ảnh từ máy tính</span></button> <small> (800x450) </small> </p>
                              <p><span id="status-single"></span></p>
                             <div id="singleUploaded">
                                 <?php if($bussiness->thumbnail) echo '<img src="'. config_item('media_uri') . $bussiness->thumbnail .'">';?>
                                 <input type="hidden" name="thumbnail" value="<?php echo $bussiness->thumbnail;?>">
                                </div>
                        </div>
                        <div class="form-group">
                            <label>Trạng thái</label>
                            <select name="status" class="form-control">
                                <option value="1" <?php echo ($bussiness->status == 1) ?'selected="selected"': ''; ?>>Hoạt động</option>
                                <option value="2" <?php echo ($bussiness->status == 2) ?'selected="selected"': ''; ?>>Chờ duyệt</option>
                                <option value="3" <?php echo ($bussiness->status == 3) ?'selected="selected"': ''; ?>>Cảnh báo</option>
                                <option value="4" <?php echo ($bussiness->status == 4) ?'selected="selected"': ''; ?>>Bị chặn</option>
                            </select>
                        </div>
                    </div>
                    <hr style="margin:10px 0;padding:0">
                    <div class="box-header">
                        <h3 class="box-title">Liên kết xã hội</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label>Trang Facebook</label>
                            <input type="text" name="facebook_account" value="<?php echo $bussiness->facebook_account; ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Trang Zalo</label>
                            <input type="text" name="zalo_account" value="<?php echo $bussiness->zalo_account; ?>" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Trang Google+</label>
                            <input type="text" name="google_account" value="<?php echo $bussiness->google_account; ?>" class="form-control">
                        </div>
                    </div>
                    <hr style="margin:10px 0;padding:0">
                    <div class="box-header">
                        <h3 class="box-title">Tài khoản thanh toán</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="input-bank_name">Tên ngân hàng</label> <?php echo my_form_error('bank_name');?>
                            <input type="text" class="form-control" name="bank_name" value="<?php echo $bussiness->bank_name; ?>">
                        </div>
                        <div class="form-group">
                            <label for="input-bank_card">Số tài khoản</label> <?php echo my_form_error('bank_card');?>
                            <input type="text" class="form-control" name="bank_card" value="<?php echo $bussiness->bank_card; ?>">
                        </div>
                        <div class="form-group">
                            <label for="input-bank_card_owner">Tên chủ thẻ</label> <?php echo my_form_error('bank_card_owner');?>
                            <input type="text" class="form-control" name="bank_card_owner" value="<?php echo $bussiness->bank_card_owner; ?>">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>