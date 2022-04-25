<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body table-responsive">
                    <table id="datatable" class="table table-bordered" data-controller="<?=$this->router->class;?>">
                        <thead>
                            <tr>
                                <th style="width: 15%"><input name="select_all" value="1" id="example-select-all" type="checkbox" class="simple"/></th>
                                <th>Tên danh mục</th>   
                                <th style="width: 15%">Thao tác</th>                             
                            </tr>
                        </thead>
                        <tbody>
                           
                            <?php if(!empty($category_post)) : foreach($category_post as $cat) : ?>
                            <tr>
                                <td><?= $cat['id'];?></td>
                                <td><?=$cat['name']; ?></td>
                                <td class="text-right" >
                                    <?php echo btn_edit('category_post/edit/'.$cat['id']); ?>
                                    <?php echo btn_delete('category_post/delete/' . $cat['id']); ?>
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