if($('#upload-single').length>0) 
{
    $(document).ready(function(){
        var btnUpload=$("#upload-single");
        var status=$('#status-single');
        var uploadUrl = '/';
        var submitVar = 'file_upload';
        var fieldName = btnUpload.data('name');
        if(fieldName === undefined || fieldName == '')
        {
            fieldName = 'thumbnail';
        }
        new AjaxUpload(btnUpload, {
            action: baseUrl + 'upload/ajaxUploadSingle',
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
                status.text('Đang tải ... ');
            },
            onComplete: function(file, response){
                var formData = JSON.parse(response);
                console.log(formData);
                status.text('');
                if(response){
                    var t = '<img src="'+mediaUri+formData.image_url+'" />';
                    t += '<input type="hidden" name="'+fieldName+'" value="'+formData.image_url+'"/>';
                    $('#singleUploaded').html(t);
                } else{
                    $('<li></li>').append('#files').text(file).addClass('error');
                }
            }
        });
    });
}

if($('#upload-single-1').length>0) 
{
    $(document).ready(function(){
        var btnUpload=$("#upload-single-1");
        var status=$('#status-single-1');
        var uploadUrl = '/';
        var submitVar = 'file_upload';
        var fieldName = btnUpload.data('name');
        if(fieldName === undefined || fieldName == '')
        {
            fieldName = 'thumbnail';
        }
        new AjaxUpload(btnUpload, {
            action: baseUrl + 'upload/ajaxUploadSingle',
            name: submitVar,
            data: {
                fileUpload: submitVar
            },
            responseType: false,
            onSubmit: function(file, ext) {
                if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
                    //extension is not allowed 
                    alert("Chỉ cho phép file jpg, png, gif");
                    return false;
                }                             
                status.text('Đang tải ... ');
            },
            onComplete: function(file, response){
                var formData = JSON.parse(response);
                status.text('');
                if(response){
                    var t = '<img src="'+mediaUri+formData.image_url+'" />';
                    t += '<input type="hidden" name="'+fieldName+'" value="'+formData.image_url+'"/>';
                    $('#singleUploaded-1').html(t);
                } else{
                    $('<li></li>').append('#files').text(file).addClass('error');
                }
            }
        });
    });
}

$(function(){
    if ($('.img-single-upload')) 
    {
        $('.img-single-upload').each(function(idx, ele){
            var btnUpload=$(ele);
            var fieldName = btnUpload.data('name');
            var status=$('#status-'+name);
            var preview=$('#uploaded-preview-'+name);
            var uploadUrl = '/';
            var submitVar = 'file_upload';
            if(fieldName === undefined || fieldName == '')
            {
                fieldName = 'thumbnail';
            }
            new AjaxUpload(btnUpload, {
                action: baseUrl + 'upload/ajaxUploadSingle',
                name: submitVar,
                data: {
                    fileUpload: submitVar
                },
                responseType: false,
                onSubmit: function(file, ext) {
                    if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
                        //extension is not allowed 
                        alert("Chỉ cho phép file jpg, png, gif");
                        return false;
                    }                             
                    status.text('Đang tải ... ');
                },
                onComplete: function(file, response){
                    var formData = JSON.parse(response);
                    status.text('');
                    if(response){
                        let t = '<img src="'+mediaUri+formData.image_url+'" />';
                        t += '<input type="hidden" name="'+fieldName+'" value="'+formData.image_url+'"/>';
                        preview.html(t);
                    } else{
                        preview.append($('<p></p>').text(file).addClass('error'));
                    }
                }
            });
        });
    }


});

if($('.image-upload-container').offset()) 
{
    $(document).ready(function(){

        $('.image-upload-container').each(function() {
            var $this = $(this);
            var btnUpload=$this.find(".upload-button");
            var fieldName = btnUpload.data('name');
            var copyright = false;
            if(fieldName === undefined || fieldName == '')
            {
                fieldName = 'thumbnail';
            }
            if(btnUpload.data('copyright') === true)
            {
                copyright=true
            }
            var status=$this.find('.status-' + fieldName);
            var preview=$this.find('.preview-' + fieldName);
            var uploadUrl = '/';
            var submitVar = 'file_upload';
            var uploadProcess = (copyright===true) ? 'upload/ajaxUploadSingleCopyright' : 'upload/ajaxUploadSingle';

            new AjaxUpload(btnUpload, {
                action: baseUrl + uploadProcess,
                name: submitVar,
                data: {
                    fileUpload: submitVar
                },
                responseType: false,
                onSubmit: function(file, ext) {
                    if (! (ext && /^(jpg|png|jpeg|gif|jfif)$/.test(ext))){
                        //extension is not allowed 
                        showMessage("Chỉ cho phép file ảnh .jpg, .png, .gif");
                        return false;
                    }                             
                    status.text('Đang tải ... ');
                },
                onComplete: function(file, response){
                    var formData = JSON.parse(response);
                    status.text('');
                    if(response){
                        var t = '<img src="'+mediaUri+formData.image_url+'" />';
                        t += '<input type="hidden" name="'+fieldName+'" value="'+formData.image_url+'"/>';
                        preview.html(t);
                    } else{
                        preview.text(file).addClass('error');
                    }
                }
            });
        });
    });
}