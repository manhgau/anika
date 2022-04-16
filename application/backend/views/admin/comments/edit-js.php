<script type="text/javascript" src="<?php echo base_url('admin/assets/js/jquery.tokeninput.js'); ?>"></script>
<script type="text/javascript">
$(document).ready(function () {
    $("#token-news").tokenInput(adminUrl+"/Apis/token_search_news",{
        theme : "facebook",
        tokenDelimiter: ",",
        preventDuplicates: true,
        <?php if($tokenNews) : ?>
        prePopulate:<?=$tokenNews;?>,
        <?php endif; ?>
    });
});
</script>