<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <?php if(isset($error_msg) && $error_msg && $inputParams['month'] && $inputParams['year']) : ?>
                <div class="box box-solid bg-orange" style="margin-bottom:10px">
                    <div class="box-header">
                        <h3 class="box-title">Thông báo!</h3>
                    </div>
                    <div class="box-body">
                        <p><?php echo $error_msg; ?></p>
                    </div><!-- /.box-body -->
                </div>
            <?php endif;?>

            <div class="box box-default">
                <div class="box-header">
                    <h4 class="box-title">Tính nhuận bút tháng <?php echo $filterConds['month'], '/', $filterConds['year'];?></h4>
                </div><!-- /.box-header -->

                <div class="box-body" style="border-bottom:1px solid #ccc;margin-bottom:10px">
                    <form action="" method="get" id="form-create-report">
                        <div class="form-group row">
                            <div class="col-xs-3">
                                <label>Tác giả</label>
                                <select class="form-control" name="create_by">
                                    <option>--- Chọn tác giả ---</option>
                                    <?php $selectedIndex = 0; ?>
                                    <?php foreach($authors as $key => $val) : ?>
                                    <?php if($val->id == $filterConds['create_by']) {
                                        $selectedIndex = $key;
                                    } ?>
                                    <option value="<?php echo $val->id; ?>" <?php echo ($val->id == $filterConds['create_by']) ? 'selected="selected"' : ''; ?> ><?php echo $val->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-xs-3">
                                <label>Tháng</label>
                                <select class="form-control" name="month">
                                    <option>--- Chọn tháng ---</option>
                                    <?php for($i=1; $i<=12; $i++) : ?>
                                    <option value="<?php echo $i; ?>" <?php echo ($i == $filterConds['month']) ? 'selected="selected"' : ''; ?> ><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="col-xs-3">
                                <label>Năm</label>
                                <select class="form-control" name="year">
                                    <option>--- Chọn năm ---</option>
                                    <?php for($i=2050; $i>=2017; $i--) : ?>
                                    <option value="<?php echo $i; ?>" <?php echo ($i == $filterConds['year']) ? 'selected="selected"' : ''; ?> ><?php echo $i; ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>
                            <div class="col-xs-3">
                                <label style="color:transparent;width:100%">&nbsp;</label>
                                <button class="btn btn-sm btn-info"><i class="fa fa-search"></i> Tạo báo cáo</button>
                            </div>

                        </div>
                    </form>
                </div>
                
                <style type="text/css">.small-box h3{font-size:24px;font-weight:600;}</style>
                <div class="panel panel-default">
                  <div class="panel-heading">
                      <h4>Thống kê bài viết tháng <strong><?php echo $filterConds['month'], '/', $filterConds['year']; ?></strong>
                      </h4>
                  </div>
                  <div class="panel-body">
                    <div class="form-group">
                        - Tác giả: <strong><?php echo $author->name; ?></strong><br>
                        - Ngày xuất bản: <strong><?php echo date('d/m/Y', strtotime($params['start_date'])), ' - ', date('d/m/Y', strtotime($params['end_date'])); ?></strong><br>
                        - Tổng số bài viết: <strong><?php echo number_format($reportMonth->tu_viet + $reportMonth->tong_hop); ?></strong><br>
                        - Tổng view: <strong><?php echo number_format($reportMonth->sum_view); ?></strong><br>
                    </div>

                    <div class="form-group clearfix">
                        <?php $fitlerView = $filterConds; 
                        unset($fitlerView['is_writer']);
                        unset($fitlerView['min_view']);
                        unset($fitlerView['max_view']);
                        ?>
                        <div class="col-xs-2">
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3><span id="report-news-number"><?php echo number_format($reportMonth->gt_number); ?></span></h3>
                                </div>
                                <a href="<?php echo '?',  http_build_query($fitlerView), '&min_view=',  min( config_item('pageview_quota') ); ?>" class="small-box-footer">Đủ View <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="small-box bg-purple">
                                <div class="inner">
                                    <h3><span id="report-news-number"><?php echo number_format($reportMonth->lt_number); ?></span></h3>
                                </div>
                                <a href="<?php echo '?',  http_build_query($fitlerView), '&max_view=',  min( config_item('pageview_quota') ); ?>" class="small-box-footer">Không đủ view <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <?php $bySourceConds = $filterConds;
                            unset($bySourceConds['min_view']);
                            unset($bySourceConds['max_view']);
                            unset($bySourceConds['is_writer']);
                        ?>
                        <div class="col-xs-2">
                            <div class="small-box bg-aqua">
                                <div class="inner">
                                    <h3><span id="report-news-number"><?php echo number_format($reportMonth->tu_viet); ?></span></h3>
                                </div>
                                <a href="<?php echo '?',  http_build_query($bySourceConds), '&is_writer=true'; ?>" class="small-box-footer">Tự viết <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="small-box bg-purple">
                                <div class="inner">
                                    <h3><span id="report-news-number"><?php echo number_format($reportMonth->tong_hop); ?></span></h3>
                                </div>
                                <a href="<?php echo '?',  http_build_query($bySourceConds), '&is_writer=false'; ?>" class="small-box-footer">Tổng hợp <i class="fa fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                        <div class="col-xs-2 hidden">
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h3> <span id="report-view-number"><?php echo number_format($reportMonth->sum_view); ?></span> </h3>
                                </div>
                                <a href="#" class="small-box-footer">Lượt xem</a>
                            </div>
                        </div>
                        <div class="col-xs-2">
                            <div class="small-box bg-yellow">
                                <div class="inner">
                                    <h3><span id="report-money-number"><?php echo number_format(count($listNews)); ?></span></h3>
                                </div>
                                <a href="#" class="small-box-footer">Thu nhập dự tính (VND)</a>
                            </div>
                        </div>
                        <div class="col-xs-2 txt-center">
                        </div>
                    </div>
                </div>
                <div class="panel-footer">Chỉ tính nhuận cho bài viết có tối thiểu <strong><?php echo min( config_item('pageview_quota') ); ?></strong> lượt xem!</div>
                </div>
                
                <style type="text/css">
                    .article-meta * {color:#898989;font-size: 12px;}
                    .article-meta {margin:5px 0;}
                </style>
                <h4 class="page-title" style="font-weight:600;padding-left:15px"><?php echo $listTitle; ?></h4>
                <div class="box-body">
                    <table class="table table-bordered" id="table-report">
                        <thead>
                            <tr>
                                <td colspan="7">
                                    <a href="#" class="btn btn-success btn-sm" id="auto-check-salary" data-author="<?php echo $author->id; ?>" data-month="<?php echo $filterConds['month']; ?>" data-year="<?php echo $filterConds['year']; ?>"><i class="fa fa-check"></i> Chấm tự động</a>
                        <span id="auto-check-reponse"></span>
                                </td>
                            </tr>
                            <tr>
                                <th>STT</th>
                                <th style="max-width:350px">Tiêu đề</th>
                                <th>Lượt xem</th>
                                <th>Phân loại</th>
                                <th>Thành tiền</th>
                                <th>Chấp nhận<br>thanh toán</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                                $totalView = 0;
                                $totalMoney = 0; 
                            ?>
                            <?php if(isset($listNews) && $listNews) : foreach($listNews as $key => $val) : ?>
                                <tr id="<?php echo $val->id; ?>" data-id="<?php echo $val->id; ?>" data-mode="<?php echo ($val->ns_id && $val->ns_status != STATUS_SALARY_WAITING) ? 'view-mode' : 'edit-mode';?>">
                                    <td><?php echo ++$key; ?></td>
                                    <td style="max-width:350px">
                                        <a href="javascript:;"><?php echo $val->title;?></a>
                                        <p class="article-meta">
                                            <a href="javascript:;" style="cursor:pointer;" title="Thời gian xuất bản"><i class="fa fa-clock-o"></i> <?php echo date('H:i d/m/Y', $val->public_time);?></a>
                                             | 
                                            <a href="<?php echo ($val->source_url) ? $val->source_url : 'javascript:;';?>" target="_blank" style="cursor:pointer;" title="Nguồn gốc bài viết"><?php echo ($val->source_url) ? 'Tổng hợp' : 'Tự viết';?></a>
                                        </p>
                                    </td>
                                    <td><?php echo number_format($val->hit_view); $totalView += $val->hit_view; ?></td>
                                    <td>
                                        <span class="view-mode news_type"></span>
                                        <select name="news_type" class="form-control edit-mode" style="max-width:250px">
                                            <option value=""></option>
                                            <?php foreach($newsTypes as $type) : ?>
                                            <option value="<?php echo $type->id; ?>" <?php echo ($type->id == $val->type_id) ? 'selected="selected"' : ''; ?> ><?php echo $type->name; ?></option>
                                            <?php endforeach;?>
                                        </select>
                                    </td>
                                    <td> 
                                        <span class="view-mode money"></span>
                                        <input type="number" name="money" class="form-control edit-mode" value="<?php echo intval($val->money); ?>" style="width:100px">
                                        <p style="color:#999;margin:0" class="edit-mode">(<small id="money-step">---</small>) vnd</p>
                                        <?php $totalMoney += $val->money; ?>
                                    </td>
                                    <td>
                                        <span class="view-mode allow_payment"></span>
                                        <input type="checkbox" class="simple edit-mode" name="allow_payment" value="<?php echo STATUS_SALARY_PAID;?>" <?php if($val->ns_status == STATUS_SALARY_PAID) echo 'checked="checked"';?>>
                                    </td>
                                    <td>
                                        <a href="javascript:;" class="btn btn-default btn-xs view-mode btn-change-mode" title="Sửa"> <i class="fa fa-pencil green"></i> </a>
                                        <a href="#" class="btn btn-default btn-xs edit-mode btn-cancel" title="Hủy"> <i class="fa fa-times"></i> </a>
                                        <a href="javascript:;" class="btn-default btn btn-xs save-salary-btn edit-mode" data-id="<?php echo $val->id; ?>" title="Lưu"><i class="fa-floppy-o fa blue"></i></a>
                                        <a href="javascript:;" class="btn-default btn btn-xs" data-id="<?php echo $val->id; ?>" title="Ghi chú" data-href="<?php echo base_url('salary/newsNote/' . $val->id);?>" data-toggle="modal" data-target="#app-modal"><i class="fa-pencil-square-o fa orange"></i></a>
                                        
                                        <a href="<?php echo 'https://thuonghieucongluan.com.vn/', $val->slugname, "-a{$val->id}.html";?>" target="_blank" class="btn-default btn btn-xs" data-id="<?php echo $val->id; ?>" title="Xem bài viết"><i class="fa-eye fa black"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?> 
                                <tr class="strong">
                                    <td colspan="3" class="txt-center"><strong>Tổng:</strong></td>
                                    <td id="table-view"><?php echo number_format($totalView); ?></td>
                                    <td></td>
                                    <td colspan="3" id="table-money"><?php echo number_format($totalMoney); ?></td>
                                </tr>
                            <?php else: ?>
                            <tr> 
                                <td colspan="8">
                                    <div class="alert alert-warning"><P>Chưa có bài viết nào!</P></div>
                                </td> 
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <div class="dataTables_paginate paging_simple_numbers" id="datatable_paginate">
                        <a href="<?php echo base_url('salary/export?' . http_build_query($filterConds));?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-download"></i> Xuất file Excel</a>
                        <?php if($paging['current'] > 1) : ?>
                            <a class="paginate_button previous" aria-controls="datatable" data-dt-idx="0" tabindex="0" id="datatable_previous" href="<?php echo base_url("salary/salaryMonth/?"), http_build_query($filterConds), '&page=', $paging['next'] ; ?>">Previous</a>
                            <a class="paginate_button previous" id="datatable_previous" href="<?php echo base_url("salary/salaryMonth/?"), http_build_query($filterConds), '&page=', $paging['prev'] ; ?>"><?php echo $paging['prev']?></a>
                            <?php endif; ?>
                        <a class="paginate_button current" href="javascript:;"><?php echo $paging['current']; ?></a>
                        <?php if(count($listNews) >= $paging['limit']) : ?>
                            <a class="paginate_button next" href="<?php echo base_url("salary/salaryMonth/?"), http_build_query($filterConds), '&page=', $paging['next'] ; ?>"><?php echo $paging['next']; ?></a>
                            <a class="paginate_button next" href="<?php echo base_url("salary/salaryMonth/?"), http_build_query($filterConds), '&page=', $paging['next'] ; ?>">Next</a>
                            <?php endif; ?>
                    </div>
                </div>

                <div class="box-footer">
                    <?php
                    $maxIndexAuthors = count($authors)-1;
                    $nextQuery = $prevQuery = array();
                    if($selectedIndex < $maxIndexAuthors) {
                        $nextIndex = $selectedIndex +1; 
                        $nextAuthor = $authors[ $nextIndex ]; 
                        $nextQuery = array(
                            // 'min_view' => min( config_item('pageview_quota') ),
                            'create_by' => $nextAuthor->id,
                            'month' => $filterConds['month'],
                            'year' => $filterConds['year']
                        );
                    }
                    if ($selectedIndex > 0) {
                        $prevIndex = $selectedIndex - 1; 
                        $prevAuthor = $authors[ $prevIndex ]; 
                        $prevQuery = array(
                            // 'min_view' => min( config_item('pageview_quota') ),
                            'create_by' => $prevAuthor->id,
                            'month' => $filterConds['month'],
                            'year' => $filterConds['year']
                        );
                    }
                        
                    ?>
                    <nav aria-label="...">
                      <ul class="pager">
                        <li class="<?php if(!$prevQuery) echo 'disabled'; ?>"><a href="<?php echo '?', http_build_query($prevQuery); ?>" >Người trước</a></li>
                        <li class="disabled "><a href="#" class="active"><?php echo $selectedIndex,'/', count($authors), ' phóng viên'; ?></a></li>
                        <li class="<?php if(!$nextQuery) echo 'disabled'; ?>"><a href="<?php echo '?', http_build_query($nextQuery); ?>">Người sau</a></li>
                      </ul>
                    </nav>
                </div>
                
            </div><!-- /.box -->
        </div>
    </div>
</section>