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

<!-- <script type="text/javascript" src="<?=base_url('admin/assets/js/me/thcl-upload.jquery.js');?>"></script> -->

<script type="text/javascript" src="<?php echo base_url('admin/assets/js/jquery.tokeninput.js'); ?>"></script>
<script type="text/javascript">
$(document).ready(function () {
    $("#relate-news").tokenInput("/Apis/token_search_news", {
        theme : "facebook",
        tokenDelimiter: ",",
        preventDuplicates: true,
        <?php if(isset($relate_news)) : ?>
        prePopulate:<?=$relate_news;?>,
        <?php endif; ?>
        
    });
});
</script>
<!-- <script type="text/javascript" src="<?php echo base_url();?>/admin/assets/js/ajaxUpload/single-upload.js"></script> -->
