<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <h3>Quản lý gian hàng của: <?php echo $event->title; ?></h3>
                    
                </div><!-- /.box-header -->
                <div class="box-body table-responsive">
                    <div class="box box-primary">
                        <h2><a href="<?php echo base_url('admin/position/man_pos_event/' . $event->id);?>">Sơ đồ mặt sàn triển lãm</a></h2>
                        <div>
                            <style>
                                .show-land{width:auto;margin:0 auto}
                                .show-land td {padding:3px 7px;border: 1px solid #999;text-align:center;}
                                .show-land td.is-lane{border:none;background:#fff;text-indent:-999999px}
                                .show-land td.booked{border:1px solid #FFF;background:#D9534F;}
                                .show-land td.waitting{border:1px solid #FFF;background:#05A8F0;color:#fff}
                                .show-land .head-line{background:#ddd;font-weight:700;color:#666}
                            </style>
                            <table class="show-land">
                                <tr class="head-line">
                                    <td></td>
                                    <?php for($i=1; $i<=$event->width; $i++) : ?>
                                    <td><?php echo $array_char[$i]; ?></td>
                                    <?php endfor; ?>
                                </tr>
                                <?php for($i=1; $i<=$event->height; $i++) : ?>
                                    <tr>
                                        <td class="head-line"><?php echo $i; ?></td>
                                        <?php 
                                        for($j=1; $j<=$event->width; $j++) : 
                                            $pos_model = $array_char[$j] . $i;
                                            $_this_pos = $list_position[$pos_model];
                                        ?>
                                        <td <?php if($_this_pos->status == 0) echo 'class="is-lane"'; elseif($_this_pos->booked == 1) echo 'class="booked"'; else echo 'class="waitting"'; ?> >
                                            <a title="<?php echo number_format($_this_pos->price) . ' VND';?>" href="<?php echo base_url('admin/position/edit/' . $_this_pos->id); ?>" style="color:#FFF;display:block;width:100%;height:100%"><?php echo $pos_model; ?></a>
                                        </td>
                                        <?php endfor; ?>
                                    </tr>
                                <?php endfor; ?>
                            </table>
                        </div>
                        <div>
                            <h3>Bảng giá mặt sàn</h3>
                            <form action="" method="post">
                                <table id="example2" class="table table-bordered table-hover">
                                    <tr>
                                        <th>Loại</th>
                                        <th>Khung giá</th>
                                        <th>Vị trí gian hàng</th>
                                    </tr>
                                    <tbody>
                                        <?php $i=0; if(count($position_price)) : foreach($position_price as $key => $item) :?>
                                        <tr>
                                            <td>Loại <?php echo ++$i; ?></td>
                                            <td><input type="text" name="prices[]" value="<?php echo number_format($key); ?>" class="form-control prices" /></td>
                                            <td><input type="text" name="position[]" value="<?php echo $item; ?>" class="form-control position" /></td>
                                        </tr>
                                        <?php endforeach; else: ?>
                                        <tr>
                                            <td>Loại 1</td>
                                            <td><input type="text" name="prices[]" value="" class="form-control prices" /></td>
                                            <td><input type="text" name="position[]" value="" class="form-control position" /></td>
                                        </tr>
                                        <tr>
                                            <td>Loại 2</td>
                                            <td><input type="text" name="prices[]" value="" class="form-control prices" /></td>
                                            <td><input type="text" name="position[]" value="" class="form-control position" /></td>
                                        </tr>
                                        <tr>
                                            <td>Loại 3</td>
                                            <td><input type="text" name="prices[]" value="" class="form-control prices" /></td>
                                            <td><input type="text" name="position[]" value="" class="form-control position" /></td>
                                        </tr>
                                        <tr>
                                            <td>Loại 4</td>
                                            <td><input type="text" name="prices[]" value="" class="form-control prices" /></td>
                                            <td><input type="text" name="position[]" value="" class="form-control position" /></td>
                                        </tr>
                                        <tr>
                                            <td>Loại 5</td>
                                            <td><input type="text" name="prices[]" value="" class="form-control prices" /></td>
                                            <td><input type="text" name="position[]" value="" class="form-control position" /></td>
                                        </tr>
                                        
                                        <tr>
                                            <td colspan="3">
                                                <input type="hidden" name="id" value="<?php echo $event->id;?>" />
                                                <input type="submit" class="btn btn-primary" value="Save" />
                                            </td>
                                        </tr>                                        
                                        <?php endif; ?>
                                    </tbody>                                    
                                </table>
                            </form>
                        </div>
                </div>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>