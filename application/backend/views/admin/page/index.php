<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <a class="btn btn-success btn-sm" href="<?php echo base_url('page/edit'); ?>" style="color:#fff;"><i class="fa fa-plus"></i> Thêm mới</a>
                </div>
                <div class="box-body table-responsive">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Tiêu đề</th>
                                <th>Slugname</th>
                                <th>Parent</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($pages)) : foreach($pages as $page) : ?>
                            <tr>
                                <td><p><?php echo $page->title; ?></p>
                                    <p>
                                        <?=btn_edit('page/edit/' . $page->id);?>
                                        <?=btn_view(build_link_to_detail_page($page->slug,$page->id));?>
                                        <?=btn_delete('page/delete/' . $page->id);?>
                                    </p>
                                </td>
                                <td><?php echo $page->slug; ?></td>
                                <td><?php echo $page->parent_title; ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <tr><td colspan="5"><h3>We could not found any pages!!!</h3></td></tr>
                            </tr>
                            <?php endif; ?>                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>