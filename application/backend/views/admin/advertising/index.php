<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <a class="btn btn-success btn-sm" href="<?php echo base_url('advertising/edit'); ?>"
                       style="color:#fff;"><i class="fa fa-plus"></i> Add New </a>
                </div><!-- /.box-header -->
                <div class="box-header row"
                     style="margin: 10px 0 0 0;border-top: 1px solid #ccc;padding: 10px 0 0px 0;">
                    <div class="col-xs-3">
                        <select id="category-filter" name="group_id" class="form-control filter filter-fields">
                            <option value="0"> -- Chọn nhóm --</option>
                            <?php foreach ($adsGroups as $id => $group): ?>
                                <option value="<?php echo $group->id; ?>" <?php if($group_id == $group->id) echo 'selected="selected"';?>> <?php echo $group->name; ?> </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-xs-3">
                        <select id="category-filter" name="status" class="form-control filter filter-fields">
                            <option value="0"> -- Trạng thái --</option>
                            <option value="1" <?php if ($status == 1) echo 'selected="selected"'; ?>> Đã đăng</option>
                            <option value="2" <?php if ($status == 2) echo 'selected="selected"'; ?>> Chờ duyệt</option>
                            <option value="3" <?php if ($status == 3) echo 'selected="selected"'; ?>> Đã xóa</option>
                        </select>
                    </div>

                </div>

                <div class="box-body table-responsive">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>STT</th>
                            <th>Ảnh</th>
                            <th>Tiêu đề</th>
                            <th>Nhóm</th>
                            <th>Liên kết</th>
                            <th>Vị trí</th>
                            <th>HOT</th>
                            <th>Hiển thị</th>
                            <th>Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (!empty($advertisings)) :
                            foreach ($advertisings as $key => $val) :
                                $_group = $adsGroups[$val->group_id];
                                ?>
                                <tr>
                                    <td><?php echo ++$key; ?></td>
                                    <td>
                                        <img src="<?php echo get_image($val->image); ?>" width="60">
                                    </td>
                                    <td><?php echo $val->title; ?></td>
                                    <td>
                                        <a href="<?php echo base_url("advertising/?group_id={$val->group_id}"); ?>"><?php echo $_group->name; ?></a>
                                    </td>
                                    <td><a href="<?php echo $val->url; ?>" class="btn btn-xs btn-info" target="_blank">Xem link</a></td>
                                    <td class="txt-center"><?php echo $val->position; ?></td>
                                    <td class="txt-center"><i class="fa <?php echo ($val->is_hot) ? 'fa-star yellow' : 'hidden'; ?>"></i></td>
                                    <td class="txt-center"><i class="fa <?php echo ($val->status) ? 'fa-check green' : 'fa-times orange'; ?>"></i></td>
                                    <td>
                                        <?php echo btn_edit('advertising/edit/' . $val->id); ?>&nbsp;
                                        <?php echo btn_delete('advertising/delete/' . $val->id); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6"><h3>We could not found any advertisings!!!</h3></td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>