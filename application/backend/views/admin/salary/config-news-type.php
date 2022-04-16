<section class="content">
    <div class="row">
        <div class="col-xs-6">
            <div class="box box-default">
                <div class="box-header">
                    <div class="box-title">
                    <a class="btn btn-success btn-sm" href="<?php echo base_url('salary/newsTypeConfig'); ?>" style="color:#fff;"><i class="fa fa-plus"></i> Thêm mới </a>
                    </div>
                </div><!-- /.box-header -->
                <form action="" method="post">
                <div class="box-body">
                    <div class="form-group">
                        <label for="input-name">Tên</label>
                        <input type="text" name="name" id="input-name" value="<?php echo $newsType->name; ?>" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="input-description">Mô tả</label>
                        <textarea name="description" id="input-description" cols="30" rows="4" class="form-control"><?php echo $newsType->description; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="input-fixed_money">Nhuận bút cố định</label>
                        <div class="input-group input-group-md">
                            <input type="number" min="0" step="100" max="999999999" name="fixed_money" value="<?php echo $newsType->fixed_money; ?>" id="input-fixed_money" class="form-control">
                          <span class="input-group-addon" id="sizing-addon1">VND</span>
                        </div>
                    </div>
                    <hr class="line">
                    <h4 class="box-title" for="input-description">Định mức nhuận bút (Cộng thêm)</h4>
                    <div class="form-group">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Lượt xem</th>
                                    <th colspan="2">Nhuận bút</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $viewQuota = config_item('pageview_quota'); 
                                $_thisViewMoney = $newsType->view_money;
                                if ($_thisViewMoney)
                                {
                                    $explodeViewMoney = explode(',', $_thisViewMoney);
                                }

                                foreach( $viewQuota as $key => $val) : ?>
                                    <?php $_thisMoney = (isset($explodeViewMoney) && $explodeViewMoney) ? explode(':', $explodeViewMoney[$key]) : null; ?>
                                <tr>
                                    <td>
                                        <strong><?php echo number_format($val);?></strong>
                                        -
                                        <strong><?php echo (isset($viewQuota[$key+1])) ? number_format(--$viewQuota[$key+1] ) : '~';?></strong>
                                    </td>
                                    <td>
                                        <input type="number" name="min[<?php echo $key; ?>]" class="form-control" placeholder="từ VND" value="<?php echo $_thisMoney[0]; ?>">
                                    </td>
                                    <td>
                                        <input type="number" name="max[<?php echo $key; ?>]" class="form-control" placeholder="đến VND" value="<?php echo $_thisMoney[1]; ?>">
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                </div>
                <div class="box-footer">
                    <button class="btn btn-info btn-sm" type="submit"> <i class="fa fa-floppy-o"></i> Lưu</button>
                </div>
                </form>
                
            </div><!-- /.box -->
        </div>
        <div class="col-xs-6">
            <div class="box box-primary">
                <div class="box-header">
                    <h4 class="box-title">Danh sách phân loại bài viết</h4>
                </div>
                <div class="box-body">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Tên</th>
                                <th>Mô tả</th>
                                <th style="min-width:80px">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($allType) : foreach($allType as $key => $val) : ?>
                                <tr>
                                    <td><?php echo ++$key; ?></td>
                                    <td><a href="<?php echo base_url('salary/newsTypeConfig/' . $val->id);?>"><?php echo $val->name; ?></a></td>
                                    <td><small><?php echo $val->description; ?></small></td>
                                    <td style="min-width:80px">
                                        <?php echo btn_edit('salary/newsTypeConfig/' . $val->id);?>
                                        <?php echo btn_delete('salary/deleteNewsType/' . $val->id);?>
                                    </td>
                                </tr>
                            <?php endforeach; endif;?>
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div>
        </div>
    </div>
</section>