$(function(){
    if ($('.img-single-upload').offset()) 
    {
        $('.img-single-upload').each(function(idx, ele){
            var btnUpload=$(ele);
            var fieldName = btnUpload.data('name');
            var status=$('#status-'+name);
            var preview=btnUpload.parent().find('.offer-img-preview');
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
                        let input = $('input[name="'+fieldName+'"]');
                        let currentVal = input.val();
                        (currentVal != '') ? currentVal += ','+formData.image_url : currentVal=formData.image_url;
                        input.val(currentVal).trigger('change');
                        return false;
                    } else{
                        preview.append($('<p></p>').text(file).addClass('error'));
                    }
                }
            });
        });
    }


});