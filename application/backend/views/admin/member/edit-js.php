<script src="https://unpkg.com/imask"></script>
<script>
    var ownerPhone = $('input[name="owner_phone"]');
    ownerPhone.on('change', function() {
        let phone = $(this).val();
        let id = $('input[name="id"]').val();
        $.get('/realnews/apis/checkPhone', {phone, id}, (res) => {
            if (res.msg=='already') 
                $('.phone-check').removeClass('hidden').text('Số điện thoại đã tồn tại');
            else
                $('.phone-check').addClass('hidden').text('');
        })
    });

    var codeInput = $('input[name="code"]');
    codeInput.on('change', function() {
        let container = $(this).closest('div');
        let code = $(this).val();
        let id = $('input[name="id"]').val();

        if (code=='') {
            container.addClass("has-error").removeClass('has-success');
            $('.code-check').removeClass('hidden').text('Mã bài viết không được bỏ trống');
            return;
        };
        
        $.get('/realnews/apis/checkCode', {code, id}, (res) => {
            if (res.msg=='already') {
                container.addClass("has-error").removeClass('has-success');
                $('.code-check').removeClass('hidden').text('Mã bài viết đã tồn tại');
            }
            else {
                container.removeClass("has-error").addClass('has-success');
                $('.code-check').addClass('hidden').text('');
            }
        })
    })

    const numberMask = {
        mask: Number,
        min: 0,
        max: 999999999999,
        thousandsSeparator: ','
    };

    var priceMask = IMask(document.getElementById('price-mask'), numberMask);
    var sale_bonusMask = IMask(document.getElementById('sale_bonus-mask'), numberMask);

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
            case 'ward':
                user_ward.html(opts);
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


    $(() => {
         // $('select[name="bank_name"]').select2();
         // $('select[name="province_id"]').select2();
         // $('select[name="district_id"]').select2();

         vnDatepickerInit( $('input[name="service_time"]') );
    });
</script>