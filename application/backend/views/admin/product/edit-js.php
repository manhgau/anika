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
    $("#token-province").tokenInput(adminUrl+"/Apis/token_search_location",{
        theme : "facebook",
        tokenDelimiter: ",",
        preventDuplicates: true,
        <?php if(isset($tokenProvinces)) : ?>
        prePopulate:<?php echo $tokenProvinces;?>,
        <?php endif; ?>
        
    });
    $("#token-country").tokenInput(adminUrl+"/Apis/token_search_location",{
        theme : "facebook",
        tokenDelimiter: ",",
        preventDuplicates: true,
        <?php if(isset($tokenCountries)) : ?>
        prePopulate:<?php echo $tokenCountries;?>,
        <?php endif; ?>
        
    });
    $("#token-location").tokenInput(adminUrl+"/Apis/token_search_location",{
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
<script type="text/javascript">
    var setMaps = $('input[name="map_view"]');
    var viewMaps = $('#maps-preview');
    $(function() {
        setMaps.on('change', function() {
            var u = $(this).val();
            if (u != '') 
            {
                viewMaps.find('iframe').attr('src', u).removeClass('hidden');
            }
        });
    });
</script>
<script type="text/javascript" src="<?php echo base_url('admin/assets/js/form/edit-product.js'); ?>" defer></script>