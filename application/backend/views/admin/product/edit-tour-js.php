<script type="text/javascript" src="<?php echo base_url('admin/assets/js/plugins/jquery-textext/js/textext.core.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('admin/assets/js/plugins/jquery-textext/js/textext.plugin.tags.js'); ?>"></script>
<script type="text/javascript">
    $('#tags').textext({
        plugins : 'tags',
        <?php if(isset($tags)) : ?>
        tagsItems : <?=json_encode($tags);?>,
        <?php endif; ?>
    });
</script>


<script type="text/javascript" src="<?php echo base_url('admin/assets/js/jquery.tokeninput.js'); ?>"></script>
<script type="text/javascript">
$(document).ready(function () {
    $("#token-locations").tokenInput(adminUrl+"/Apis/token_search_location",{
        theme : "facebook",
        tokenDelimiter: ",",
        preventDuplicates: true,
        <?php if(isset($tokenLocations)) : ?>
        prePopulate:<?php echo $tokenLocations;?>,
        <?php endif; ?>
        
    });
    $("#token-bussiness").tokenInput(adminUrl+"/Apis/token_search_bussiness",{
        theme : "facebook",
        tokenDelimiter: ",",
        tokenLimit: 1,
        preventDuplicates: true,
        <?php if(isset($tokenBussiness)) : ?>
        prePopulate:<?=$tokenBussiness;?>,
        <?php endif; ?>
    });
});
$(document).on('click', '.remove-item', function(){
    var a = $(this).parent('li');
    a.remove();
});
</script>