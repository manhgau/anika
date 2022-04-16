<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-default">
                <form method="get">
                <div class="clearfix">
                    <div class="col-xs-3">
                        <label>Tháng</label>
                        <select class="form-control" name="m">
                            <?php for($m=1; $m<=12; $m++) : ?>
                            <option value="<?php echo $m;?>" <?php if($m == $filterParams['month']) echo 'selected="selected"';?>><?php echo $m; ?></option>
                            <?php endfor;?>
                        </select>
                    </div>
                    <div class="col-xs-3">
                        <label>Năm</label>
                        <select class="form-control" name="y">
                            <?php for($m=2015; $m<=2050; $m++) : ?>
                            <option value="<?php echo $m;?>" <?php if($m == $filterParams['year']) echo 'selected="selected"';?>><?php echo $m; ?></option>
                            <?php endfor;?>
                        </select>
                    </div>
                    <div class="col-xs-3">
                        <label style="width:100%">&nbsp;</label>
                        <button type="submit" class="btn btn-info btn-sm"> <i class="fa fa-search"></i> Xem báo cáo</button>
                    </div>
                    <div class="col-xs-3"></div>
                </div>
                </form>

                <hr class="line">
                <div class="box-header">
                    <h4 class="box-title">Tổng kết nhuận bút tháng <?php echo $filterParams['month'], '/', $filterParams['year'];?></h4>
                </div><!-- /.box-header -->

                <div class="box-body">
                    <?php if( isset($authorConfirmNotYet) && $authorConfirmNotYet ) : ?>
                        <div class="box box-solid bg-red">
                            <div class="box-header">
                                <h3 class="box-title">Chưa hoàn thành chấm nhuận trong tháng</h3>
                            </div>
                            <div class="box-body">
                                <p>Phải hoàn thành chấm nhuận cho từng phóng viên đã viết bài trong tháng để xem được báo cáo này.</p>
                            </div><!-- /.box-body -->
                        </div>
                        <h3 class="page-title">Danh sách tác giả chưa được chấm nhuận</h3>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($authorConfirmNotYet as $key => $val) : ?>
                                    <tr>
                                        <td><?php echo ++$key; ?></td>
                                        <td><?php echo $val->name; ?></td>
                                        <td>
                                            <?php $args = array(
                                                'month' => $filterParams['month'],
                                                'year' => $filterParams['year'],
                                                'create_by' => $val->id
                                            );?>
                                            <a href="<?php echo base_url('salary/salaryMonth'), '/?', http_build_query($args);?>" class="btn btn-xs btn-default" title="Chấm nhuận"><i class="fa fa-arrow-right orange"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                        
                    <?php else:?>
                        <div class="clearfix" style="margin-bottom:10px">
                            <a href="<?php echo base_url('salary/reportSalaryByMonth?action=export'); ?>" target="_blank" class="btn btn-sm btn-info pull-right"> <i class="fa fa-download"></i> Tải báo xáo </a>
                        </div>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>STT</th>
                                    <th>Tên</th>
                                    <th>Số bài viết</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $sumMoney = 0;
                                foreach($reportSalary as $key => $val) : $sumMoney += $val->sum_money;?>
                                    <tr>
                                        <td><?php echo ++$key; ?></td>
                                        <td><?php echo $val->name; ?></td>
                                        <td><?php echo number_format($val->news_number); ?></td>
                                        <td><?php echo number_format($val->sum_money); ?></td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" style="text-align:right"><strong>Tổng</strong></td>
                                    <td><?php echo number_format($sumMoney); ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    <?php endif?>
                </div>
                
            </div><!-- /.box -->
        </div>
    </div>
</section>