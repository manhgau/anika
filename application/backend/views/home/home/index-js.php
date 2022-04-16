
<script>
    var user_province = $('select[name="province_id"]');
    var user_district = $('select[name="district_id"]');

    let fillSelectLocation = function(type, data)
    {
        console.log(type, data);
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
            url: '/home/apis/getListLocationByPrarent',
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