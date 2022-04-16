
<script type="text/javascript">
    $(function(){
        $('#select-type').change(function(){
            var i=$(this).val();
            if(i==='int') {
                t = '<input type="text" class="form-control input-value" name="value">';
                $('#input-value').html(t);
            } else if(i==='string') {
                t='<textarea name="value" class="form-control input-value" id="tinymce"></textarea>';
                $('#input-value').html(t);
            } else if (i==='image') {
                $('#input-value').html('');
                $('#upload-img').show();
            }

        });
    });
    function add_option(){
        var a=$('input[name="name"]').val(),b=$('select[name="var_type"]').val(),c=$('.input-value').val();
        if(a==''){alert('Tên thông tin không được để trống');return false;}
        if(c==''){alert('Giá trị không được để trống');return false;}
        $.ajax({
            url: baseUrl+'setting/add_option',
            type:'post',
            dataType:'json',
            data:{name:a,value:c,var_type:b},
            success:function(data){
                if (data.msg=='success') {
                    location.reload();
                } else {
                    alert(data.msg);
                    return false;
                }
            }
        });
        return false;
    }

    function remove_menu(id) {
        if(! confirm('Bạn thực sự muốn xóa menu này???') ) {
            return false;
        }
        $.ajax({
            url:'<?php echo base_url('admin/setting/remove_menu/');?>/'+id,
            type:'get',
            success:function(data){
                if (data=='success') {
                    location.reload();
                } else {
                    alert(data);
                    return false;
                }
            }
        });
    }
</script>