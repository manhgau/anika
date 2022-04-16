<?php 
    $statusFilter = $this->pointrefund_model->getStatus();
?>

<section class="content">

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <form action="/pointload/getRefundGrid" id="filter-form" method="post" style="padding:15px;background:#eaf7ff">
                    <div class="box-header">
                        <div class="row form-group">
                            <div class="col-md-3">
                                <label for="find-keyword">UserID/Email/Phone</label>
                                <input id="find-keyword" class="form-control" name="keyword" value="">
                            </div>
                            <div class="col-md-2">
                                <label>Trạng thái</label>
                                <select class="form-control" name="status">
                                    <option value="">--- Tất cả ---</option>
                                    <?php foreach ($statusFilter as $key => $value): ?>
                                        <option value="<?php echo $key ?>" <?php echo (@$filter['status']==$key) ? 'selected="selected"' : '' ?>><?php echo $value['name'] ?></option>
                                    <?php endforeach ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <?php echo dateRangePicker() ?>
                            </div>
                            <div class="col-xs-12 col-md-1" style="padding-top:23px">
                                <button type="submit" class="btn btn-block btn-primary"> <i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    </form>
                    <hr class="line">
                    <div class="box-body table-responsive" style="padding-bottom:350px">
                        <?php 
                        echo dataTable([
                            'id' => 'Mã GD',
                            'created_time' => 'Thời gian',
                            'news_code' => 'Bài viết',
                            'amount' => 'Số điểm',
                            'member_name' => 'Người gửi',
                            'status_name' => 'Trạng thái',
                            'answer' => 'Trả lời',
                            'answer_by_name' => 'Người trả lời',
                        ], true, true);
                        ?>
                    </div>
            </div>
        </div>
    </div>
</section>
<script>
    const columnValues = [
        {
            targets:1,
            render : function(data, type, full, meta) {
                return `
                ${(data) ? data : ''}<br>
                <label class="btn btn-xs btn-primary" onclick="showMessage('${full.note}')"><i class="fa fa-file-text-o"></i> Lý do</label>
                `;
            }
        },
        {
            targets:2,
            render : function(data, type, full, meta) {
                return `
                ${data} <a href="${full.news_url}" target="_blank" class="btn btn-xs btn-default"><i class="fa fa-link"></i> link</a>
                `;
            }
        },
        {
            targets:6,
            render : function(data, type, full, meta) {
                let m = !!data ? `${data}<br>` : '';
                if (full.status == 'pending') {
                    m +=  `<label class="btn btn-xs btn-primary" onclick="showModal('/pointload/modalRefundProcess/${full.id}')"><i class="fa fa-reply"></i> trả lời</label>`
                };
                return m;
            }
        },
        {
            targets:7,
            render : function(data, type, full, meta) {
                return `${(data) ? data : ''}<br>${(full.answer_time) ? full.answer_time : ''}`;
            }
        }
    ];

    const tableButtons = [
        {
            text: '<i class="fa fa-plus"></i> Nạp điểm',
            className: 'btn btn-sm btn-success',
            action: function ( e, dt, node, config ) {
                showModal('/pointload/modalRecharge');
            }
        }
    ];

</script>