<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body table-responsive">
                    <table id="datatable" class="table table-bordered" data-controller="<?=$this->router->class;?>">
                        <thead>
                            <tr>
                                <th style="width: 15%"><input name="select_all" value="1" id="example-select-all" type="checkbox" class="simple"/></th>
                                <th>Tên</th>    
                                <th>Ảnh</th> 
                                <th>Trạng thái</th>
                                <th style="width: 15%">Thao tác</th>                             
                            </tr>
                        </thead>
                        <tbody>
                           
                            <?php if(!empty($business_setting)) : foreach($business_setting as $cat) : ?>
                            <tr>
                                <td><?= $cat['id'];?></td>
                                <td><?=$cat['name']; ?></td>
                                <td class="text-center"><img src="<?php echo getImageUrl($cat['image']);?>" width="15" height="20" /></td>
                                <td class="text-center"><i class="fa <?= ($cat['status'] == 1) ? 'fa-check-square-o text-success' : 'fa-square-o text-muted' ?>"></i></td>
                                <td class="text-right text-center" >
                                    <?php echo btn_edit('business_setting/edit/'.$cat['id']); ?>
                                    <?php echo btn_delete('business_setting/delete/' . $cat['id']); ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr><td colspan="5"><h3>Chưa có chuyên mục nào!!!</h3></td></tr>
                            <?php endif; ?>                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>