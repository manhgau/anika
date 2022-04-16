<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?=base_url('admin/assets/js/datatables/location.js');?>" defer></script>

<script type="text/javascript" src="<?php echo base_url('admin/assets/js/jquery.tokeninput.js'); ?>"></script>
<script type="text/javascript">
$(document).ready(function () {
    $("#token-input-location").tokenInput(adminUrl+"/Apis/token_search_location",{
        theme : "facebook",
        tokenDelimiter: ",",
        tokenLimit: 1,
        preventDuplicates: true,
        <?php if(isset($tokenParent)) : ?>
        prePopulate:<?php echo $tokenParent;?>,
        <?php endif; ?>
    });
    $("#token-input-location-group").tokenInput(adminUrl+"/Apis/token_search_location_group",{
        theme : "facebook",
        tokenDelimiter: ",",
        tokenLimit: 1,
        preventDuplicates: true,
        <?php if(isset($tokenGroup)) : ?>
        prePopulate:<?php echo $tokenGroup;?>,
        <?php endif; ?>
    });
});
</script>