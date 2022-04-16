<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-warning">
                <div class="box-header">
                    <h4 class="box-title">Tổng số bài viết trong hệ thống</h4>
                </div>
                <div class="box-body row">
                    <div class="col-xs-2">
                        <div class="small-box bg-green">
                            <div class="inner">
                                <h4><?php echo (isset($allNewsReport[STATUS_PUBLISHED]) && $allNewsReport[STATUS_PUBLISHED]) ? number_format( $allNewsReport[STATUS_PUBLISHED]) : 0;?></h4>
                                <p>Đã xuất bản</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-2">
                        <div class="small-box bg-orange">
                            <div class="inner">
                                <h4><?php echo (isset($allNewsReport[STATUS_PENDING]) && $allNewsReport[STATUS_PENDING]) ? number_format( $allNewsReport[STATUS_PENDING] ) : 0;?></h4>
                                <p>Chờ duyệt</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-2">
                        <div class="small-box bg-blue">
                            <div class="inner">
                                <h4><?php echo (isset($allNewsReport[STATUS_WRITING]) && $allNewsReport[STATUS_WRITING]) ? number_format( $allNewsReport[STATUS_WRITING] ) : 0;?></h4>
                                <p>Đang viết</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-2">
                        <div class="small-box bg-red">
                            <div class="inner">
                                <h4><?php $status=STATUS_COMEBACK; echo (isset($allNewsReport[$status]) && $allNewsReport[$status]) ? number_format( $allNewsReport[$status] ) : 0;?></h4>
                                <p>Trả lại</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-2">
                        <div class="small-box bg-black">
                            <div class="inner">
                                <h4><?php echo (isset($allNewsReport[STATUS_DELETED]) && $allNewsReport[STATUS_DELETED]) ? number_format( $allNewsReport[STATUS_DELETED] ) : 0;?></h4>
                                <p>Đã xóa</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-2">
                        <div class="small-box bg-navy">
                            <div class="inner">
                                <h3><?php echo '= ', number_format( intval($allNewsReport[STATUS_PUBLISHED]) + intval($allNewsReport[STATUS_PENDING]) + intval($allNewsReport[STATUS_DELETED]) + intval($allNewsReport[STATUS_WRITING]) + intval($allNewsReport[STATUS_COMEBACK]) );?></h3>
                                <p>Tổng số</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="line">
            <div class="box">
                <div class="box-body table-responsive">
                    <div class="box-header">
                        <h4 class="box-title" style="display:block;width:100%"><?php echo $meta_title_1; ?></h4>
                        <form action="<?php echo base_url('news/reportNewsByAuthor');?>">
                        <div class="form-group row">
                            <div class="col-xs-3">
                                <label for="date-time">Thời gian viết</label>
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" name="createTimeFilter" class="form-control" id="time-range" value="<?php echo implode(' - ', $timeFilter);?>"/>
                                </div>
                            </div>
                            <div class="col-xs-3"></div>
                            <div class="col-xs-3"></div>
                            <div class="col-xs-3"></div>
                        </div>
                        <div class="row form-group">
                            <div class="col-xs-12">
                                <button class="btn btn-sm btn-info"><i class="fa fa-search"></i> Lọc kết quả</button>
                            </div>
                        </div>
                        </form>
                    </div>
                    <table id="datatable" class="table table-bordered table-striped dataTable" data-controller="<?=$this->router->class;?>">
                        <thead>
                            <tr>
                                <th>STT</th>
                                <th>Phóng viên</th>
                                <th>Đã duyệt</th>
                                <th>Chờ duyệt</th>
                                <th>Đang viết</th>
                                <th>Trả lại</th>
                                <th>Xóa</th>
                                <th>Tổng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $stt=1; if(!empty($authors)) : foreach($authors as $key => $author) : 
                                    if(isset($reports[$author->id]))
                                    {
                                        $_report = $reports[$author->id];
                                    }

                                    else{
                                        $_report = array();
                                    }
                                ?>
                                <tr>
                                    <td><?php echo $stt++; ?></td>
                                    <td><?php echo $author->name; ?></td>
                                    <td><a href="<?php echo link_to_my_news($author->id,1);?>"><?php echo (isset($_report['approved'])) ? number_format($_report['approved']) : 0; ?></a></td>
                                    <td><a href="<?php echo link_to_my_news($author->id,2);?>"><?php echo (isset($_report['pending'])) ? number_format($_report['pending']) : 0; ?></a></td>
                                    <td><a href="<?php echo link_to_my_news($author->id,4);?>"><?php echo (isset($_report['writting'])) ? number_format($_report['writting']) : 0; ?></a></td>
                                    <td><a href="<?php echo link_to_my_news($author->id,5);?>"><?php echo (isset($_report['return'])) ? number_format($_report['return']) : 0; ?></a></td>
                                    <td><a href="<?php echo link_to_my_news($author->id,3);?>"><?php echo (isset($_report['trash'])) ? number_format($_report['trash']) : 0; ?></a></td>
                                    <td><a href="<?php echo link_to_my_news($author->id);?>"><?php echo number_format(array_sum($_report)); ?></a></td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                <tr>
                                <tr><td colspan="5"><h3>We could not found any articles!!!</h3></td></tr>
                                </tr>
                                <?php endif; ?>                            
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</section>