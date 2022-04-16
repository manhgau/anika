<div class="navbar navbar-default">
            <div class="container">
                <!-- header -->
                <div class="navbar-header">
                    <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- logo -->
                    <a href="/" class="navbar-brand">
                        <?php $logo = siteOption('logo'); ?>
                        <img class="img-responsive" alt="" src="<?php echo getImageUrl($logo) ?>" style="max-height: 50px;" />
                    </a>
                    <!-- header end -->
                </div>
                <!-- navigation menu -->
                <div class="navbar-collapse collapse">
                    <!-- right bar -->
                    <ul class="nav navbar-nav navbar-right">
                        <li class=""><a href="javascript:;"><?php 
                        $replacer = ($this->me) ? showUserId($this->me->id) : 'ID-******';
                        echo str_replace('{{user_id}}', $replacer, siteOption('banking_content', 'Chuyển khoản theo cú pháp "ID 1245" đến STK: 123456789, Ngân hàng Vietcombank; để nạp điểm')) ?></a></li>
                    </ul>
                </div>
                <!-- navigation menu end -->
                <!--/.navbar-collapse -->
            </div>
        </div>