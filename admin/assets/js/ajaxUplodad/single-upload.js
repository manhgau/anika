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