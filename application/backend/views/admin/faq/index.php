<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <a class="btn btn-success btn-sm" href="<?php echo base_url('faq/edit'); ?>" style="color:#fff;"><i class="fa fa-plus"></i> Thêm mới</a>
                </div>
                <div class="box-body table-responsive">
                    <table id="example2" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Thứ tự</th>
                                <th>Câu hỏi</th>
                                <th>Trả lời</th>
                                <th>Trạng thái</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($faqs)) : foreach($faqs as $faq) : ?>
                            <tr>
                                <td><?php echo $faq->order ?></td>
                                <td style="width:25%"><p><?php echo $faq->question; ?></p>
                                    <p>
                                        <?=btn_edit('faq/edit/' . $faq->id);?>
                                        <?=btn_delete('faq/delete/' . $faq->id);?>
                                    </p>
                                </td>
                                <td style="width:50%"><?php echo $faq->answer; ?></td>
                                <td class="text-center"><?php echo lang($faq->status); ?></td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <tr><td colspan="5"><h3>We could not found any faqs!!!</h3></td></tr>
                            </tr>
                            <?php endif; ?>                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>