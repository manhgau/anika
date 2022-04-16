<!DOCTYPE HTML>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="Myz" />

	<title>Upload File</title>
</head>

<body>
<form action="<?php echo base_url('admin/upload/save_image'); ?>" method="post" enctype="multipart/form-data" id="form-upload">
<input type="file" name="fileImage" id="file-input" />
</form>
<p><img src="<?php echo $img?>" width="400" style="max-width:400px" id="img-preview"/></p>
<button id="btn-insert" style="color: #fff;text-shadow: 0 -1px 0 #55830c;border-color: #62a60a #62a60a #4d9200;background: #69b10b;background-image: -webkit-gradient(linear,0 0,0 100%,from(#9ad717),to(#69b10b));background-image: -webkit-linear-gradient(top,#9ad717,#69b10b);background-image: -o-linear-gradient(top,#9ad717,#69b10b);background-image: linear-gradient(to bottom,#9ad717,#69b10b);background-image: -moz-linear-gradient(top,#9ad717,#69b10b);filter: progid:DXImageTransform.Microsoft.gradient(gradientType=0,startColorstr='#9ad717',endColorstr='#69b10b')"> Insert to content </button>
<!-- jQuery 2.0.2 -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
<script type="text/javascript">
$(function(){
    $('#file-input').on("change",function(){
        $('#form-upload').submit();
        $('#btn-insert').css({display:'block'});
    });
    
    $('#btn-insert').click(function(){
        var imgUrl = $('#img-preview').attr('src');
        if(imgUrl == ''){
            alert('upload hinh anh truoc'); return false;
        }
        window.opener.$("#cke_72_textInput").val(imgUrl);
        window.opener.$("#cke_67_previewImage").attr('src',imgUrl);
        window.opener.$("#cke_67_previewImage").css({display:'block'});
        window.close();
        return false;
    });
});
</script>
</body>
</html>