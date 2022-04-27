<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body table-responsive">
                    <table id="datatable" class="table table-bordered" data-controller="<?=$this->router->class;?>">
                        <thead>
                            <tr>
                                <th><input name="select_all" value="1" id="example-select-all" type="checkbox"  /></th>
                                <th>Tên</th>    
                                <th>Link</th>
                                <th>Trạng thái</th>
                                <th>Ảnh</th>
                                <th>Thao tác</th>                             
                            </tr>
                        </thead>
                        <tbody>
                           
                            <?php if(!empty($category_product)) : foreach($category_product as $cat) : ?>
                            <tr>
                                <td><?=$cat['id'];?></td>
                                <td><?=$cat['title']; ?></td>
                                <td><?php echo link_preview_category_product($cat['id'], $cat['slugname']); ?></td>
                                <td class="text-center"><i class="fa <?= ($cat['status'] == 1) ? 'fa-check-square-o text-success' : 'fa-square-o text-muted' ?>"></td>
                                <td><img src="<?php echo getImageUrl($cat['image']);?>" width="15" height="20" /></td>
                                <td class="text-right">
                                    <?php echo btn_edit('category_product/edit/'.$cat['id']); ?>
                                    <?php echo btn_delete('category_product/delete/' . $cat['id']); ?>
                                        
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