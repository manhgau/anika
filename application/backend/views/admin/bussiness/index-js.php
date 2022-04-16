<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?=base_url('admin/assets/js/datatables/bussiness.js');?>" defer></script>

<script type="text/javascript" src="<?php echo base_url('admin/assets/js/jquery.tokeninput.js'); ?>"></script>
<script type="text/javascript">
$(document).ready(function () {
    $("#token-input-parent").tokenInput(adminUrl+"/Apis/token_search_location",{
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