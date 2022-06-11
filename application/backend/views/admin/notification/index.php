<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <form action="" method="get" style="padding:15px;background:#eaf7ff">
                    <div class="box-header">
                        <div class="row form-group">
                            <div class="col-xs-3">
                                <label for="find-keyword">Từ khóa</label>
                                <input id="find-keyword" class="form-control" name="keyword" value="<?php echo $filters['keyword']; ?>" placeholder="Nhập tiêu đề thông báo">
                            </div>
                            <div class="col-xs-3">
                                <label>Tác giả</label>
                                <input id="autoComplete" class="form-control" name="authorName" value="<?php echo $filters['authorName']; ?>">
                            </div>
                            <div class="col-xs-3">
                                <label>Thông báo</label>
                                <select id="category-filter" name="type" class="form-control filter filter-fields" style="width:200px;display:inline-block">
                                    <option value="0"> -- Chọn thông báo -- </option>
                                    <?php foreach(config_item('notification_type') as $id => $name): ?>
                                        <option value="<?=$id;?>" <?php if($type == $id) echo 'selected="selected"';?>> <?=$name;?> </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <hr class="line" style="margin:0 0 10px;border-color:#e4e4e4">
                        <div class="row">
                            <div class="col-xs-12">
                                <button type="submit" class="btn btn-sm btn-primary"> <i class="fa fa-search"></i> Tìm kiếm</button>
                                <a class="btn btn-sm btn-default" href="<?php echo base_url('notification');?>"> <i class="fa fa-refresh"></i> Reset</a>
                            </div>
                        </div>
                    </div>
                </form>
                <hr class="line">
                <div class="box-body table-responsive">
                    <table id="datatable" class="table table-bordered table-striped dataTable" data-controller="<?=$this->router->class;?>">
                        <thead>
                        <tr>
                            <th><input type="checkbox" class="simple" id="check-all" name="select_all"></th>
                            <th>Tiêu đề</th>
                            <th>Nội dung</th>
                            <th>Thông báo</th>
                            <th>Dành cho</th>
                            <th>Liên kết</th>
                            <th>Trạng thái</th>
                            <th>Action</th>
                            <th>Tác giả</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(!empty($notifications)) : foreach($notifications as $key => $notification) : ?>
                            <tr id="row-<?php echo $notification->id; ?>">
                                <td><?php echo $notification->id; ?></td>
                                <td>
                                    <p><a href="<?php echo base_url('notification/edit/'.$notification->id);?>"><?php echo $notification->title; ?></a></p>
                                </td>
                                <td>
                                    <p><?php echo get_excerpt($notification->content, 400); ?></p>
                                </td>
                                <td>
                                    <p><?php
                                        $notification_type = config_item('notification_type');
                                        echo $notification_type[$notification->type]; ?>
                                    </p>
                                </td>
                                <td>
                                    <p><?php
                                        $notification_sender = config_item('notification_sender');
                                        echo $notification_sender[$notification->sender_type]; ?>
                                    </p>
                                </td>
                                <td>
                                    <a href="<?= $notification->url; ?>" data-toggle="tooltip" data-placement="top" title="<?= $notification->url; ?>">Link</a>
                                </td>
<!--                                <td>--><?php //echo date('H:i:s d/m/Y',strtotime($notification->created_time));?><!--</td>-->

                                <td class="text-center"><i class="fa <?= ($notification->status == 1) ? 'fa-check-square-o text-success' : 'fa-square-o text-muted' ?>"></td>
                                <td>
                                    <p>
                                        <?php
                                        echo btn_edit('notification/edit/'.$notification->id);
                                        $_view_url = config_item('main_domain') .$notification->slugname . '-a'.$notification->id.'.html';
                                        echo btn_delete('notification/delete/'.$notification->id);
                                        echo btn_send('notification/pushNotify/'.$notification->id);
                                        ?>
                                    </p>
                                </td>
                                <td><?php echo $authors[$notification->created_by]->name;?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                            <tr><td colspan="5"><h3>We could not found any articles!!!</h3></td></tr>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>