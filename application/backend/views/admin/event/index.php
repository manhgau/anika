<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header" style="margin: 10px 0 0 0;padding: 10px 0 0px 0;">
                    <strong style="margin:0 10px">Lọc </strong>&nbsp;
                    <select id="status-filter" class="form-control filter" style="width:200px;display:inline-block">
                        <option value="0" <?php if($filters['status']==0) echo 'selected="selected"'; ?>> -- Trạng thái -- </option>
                        <option value="1" <?php if($filters['status']==1) echo 'selected="selected"'; ?>> Đã duyệt </option>
                        <option value="2" <?php if($filters['status']==2) echo 'selected="selected"'; ?>> Chờ duyệt </option>
                        <option value="3" <?php if($filters['status']==3) echo 'selected="selected"'; ?>> Đã xóa </option>
                    </select>
                </div>
                <hr class="line">
                <div class="box-body table-responsive">
                    <table id="datatable" class="table table-bordered" data-controller="<?=$this->router->class;?>">
                        <thead>
                            <tr>
                                <th><input type="checkbox" id="check-all" name="select_all"></th>
                                <th>Tên</th>
                                <th>Địa điểm</th>
                                <th>Bắt đầu</th>
                                <th>Trạng thái</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($events)) : foreach($events as $key => $event) : ?>
                                <tr>
                                    <td><?=$event->id; ?></td>
                                    <td>
                                        <p><a href="<?=base_url('event/edit/'.$event->id);?>"><?php echo $event->title; ?></a></p>
                                    </td>
                                    <td> <?=$event->location;?> </td>
                                    <td><?=date('H:i:s d/m/Y',$event->begin_time);?></td>
                                    <td><?=$event->status;?></td>
                                    <td>
                                        <p>
                                            <?php
                                            echo btn_edit('event/edit/'.$event->id);
                                            echo btn_view(config_item('domain').$event->slugname . '-a'.$event->id.'.html');
                                            echo btn_delete('event/delete/'.$event->id);
                                            ?>
                                        </p> 
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                <tr><td colspan="5"><h3>We could not found any events!!!</h3></td></tr>
                                </tr>
                                <?php endif; ?>                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>