<script type="text/javascript" src="<?php echo base_url('admin/assets/js/plugins/jquery-textext/js/textext.core.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('admin/assets/js/plugins/jquery-textext/js/textext.plugin.ajax.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('admin/assets/js/plugins/jquery-textext/js/textext.plugin.arrow.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('admin/assets/js/plugins/jquery-textext/js/textext.plugin.autocomplete.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('admin/assets/js/plugins/jquery-textext/js/textext.plugin.clear.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('admin/assets/js/plugins/jquery-textext/js/textext.plugin.filter.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('admin/assets/js/plugins/jquery-textext/js/textext.plugin.focus.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('admin/assets/js/plugins/jquery-textext/js/textext.plugin.prompt.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('admin/assets/js/plugins/jquery-textext/js/textext.plugin.suggestions.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('admin/assets/js/plugins/jquery-textext/js/textext.plugin.tags.js'); ?>"></script>
<script type="text/javascript">
    $('#tags').textext({
        plugins : 'tags prompt focus autocomplete ajax arrow',
        tagsItems : [ 'Basic', 'JavaScript', 'PHP', 'Scala' ],
        prompt : 'Add one...',
        ajax : {
            url : '/manual/examples/data.json',
            dataType : 'json',
            cacheResults : true
        }
    });
</script>
<script type="text/javascript" src="<?php echo base_url('admin/assets/js/ajax_upload.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('admin/assets/js/me/mynk-upload-gallery.js'); ?>"></script>