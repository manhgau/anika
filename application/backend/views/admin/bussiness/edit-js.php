<script type="text/javascript" src="<?php echo base_url('admin/assets/js/jquery.tokeninput.js'); ?>"></script>
<script type="text/javascript">
$(document).ready(function () {
    $("#token-input-location").tokenInput(adminUrl+"/Apis/token_search_location",{
        theme : "facebook",
        tokenDelimiter: ",",
        tokenLimit: 1,
        preventDuplicates: true,
        <?php if(isset($tokenLocation)) : ?>
        prePopulate:<?php echo $tokenLocation;?>,
        <?php endif; ?>
    });
});
</script>