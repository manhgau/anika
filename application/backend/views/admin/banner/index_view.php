<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <a class="btn btn-success btn-sm" href="<?= base_url('banner/edit?type=' . $type); ?>" style="color:#fff;"><i class="fa fa-plus"></i> Add New </a>
                </div><!-- /.box-header -->    
                <div class="box-header" style="margin: 10px 0 0 0;border-top: 1px solid #ccc;padding: 10px 0 0px 0;">
                    <strong style="margin:0 10px">Lọc </strong>&nbsp;
                    <select id="category-filter" name="type" class="form-control filter filter-fields" style="width:200px;display:inline-block">
                        <option value="0"> -- Chọn nhóm Banner -- </option>
                        <?php foreach(config_item('bannerGroup') as $id => $name): ?>
                        <option value="<?=$id;?>" <?php if($type == $id) echo 'selected="selected"';?>> <?=$name;?> </option>
                        <?php endforeach; ?>
                    </select>
                    <select id="category-filter" name="status" class="form-control filter filter-fields" style="width:200px;display:inline-block">
                        <option value="0"> -- Trạng thái -- </option>
                        <option value="1" <?php if($status == 1) echo 'selected="selected"';?>> Đã đăng </option>
                        <option value="2" <?php if($status==2) echo 'selected="selected"';?>> Chờ duyệt </option>
                        <option value="3" <?php if($status == 3) echo 'selected="selected"';?>> Đã xóa </option>
                    </select>
                </div>
                <style type="text/css">#example2 img{max-width:300px!important}</style>
                <div class="box-body table-responsive">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Ảnh</th>
                                <th>Nhóm</th>
                                <th>Tiêu đề</th>
                                <th>Liên kết</th>
                                <th>Vị trí</th>
                                <th>Hiển thị</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if( ! empty($banners)) : $bannerGroup = config_item('bannerGroup'); 
                                foreach($banners as $key => $banner) : ?>
                                <tr>
<<<<<<< Updated upstream
                                    <td style=" text-align: center;"><?= ++$key;?></td>
                                    <td style="max-width:150px ; text-align:center;">                                        
                                        <img src="<?= get_image($banner->image);?>" width="100">
=======
                                    <td><?= ++$key;?></td>
                                    <td style="max-width:350px" class="text-center">
                                                           
                                        <img src="<?= get_image($banner->image);?>" width="100">
                                
>>>>>>> Stashed changes
                                    </td>
                                    <td><a href="<?= base_url("banner/?type={$banner->type}");?>"><?= $bannerGroup[$banner->type];?></a></td>
                                    <td><?= $banner->name; ?></td>
                                    <td><a href="<?= $banner->url; ?>" data-toggle="tooltip" data-placement="top" title="<?= $banner->url; ?>">link</a></td>
                                    <td><?= $banner->position?></td>
                                    <td class="text-center"><i class="fa <?= ($banner->status==1) ? 'fa-check-square-o text-success' : 'fa-square-o text-muted' ?>"></i></td>
                                    <td>
                                    <?= btn_edit('banner/edit/' . $banner->id); ?>&nbsp;
                                    <?= btn_delete('banner/delete/' . $banner->id); ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                            <tr><td colspan="6"><h3>We could not found any banners!!!</h3></td></tr>
                            <?php endif; ?>                            
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>