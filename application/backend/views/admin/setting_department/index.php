<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body table-responsive">
                    <table id="datatable" class="table table-bordered" data-controller="<?=$this->router->class;?>">
                        <thead>
                        <tr>
                            <th><input name="select_all" value="1" id="example-select-all" type="checkbox"  /></th>
                            <th>Tên phòng ban</th>
                            <th style="width: 15%">Thao tác</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php if(!empty($department)) : foreach($department as $cat) : ?>
                            <tr>
                                <td><?= $cat['id'];?></td>
                                <td><?=$cat['name']; ?></td>
                                <td class="text-right" >
                                    <?php echo btn_edit('setting_department/edit/'.$cat['id']); ?>
                                    <?php echo btn_delete('setting_department/delete/' . $cat['id']); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="5"><h3>Chưa có phòng ban nào!!!</h3></td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
