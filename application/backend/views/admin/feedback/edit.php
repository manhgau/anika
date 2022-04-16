<section class="content">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="row form-group">
            <div class="col-xs-12 col-md-9">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="form-group">
                            <label>Tên đơn vị <span class="red">*</span></label>
                            <input type="text" name="fullname" class="form-control" required="required" value="<?= set_value('fullname', $member->fullname) ?>">
                        </div>
                        <div class="form-group">
                            <label>Tên viết tắt <span class="red">*</span></label>
                            <input type="text" name="short_name" class="form-control" required="required" value="<?= set_value('short_name', $member->short_name) ?>">
                        </div>
                        <div class="row">
                            <div class="form-group col-xs-12 col-md-6">
                                <label>Số điện thoại <span class="red">*</span></label>
                                <input type="number" name="phone" class="form-control" required="required" value="<?= set_value('phone', $member->phone) ?>" pattern="/^-?\d+\.?\d*$/" onKeyPress="if(this.value.length==10) return false;">
                            </div>
                            <div class="form-group col-xs-12 col-md-6">
                                <label>Email <span class="red">*</span></label>
                                <input type="email" name="email" class="form-control" required="required" value="<?= set_value('email', $member->email) ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Địa chỉ <span class="red">*</span></label>
                            <input type="text" name="address" class="form-control" required="required" value="<?= set_value('address', $member->address) ?>">
                        </div>
                        
                        <?php 
                            $args = [
                                'listProvince' => $listProvince,
                                'province_id' => $member->province_id,
                                'district_id' => $member->district_id,
                                'ward_id' => $member->ward_id
                            ];
                            $this->load->view('admin/inc/location-selector', $args); 
                        ?>

                        <div class="form-group">
                            <label>Họ tên người đứng đầu <span class="red">*</span></label>
                            <input type="text" class="form-control" name="leader_name" value="<?= set_value('leader_name', $member->leader_name) ?>">
                        </div>
                        <div class="form-group">
                            <label>Giới thiệu ngắn</label>
                            <textarea class="form-control" name="description" rows="4" maxlength="250"><?= set_value('description', $member->description) ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-3">
                <div class="box box-info">
                    <div class="box-header">
                        <h4 class="box-title">Cài đặt</h4>
                    </div>
                    <div class="box-body">
                        <ul class="list-unstyled">
                            <li>
                                <label><input type="checkbox" name="status" value="public" class="simple" <?= ($member->status=='public') ? 'checked="checked"' : '' ?>> Công khai</label>
                            </li>
                            <li>
                                <label><input type="checkbox" name="is_hot" value="1" class="simple" <?= ($member->is_hot==1) ? 'checked="checked"' : '' ?>> Hiển thị trang chủ</label>
                            </li>
                        </ul>
                        <div class="form-group">
                            <label>Thứ tự hiển thị</label>
                            <input type="number" class="form-control" min="1" name="order" value="<?= set_value('order', $member->order) ?>">
                        </div>
                        <div class="">
                            <?php 
                                $args = [
                                    'box_title' => 'Logo',
                                    'max_width' => '600',
                                    'max_height' => '400',
                                    'field_name' => 'thumbnail',
                                    'field_value' => $member->logo
                                ];
                                $this->load->view('admin/components/inc-single-upload', $args); 
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="">
            <button class="btn btn-danger btn-sm"><i class="fa fa-floppy-o"></i> Lưu</button>
        </div>
    </form>
</section>