<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header pad" >
                    <strong style="margin:0 10px">Lọc </strong>&nbsp;
                    <div class="row">
                        <div class="col-xs-6 col-lg-2 col-md-3">
                            <label>Trạng thái</label>
                            <select class="form-control filter" name="status">
                                <option value="" <?php if($filters['status']==0) echo 'selected="selected"'; ?>> -- Trạng thái -- </option>
                                <option value="1" <?php if($filters['status']==1) echo 'selected="selected"'; ?>> Đã duyệt </option>
                                <option value="2" <?php if($filters['status']==2) echo 'selected="selected"'; ?>> Chờ duyệt </option>
                                <option value="3" <?php if($filters['status']==3) echo 'selected="selected"'; ?>> Đã xóa </option>
                            </select>
                        </div>
                        <div class="col-xs-6 col-lg-2 col-md-3">
                            <label>Nhóm</label>
                            <select class="form-control filter" name="group">
                                <option value="" <?php if($filters['status']==0) echo 'selected="selected"'; ?>> -- Trạng thái -- </option>
                                <?php foreach (config_item('mentor_group') as $gName): ?>
                                <option value="<?php echo $gName ?>" <?php if($filters['group']==$gName) echo 'selected="selected"'; ?>> <?php echo ucfirst($gName); ?> </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <hr class="line">
                <div class="box-body table-responsive" id="list-data">
                    <table id="datatable" class="table table-bordered" data-controller="<?=$this->router->class;?>">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="check-all" name="select_all"></th>
                                <th>Ảnh</th>
                                <th>Tên</th>
                                <th>Group</th>
                                <th>Chức vụ</th>
                                <th>Giới tính</th>
                                <th>Thứ tự hiển thị</th>
                                <th>Trạng thái</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($memtors)) : foreach($memtors as $key => $memtor) : ?>
                                <tr>
                                    <td><?=$memtor->id; ?></td>
                                    <td><img src="<?php echo config_item('media_uri') . $memtor->image; ?>" alt="" width="60"></td>
                                    <td><?php echo $memtor->name; ?></td>
                                    <td><?php echo ucfirst($memtor->group); ?></td>
                                    <td><?php echo $memtor->job_title; ?></td>
                                    <td> <?php echo ($memtor->gender==0) ? 'Nữ' : 'Nam';?> </td>
                                    <td><?php echo $memtor->position;?></td>
                                    <td><?=$memtor->status;?></td>
                                    <td>
                                        <p>
                                            <?php
                                            echo btn_edit('memtor/edit/'.$memtor->id);
                                            echo btn_delete('memtor/delete/' . $memtor->id);
                                            ?>
                                        </p>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                <tr><td colspan="5"><h3>We could not found any memtors!!!</h3></td></tr>
                                </tr>
                                <?php endif; ?>                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>