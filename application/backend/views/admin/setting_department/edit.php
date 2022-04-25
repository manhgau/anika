<section class="content">
    <div class="row">
        <form action="" method="post" role="form" enctype="multipart/form-data">
            <div class="col-md-6 col-xs-12 col-md-offset-3">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="input-title">Tên phòng ban</label> <?php echo my_form_error('name'); ?>
                            <input type="text" name="name" value="<?= set_value('title', html_entity_decode($department->name)) ?>" class="form-control" id="input-title">
                        </div>
                    </div>
                    <div class="box-footer">
                        <?php echo form_submit('submit', 'Save', 'class="btn btn-primary"'); ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>