<section class="content">
    <div class="row">
        <?php $this->load->view('admin/newspaper/inc/edit-form'); ?>

        <div class="col-md-8">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title">Danh sách bài viết</h3>
                </div>
                <div class="box-body">
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <a href="/newspaper/index" class="btn btn-sm btn-success" style="color:#fff"><i class="fa fa-plus"></i> Add new</a>
                        </li>
                    </ul>
                    <table id="datatable" class="table table-bordered table-striped dataTable" data-controller="<?=$this->router->class;?>">
                        <thead>
                            <tr>
                                <th style="width: 60px;">Image</th>
                                <th style="width: 40%;">Title</th>
                                <th>Link</th>
                                <th>Trang</th>
                                <th>Hiển thị</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($listNews)) : foreach($listNews as $key => $link) : ?>
                                <tr>
                                    <td><img src="<?= getImageUrl($link->image); ?>" style="width:80px"></td>
                                    <td>
                                        <?php echo $link->title; ?><br>
                                        <?php echo btn_edit('newspaper/index/'.$link->id), ' ', btn_delete('newspaper/delete/'.$link->id); ?>
                                    </td>
                                    <td><a href="<?= $link->newsUrl ?>">link</a></td>
                                    <td><?php echo $this->newspaper_model->getPageShow( $link->on_page ) ?></td>
                                    <td><i class="<?php echo ($link->isHot) ? 'fa fa-star yellow' : '';?>"></i></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php endif; ?>                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>