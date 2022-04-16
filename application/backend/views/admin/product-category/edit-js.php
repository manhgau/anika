<script type="text/javascript" src="<?php echo base_url('admin/assets/js/plugins/select/select2.full.js'); ?>"></script>
<script type="text/javascript">
    $(function(){
        $('select.select2-category').select2();
    });
</script>

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
    $("#news-event").tokenInput(adminUrl+"/Apis/token_search_event",{
        theme : "facebook",
        tokenDelimiter: ",",
        preventDuplicates: true,
        <?php if(isset($events)) : ?>
        prePopulate:<?=$events;?>,
        <?php endif; ?>
        
    });
    $("#news-golfer").tokenInput(adminUrl+"/Apis/token_search_golfer",{
        theme : "facebook",
        tokenDelimiter: ",",
        preventDuplicates: true,
        <?php if(isset($golfers)) : ?>
        prePopulate:<?=$golfers;?>,
        <?php endif; ?>
        
    });
    $("#relate-news").tokenInput(adminUrl+"/Apis/token_search_news/tour",{
        theme : "facebook",
        tokenDelimiter: ",",
        preventDuplicates: true,
        <?php if(isset($relate_news)) : ?>
        prePopulate:<?=$relate_news;?>,
        <?php endif; ?>
        
    });
});

$(document).on('click', '.remove-item', function(){
    var a = $(this).parent('li');
    a.remove();
});
</script>