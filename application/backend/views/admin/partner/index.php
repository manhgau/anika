<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-body table-responsive">
                <table id="datatable" class="table table-bordered" data-controller="<?=$this->router->class;?>">
                        <thead>
                            <tr>
                                <th><input name="select_all" value="1" id="example-select-all" type="checkbox" class="simple" /></th>
                                <th>Logo</th>
                                <th>Tên</th>
                                <th>Hot</th>
                                <th>Trạng thái</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($partner)) : foreach($partner as $key => $part) : ?>
                            <tr>
                                <td><?= $part['id'];?></td>
                                <td style="max-width:150px">
                                    <img src="<?php echo getImageUrl($part['image']);?>" alt="Logo" style="max-width:100px;height:60px">
                                </td>
                                <td style="max-width:350px">
                                    <?php echo $part['name']; ?>
                                </td>
                                <td class="text-center"> 
                                    <?php echo ($part['is_hot'] == 1) ? '<i class="fa fa-star orange"></i>' : ''; ?>
                                </td>

                                <td class="text-center">
                                    <i class="fa <?= ($part['status'] == 1) ? 'fa-check-square-o text-success' : 'fa-square-o text-muted' ?>">
                                </td>
                               
                                <td class="text-right text-center" >
                                    <?php echo btn_edit('partner/edit/'.$part['id']); ?>
                                    <?php echo btn_delete('partner/delete/'.$part['id']); ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <tr><td colspan="5"><h3>We could not found any relationships!!!</h3></td></tr>
                            </tr>
                            <?php endif; ?>                            
                        </tbody>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div>
</section>
