<?php echo form_hidden('userId', ($this->me) ? $this->me->fb_id : ''); ?>
<?php if ($this->me): ?>
    <li>
        <a href="#"><i class="fa fa-user" aria-hidden="true"></i><?php echo showUserId($this->me->id); ?></a>
    </li>
    <li>
        <a href="#"><i class="fa fa-star" aria-hidden="true"></i> <span id="point-balance"><?php echo number_format($this->me->point); ?></span> <?php echo lang('point') ?></a>
    </li>
    <li class="dropdown">
        <a class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown" data-animations="fadeInUp" aria-expanded="false">
            <img class="img-circle resize" alt="" src="http://graph.facebook.com/<?php echo $this->me->fb_id; ?>/picture?type=square" />
            <span class="small-padding">
                <span id="status"><?php echo $this->me->fullname ?></span>
                <i class="fa fa-caret-down"></i>
            </span>
        </a>
        <ul class="dropdown-menu dropdownhover-bottom">
            <li class="hidden">
                <a href="#"><i class="icon-gears"></i> Tài khoản</a>
            </li>
            <li>
                <a href="#" onclick="logout()"><i class="icon-lock"></i> Đăng xuất</a>
            </li>
        </ul>
    </li>
<?php else: ?>
    <?php if (ENVIRONMENT!='production'): ?>
        <li><a href="#" onclick="loginFb('EAAN2oZCfYZBR8BANyGvRUZCo24OuKlLLM39g2diqdfKoALgNcO69ayenZBZBja7n0jsObAejF0KigsCLSdRNpcqjdxCr5e9dOCyMn1hVuYZChiBldmem9QfS24unxx6FnvGwIPsPaRSruUcZBzOp4frCdIm5VOKMifPZCQGEqRcgGbyHivXqKSvqj0vkyRDZAnA7ZCGZCDuz33BlucZCzB7vJaLa')"><i class="fa fa-lock" aria-hidden="true"></i> Đăng nhập</a></li>
    <?php else: ?>
        <li><a href="#" onclick="fbLoginForm()"><i class="fa fa-lock" aria-hidden="true"></i> Đăng nhập</a></li>
    <?php endif ?>
    
    <li><a href="#" onclick="fbLoginForm()"><i class="fa fa-user-plus" aria-hidden="true"></i> Đăng ký</a>
    </li>
<?php endif ?>

