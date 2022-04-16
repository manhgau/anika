<section class="content">
    <div class="row">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="col-md-8 col-md-offset-2">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title"><?php echo lang('post_infomation') ?></h3>
                    </div>
                    <div class="box-body">
                        <?php if (!$post->id): ?>
                           <div class="form-group">
                            <label class="required">Người gửi yêu cầu</label>
                            <?php 
                            $prepopulate = [];
                            if ($post->member_id) {
                                $member = $this->member_model->get($post->member_id, true);
                                $prepopulate[] = [
                                    'id' => $member->id,
                                    'name' => $member->fullname
                                ];
                            }
                            echo tokeninput('member_id', '/member/tokenSearch', 1, $prepopulate, 'token-member_id');
                            ?>
                        </div>
                        <?php endif ?>
                        <div class="form-group">
                            <?php echo form_element([
                                'label' => 'Tiêu đề',
                                'name' => 'title',
                                'value' => $post->title,
                                'required' => true,
                            ]) ?>
                        </div>
                        <div class="form-group">
                            <?php echo form_element([
                                'label' => 'Link',
                                'type' => 'url',
                                'name' => 'url',
                                'value' => $post->url,
                                'required' => true,
                            ]) ?>
                        </div>
                        <div class="form-group">
                            <?php echo form_element([
                                'label' => 'Điểm',
                                'name' => 'point',
                                'value' => $post->point,
                                'type' => 'number',
                                'class' => 'form-control',
                                'required' => true,
                            ]) ?>
                        </div>
                        <?php if (!$post->id): ?>
                        <div class="form-group">
                            <?php echo form_element([
                                'label' => 'Trạng thái',
                                'name' => 'status',
                                'value' => $post->status,
                                'type' => 'select',
                                'options' => $this->postrequest_model->getStatusFilter(),
                                'required' => true,
                            ]) ?>
                        </div>
                        <?php endif ?>
                    </div>
                    <div class="box-footer">
                        <?php 
                            echo form_hidden('id', $post->id);
                            echo form_submit('publish','Cập nhật','class="btn btn-success"');
                        ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>