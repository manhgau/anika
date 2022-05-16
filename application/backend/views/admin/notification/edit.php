<section class="content">
    <div class="row">
        <form action="" method="post" role="multipart/form-data">
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Chọn loại thông báo</label>
                            <?php echo form_dropdown('type',$notification_type,(isset($notification->type)) ? $notification->type : 'thong_bao_he_thong','class="form-control"'); ?>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Chọn nhóm đối tượng</label><?php echo my_form_error('sender_type');?>
                            <?php echo form_dropdown('sender_type',$notification_sender,(isset($notification->sender_type)) ? $notification->sender_type : '','class="form-control"'); ?>
                        </div>
                        <div id="selectBox" style="overflow: hidden; height: 5px">
                        <div id="selectTeam" style="overflow: hidden; height: 2px">
                            <div class="form-group teams">
                                <label for="exampleInputEmail1">Chọn nhóm team</label>
                                <select name="team" id="input-status" class="form-control">
                                    <option value="" <?php if($notification->sender_type!=='team') echo 'selected="selected"'; ?>>Chọn</option>
                                    <option value="department" <?php if($notification->deparment_id!=0) echo 'selected="selected"';?>>Nhóm phòng ban</option>
                                    <option value="province" <?php if($notification->province_id!=0) echo 'selected="selected"';?>>Nhóm tỉnh thành</option>
                                    <option value="device" <?php if($notification->device_type!='') echo 'selected="selected"';?>>Nhóm thiết bị</option>
                                </select>
                            </div>
                        <div class="form-group departments">
                            <?php
                            $allType = $this->setting_department_model->getList();

                            $options = ['' => 'Chọn phòng ban'] + array_combine(array_column($allType, 'id'), array_column($allType, 'name'));
                            echo form_element([
                                'name' => 'department_id',
                                'value' => $notification->department_id,
                                'label' => 'Danh mục phòng ban',
                                'type' => 'select',
                                'options' => $options,
                            ]);
                            ?>
                        </div>
                        <div class="form-group provinces">
                            <div class="col-xs-6">
                                <?php
                                echo form_element([
                                    'type' => 'select',
                                    'name' => 'province_id',
                                    'value' => $notification->province_id,
                                    'label' => 'Tỉnh/thành',
                                    'options' => toArray($this->location_model->provinceSelectOption()),
                                ]);
                                ?>
                            </div>
                            <div class="col-xs-6">
                                <?php
                                echo form_element([
                                    'type' => 'select',
                                    'name' => 'district_id',
                                    'value' => $notification->district_id,
                                    'label' => 'Huyện/quận',
                                    'options' => toArray($this->location_model->districtSelectOption($notification->province_id)),
                                ]);
                                ?>
                            </div>
                        </div>
                            <div class="form-group services">
                                <label for="exampleInputEmail1">Chọn nhóm thiết bị</label>
                                <?php echo form_dropdown('device_type',$notification_device,(isset($notification->device_type)) ? $notification->device_type : '','class="form-control"'); ?>
                            </div>
                        </div>
                        <div class="form-group members" id="members" style="overflow: hidden; height: 2px" >
                            <label class="text-primary">ID khách hàng</label>
                            <?php
                            $prepopulate = [];
                            if ($notification->sender_id) {
                                $member = $this->member_model->get($notification->sender_id, true);
                                $prepopulate[] = [
                                    'id' => $member->id,
                                    'name' => $member->fullname
                                ];
                            }
                            echo tokeninput('sender_id', '/member/tokenSearch', 1, $prepopulate, 'token-member_id');
                            ?>
                        </div>
                        </div>
                        <div class="form-group">
                            <label for="uploadFile">Ảnh đại diện</label>
                            <?php echo form_element([
                                'type' => 'fileupload',
                                'name' => 'image',
                                'value' => $notification->image,
                                'button_label' => 'Chọn ảnh'
                            ]) ?>

                        </div>
                        <div class="form-group">
                            <label for="input-title">Tiêu đề thông báo</label> <?php echo my_form_error('title');?>
                            <input type="text" name="title" value="<?= set_value('title', html_entity_decode($notification->title)) ?>" class="form-control" id="input-title">
                        </div>
<!--                        <div class="form-group">-->
<!--                            <label for="input-desc">Nội dung thông báo</label>-->
<!--                            <textarea name="content" id="input-desc" rows="3" class="form-control">--><?php //echo $notification->content;?><!--</textarea>-->
<!--                        </div>-->
                        <div class="form-group" id="list-image">
                            <label for="tinymce" style="width:100%;"> Nội dung bài viết </label> <?php echo my_form_error('content');?>
                            <div class="row">
                                <div class="col-xs-6">
                                    <p>
                                        <button id="upload" type="button" name="bt_image"><span>Tải ảnh</span></button>
                                    </p>
                                    <p><span id="status"></span><span id="status-copyright"></span></p>
                                </div>
                            </div>
                            <div class="row">
                                <style type="text/css">#display-file img{width:60px!important;height:40px!important}</style>
                                <div id="display-file">
                                    <ul>
                                        <?php if(isset($product_images)) :
                                            $_img_order = explode('#',$product_detail->list_image);
                                            ?>
                                            <?php
                                            foreach ($_img_order as $_order) :
                                                foreach($product_images as $key => $img) : if($img->id == $_order) : ?>
                                                    <li>
                                                        <img src="<?=$img->url;?>" alt="" height="40" style="height:40px;width:auto;margin:1px 0;border:1px solid #eee">
                                                        <input type="hidden" name="listImage[]" value="<?=$img->id;?>">
                                                        <a class="insert_img_content" data="<?=$img->url;?>">Insert</a>
                                                    </li>
                                                <?php endif; endforeach; endforeach; ?>
                                        <?php endif; ?>
                                        <li class="clear hidden"></li>
                                    </ul>
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <textarea name="content" class="form-control" id="tinymce" rows=""><?php echo $notification->content; ?></textarea>
                            </div>
                        <div class="form-group">
                            <label for="url">Liên kết:&nbsp;</label>
                            <input type="text" class="form-control" id="url" name="url" placeholder="Menu URL: " value="<?php echo $notification->url;?>">
                        </div>
                        <div class="form-group">
                            <label for="input-status">Trạng thái</label> <?php echo my_form_error('status');?>
                            <select name="status" id="input-status" class="form-control" <?php if($userdata['level'] > 1) echo 'readonly="readonly"';?>>
                                <option value="0" <?php if($notification->status==0) echo 'selected="selected"';?>>Khóa</option>
                                <option value="1" <?php if($notification->status==1) echo 'selected="selected"';?>>Công khai</option>
                            </select>

                        </div>

                        <hr class="line" style="clear: both;" />
                    </div>
                    <div class="box-footer">
                        <?php echo form_submit('submit','Save','class="btn btn-primary"');?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>