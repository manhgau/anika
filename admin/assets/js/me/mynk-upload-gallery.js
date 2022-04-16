$(document).ready(function(){       
    var btnUpload=$("#upload");
    var status=$('#status');
    var uploadUrl = '/';
    var submitVar = 'fileUpload[]';
    new AjaxUpload(btnUpload, {            
        action: adminUrl+'/upload/ajaxUpload/',
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
                    var t='<li id="banner-'+formData.id+'"><table><tr><td><img src="' + mediaUri + formData.image_url + '" width="100" style="height:auto!important"><input type="hidden" name="images['+formData.id+']" value="'+formData.image_url+'"/></td>';
                    t+='<td><input type="text" name="caption['+formData.id+']" class="form-control" placeholder="Caption:"/></td>';
                    t+='<td><input type="text" name="position['+formData.id+']" class="form-control" placeholder="Vị trí:"/></td>';
                    t+='<td><input type="radio" id="img-'+formData.id+'" value="'+formData.image_url+'" name="thumbnail" /></td>';
                    t+='<td><a class="btn btn-xs btn-danger" href="javascript:;" onclick="remove_image('+formData.id+')"> Xóa </a></td>';
                    t+='</tr></table></li>';
                    $('#display-file ul').append(t);
                });

            } else{
                $('<li></li>').append('#files').text(file).addClass('error');
            }
        }
    });
});

function remove_image(id) {
    $('li#banner-'+id).remove();
    return false;
}