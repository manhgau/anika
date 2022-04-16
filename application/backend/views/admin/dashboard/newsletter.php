<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header pad" >
                    <form action="" id="filter-form">
                        <div class="row">
                        <div class="col-xs-6 col-lg-4 col-md-6">
                            <?php echo dateRangePicker(); ?>
                        </div>
                        <div class="col-xs-6 col-lg-1 col-md-1" style="padding-top:25px">
                            <button class="btn btn-info btn-block"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                    </form>
                </div>
                <hr class="line">
                <div class="box-body table-responsive">
                    <div id="list-data"></div>
                </div>
            </div>
        </div>
    </div>
</section>