$(document).ready(function(){      
	if($('#upload').length>0) {

		var btnUpload=$("#upload-copyright");
		var status=$('#status-copyright');
		var uploadUrl = '/';
		var submitVar = 'fileUpload[]';
		new AjaxUpload(btnUpload, {            
			action: domain + 'upload/uploadCopyrightImage/',
			name: submitVar,
			data: {
				fileUpload: submitVar
			},
			responseType: false,
			onSubmit: function(file, ext) {
				if (! (ext && /^(jpg|png|jpeg|gif)$/.test(ext))){ 
                    //extension is not allowed 
                    alert("Chỉ cho phép file jpg, png,gif");
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
            			var t='<li><img width="100" src="' + mediaUri + formData.image_url + '"><input type="hidden" name="listImage[]" value="'+formData.id+'"/>';
            			t+='<a class="insert_img_content" onclick="insert_this_image(\''+mediaUri+formData.image_url+'\');return false;" href="javascript:;"> Insert </a>';
            			t+='</li>';
            			$('#display-file ul').prepend(t);
            		});
            	} else{
            		$('<li></li>').append('#files').text(file).addClass('error');
            	}
            }
        });
    }

});