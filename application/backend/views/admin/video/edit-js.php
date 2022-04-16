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

<script type="text/javascript">
//Auto get thumbnail from Youtube
var autoThumbnail = true;
$(document).ready(function(){
    $(document).on('change','input#input-fileUrl',function(){
        if(autoThumbnail===true) {
            var youtube_id = $(this).val();
            var thumb = 'https://i3.ytimg.com/vi/'+youtube_id+'/hqdefault.jpg';
            $('#imagePreview').css({'background-image':'url("'+thumb+'")'});
        }
    });
    $(document).on('change','input#input-fileUrl',function(){
        
        
    });
});

</script>