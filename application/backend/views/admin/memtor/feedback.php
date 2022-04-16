<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header pad" >
                    <strong style="margin:0 10px">Lọc </strong>&nbsp;
                    <form action="" id="filter-form">
                        <div class="row">
                        <div class="col-xs-6 col-lg-2 col-md-3">
                            <label>Trạng thái</label>
                            <?php echo form_dropdown('status', $this->memtor_model->feedbackStatusFilter(), '', 'class="form-control"'); ?>
                        </div>
                        <div class="col-xs-6 col-lg-2 col-md-2">
                            <label>Mentor</label>
                            <?php 
                            $options = ['' => '--- tất cả ---'] + array_combine( array_column($mentors, 'id'), array_column($mentors, 'name') );
                            echo form_dropdown('mentor_id', $options, '', 'class="form-control"');
                            ?>
                        </div>
                        <div class="col-xs-6 col-lg-2 col-md-2">
                            <label>Portfolio</label>
                            <?php 
                            $options = ['' => '--- tất cả ---'] +  array_combine( array_column($portfolios, 'id'), array_column($portfolios, 'name') );
                            echo form_dropdown('portfolio_id', $options, '', 'class="form-control"');
                            ?>
                        </div>
                        <div class="col-xs-6 col-lg-1 col-md-1" style="padding-top:25px">
                            <button class="btn btn-info btn-block"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                    </form>
                </div>
                <hr class="line">
                <div class="box-body table-responsive">
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <a href="/memtor/feedbackEdit" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Add new</a>
                        </li>
                    </ul>
                    <div id="list-data"></div>
                </div>
            </div>
        </div>
    </div>
</section>