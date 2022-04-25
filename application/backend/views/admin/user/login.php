<div class="form-box" id="login-box" style="box-shadow: 0px 2px 2px #000;-webkit-box-shadow: 0px 2px 2px #000;">
    <div class="header" style="background:#fff">
    <img src="<?php echo getImageUrl(siteOption('logo')); ?>" style="height: 40px;"></div>
    <?php if ($allowLogin): ?>
    <form method="post" action="<?=base_url('user/login');?>">
        <div class="body bg-gray">
            <div class="form-group">
                <?php echo form_input('email','','class="form-control" placeholder="email?" required="required"'); ?>
            </div>
            <div class="form-group">
                <?php echo form_password('password','','class="form-control" placeholder="password?" required="required"'); ?>
            </div>
            <div class="form-group" id="gg-captcha"></div>
        </div>
        <div class="footer">                                                               
            <?php echo form_submit('submit','Sign me in','class="btn bg-blue btn-block"');?>
            <?php displayAlert(); ?>
        </div>
    </form>
    <?php else :  ?>
        <div class="body bg-gray">
            <?php displayAlert(); ?>
        </div>
    <?php endif ?>
</div>