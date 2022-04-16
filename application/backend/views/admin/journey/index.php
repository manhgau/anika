<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-heading">
                    <div class="row">
                        <div class="col-xs-12">
                            <ul class="nav nav-pills">
                                <li><a href="<?php echo base_url('journey/edit'); ?>" class="btn btn-xs btn-default"> <i class="fa fa-plus green"></i> Thêm mới</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="box-body table-responsive">
                    <?php if ($journey): ?>
                    <table id="datatable" class="table table-bordered table-striped dataTable" data-controller="<?=$this->router->class;?>">
                        <thead>
                            <tr>
                                <th>Thứ tự</th>
                                <th>Title</th>
                                <th>Note</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($journey as $key => $val) : ?>
                                <tr>
                                    <td><?php echo $val->position;?></td>
                                    <td><?php echo $val->name;?></td>
                                    <td><?php echo $val->note;?></td>
                                    <td>
                                        <?php 
                                        echo btn_edit('journey/edit/'.$val->id);
                                        echo btn_delete('journey/delete/'.$val->id);
                                        ?>
                                        <!-- <a href="<?php echo base_url('journey/editMilestone'); ?>" class="btn btn-sm btn-default"> <i class="fa fa-plus green"></i> Addmore milestone</a> -->
                                    </td>
                                </tr>
                            <?php endforeach; ?>                         
                        </tbody>
                    </table>
                    <?php else: ?>
                        <div class="alert alert-warning"><p>We could not found any journey!!!</p></div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</section>