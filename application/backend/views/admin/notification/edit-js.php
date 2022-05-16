<script src="/admin/assets/js/jquery.tokeninput.js"></script>
<script src="https://unpkg.com/imask"></script>
<script type="text/javascript" src="<?php echo base_url();?>/admin/assets/js/ajaxUpload/single-upload.js"></script>
<script type="text/javascript" src="<?php echo base_url('admin/assets/js/plugins/jquery-textext/js/textext.core.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('admin/assets/js/plugins/jquery-textext/js/textext.plugin.tags.js'); ?>"></script>
<script type="text/javascript">

    $(function(){
        $('select[name="sender_type"]').on('click',function(){
            if(this.value==='') {
                document.getElementById("selectBox").style.height = '5px';
            }
            else if (this.value==='one')
            {
                document.getElementById("selectBox").style.height = 'auto';
                document.getElementById("members").style.height = 'auto';
                document.getElementById("selectTeam").style.height = '2px';
            }
            else if(this.value==='team'){
                document.getElementById("selectBox").style.height = 'auto';
                document.getElementById("selectTeam").style.height = 'auto';
                document.getElementById("members").style.height = '2px';
            }
            else {
                document.getElementById("selectBox").style.height = '5px';
            }
        });
    });
    $('select[name="sender_type"]').on('change',function (e) {
        if (this.value==='team') {
            $('.selectTeam').show();
            $('.members').hide();

        }
        else if(this.value ==='one')
        {
            $('.members').show();
            $('.selectTeam').hide();

        }
        else {
            $('.members').hide();
            $('.selectTeam').hide();
        }
    });
    $('select[name="team"]').on('change',function (e) {
        console.log(this.value)
        if (this.value==='department')
        {
            $('.departments').show();
            $('.provinces').hide();
            $('.services').hide();
        }
        else if (this.value==='province') {
            $('.provinces').show();
            $('.departments').hide();
            $('.services').hide();
        }
        else
        {
            $('.services').show();
            $('.departments').hide();
            $('.provinces').hide();
        }
    });

    var user_province = $('select[name="province_id"]');
    var user_district = $('select[name="district_id"]');

    let fillSelectLocation = function(type, data)
    {
        let opts = '';
        $.each(data, function(index, item){
            opts += '<option value="'+item.id+'">'+item.name+'</option>';
        });

        switch (type) {
            case 'province':
                user_province.html(opts);
                break;
            case 'district':
                user_district.html(opts);
                break;
            default :
                break;
        }
    }
    let fetchListLocation = function(id, type)
    {
        $.ajax({
            type : 'get',
            dataType : 'json',
            url: '/realnews/getListLocationByPrarent',
            data:{parent_id:id, type:type},
            success: function(response) {
                if (response.code==200) {
                    fillSelectLocation(type, response.data);
                }
            }
        });
    }
    user_province.on('change', function() {
        let opt = user_province.find('option:selected').val();
        if (opt=='') {
            user_district.find('option:not(:first-child)').remove();
            user_district.prop('disabled', false);
        }
        else
        {
            user_district.prop('disabled', false);
            let province_id = $(this).find('option:selected').val();
            fetchListLocation(province_id, 'district');
        }
    });
</script>