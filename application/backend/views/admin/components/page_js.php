<!-- Bootstrap -->
<script src="<?php echo base_url('admin/assets');?>/js/bootstrap.min.js" type="text/javascript"></script>
<!-- AdminLTE App -->
<script type="text/javascript">
    var adminUrl='<?php echo base_url();?>';
    var baseUrl='<?php echo base_url();?>';
    var mediaUri = '<?=config_item('media_server');?>';
    function toggle_seo() {
        $('#seo-box-title').toggleClass('active');
        $('.seo-box').toggle();
    }
    $(document).on('click','.alert',function(){
        $(this).remove();
    });
</script>
<script src="<?php echo base_url('admin/assets');?>/js/AdminLTE/app.js" type="text/javascript"></script>
<script src="<?php echo base_url('admin/assets');?>/js/myk-apps.js?1.02" type="text/javascript"></script>
<!-- Place inside the <head> of your HTML -->
<script type="text/javascript" src="<?php echo base_url('admin/assets/js/tinymce/tiny_mce.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('admin/assets/js/me/news-editor.js')?>"></script>
<script type="text/javascript" src="<?php echo base_url('admin/assets/js/me/news-editor-2.js')?>"></script>


<!-- date time picker -->
<script src="<?php echo base_url('admin/assets');?>/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript">
    $(".form_datetime1").datetimepicker({
        format: 'dd-mm-yyyy hh:ii', 
        forceParse: true,
        todayBtn: true,
        pickerPosition: "bottom-left" });
</script>
<!-- Preview image before upload -->
<script type="text/javascript">
$(function() {
    $(document).on('change','#uploadFile',function(){
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support 
        if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file 
            reader.onloadend = function(){ // set image data as background of div
                var st = { 'background-image':'url("'+this.result+'")' }
                $("#imagePreview").css(st);
            }
        }
    });
});
</script>

<script type="text/javascript">
$(function() {
    $(".list-image").on("change", function()
    {
        var item = $(this).artt('title');
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support 
        if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file 
            reader.onloadend = function(){ // set image data as background of div
                var st = { 'background-image':'url("'+this.result+'")' }
                $('#'+item).css(st);
            }
        }
    });
});
</script> 
                                                           
<script src="<?php echo base_url('admin/assets/js/plugins/daterangepicker/daterangepicker.js');?>" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        if($('#reservationtime').length){
        $('#reservationtime').daterangepicker({timePicker: true, timePickerIncrement: 30, format: 'DD/MM/YYYY H:mm A'});             
        }     
    });
</script>
<?php if($this->router->class != 'gallery') : ?>
<script type="text/javascript" src="<?php echo base_url('admin/assets/js/ajax_upload.js'); ?>"></script>
<script type="text/javascript">
    if($('#upload').length>0) {
        $(document).ready(function(){       
        var btnUpload=$("#upload");
        var status=$('#status');
        var uploadUrl = '/';
        var submitVar = 'fileUpload[]';
        new AjaxUpload(btnUpload, {            
            action: '<?php echo base_url('upload/ajaxUpload/');?>/',
            name: submitVar,
            data: {
                fileUpload: submitVar
            },
            responseType: false,
            onSubmit: function(file, ext) {
                if (! (ext && /^(jpg|png|jpeg|gif|mp4)$/.test(ext))){ 
                    //extension is not allowed 
                    alert("Chỉ cho phép file jpg, png, gif, mp4");
                    return false;
                }
                var filename = file.replace('.'+ext,'');
                if(! (/^[a-zA-Z0-9 ._-]*$/.test(filename)))
                {
                    alert("Chỉ cho phép upload tên file không dấu!");
                    return false;                    
                }                                
                status.text('Đang tải ... ');
            },
            onComplete: function(file, response){
                var formDatas = JSON.parse(response);
                status.text('');
                if(response){
                    $.each(formDatas,function(i,formData){
                        <?php if ($sub_view == 'admin/setting/index') : ?>
                        var t='<li id="banner-'+formData.id+'"><table><tr><td><img src="' + mediaUri + formData.image_url + '"><input type="hidden" name="bannerImage[]" value="'+formData.image_url+'"/><input type="hidden" name="bannerId[]" value="0"/></td>';
                        t+='<td><input type="text" name="bannerTitle[]" class="form-control" placeholder="Tiêu đề:"/></td>';
                        t+='<td><input type="text" name="bannerLink[]" class="form-control" placeholder="Đường dẫn:"/></td>';
                        t+='<td><input type="text" name="bannerOrder[]" class="form-control" placeholder="Vị trí:"/></td>';
                        t+='<td><a class="btn btn-default" href="javascript:;" onclick="remove_banner('+formData.id+')"> Xóa </a></td>';
                        t+='</tr></table></li>';
                        $('#display-file ul').prepend(t);
                        <?php elseif ($sub_view === 'admin/setting/option' || $sub_view === 'admin/setting/edit_option') : ?>
                        var t='<li><img src="' + mediaUri + formData.image_url + '"><input type="hidden" name="value" value="'+formData.image_url+'" class="input-value"/>';
                        t+='</li>';
                        $('#display-file ul').html(t);
                        <?php else : ?>                    
                        var t='<li><img width="100" src="' + mediaUri + formData.image_url + '"><input type="hidden" name="listImage[]" value="'+formData.id+'"/>';
                        t+='<a class="insert_img_content" onclick="insert_this_image(\''+mediaUri+formData.image_url+'\');return false;" href="javascript:;"> Insert </a>';
                        t+='</li>';
                        $('#display-file ul').prepend(t);
                        <?php endif; ?>
                    });
                } else{
                    $('<li></li>').append('#files').text(file).addClass('error');
                }
            }
        });
    });
    }
    $('.insert_img_content').on('click',function(){
        var a=$(this).attr('data');
        tinyMCE.execCommand('mceInsertContent',false,'<img src=\"'+a+'\" />');
        return false;
    });
    
    function insert_this_image(u){
        tinyMCE.execCommand('mceInsertContent',false,'<img src=\"'+u+'\" />');
    }
    
    function remove_banner(i){
        $('li#banner-'+i).remove();
        return false;
    }
</script>
<?php endif; ?>