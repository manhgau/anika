<script type="text/javascript" src="<?php echo base_url();?>/admin/assets/js/ajaxUpload/single-upload.js"></script>
<script type="text/javascript" src="<?php echo base_url('admin/assets/js/plugins/jquery-textext/js/textext.core.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('admin/assets/js/plugins/jquery-textext/js/textext.plugin.tags.js'); ?>"></script>
<script src="/admin/assets/js/jquery.tokeninput.js"></script>
<script src="https://unpkg.com/imask"></script>
<script>
    var serviceSelector = $('[name="service_type"]');
    var rentTimeSelector = $('#rent_time-container');
    var showRentTime = () => {
        let type = serviceSelector.find('option:selected').val();
        if (type=='cho_thue') {
            rentTimeSelector.closest('div').removeClass('hidden');
            rentTimeSelector.closest('div').find('label').addClass('required');
            rentTimeSelector.prop('required', true);
        }
        else {
            rentTimeSelector.closest('div').addClass('hidden');
            rentTimeSelector.closest('div').find('label').removeClass('required');
            rentTimeSelector.prop('required', false).val('').trigger('change');
        }
    }
    serviceSelector.on('change', showRentTime);

    var ownerPhone = $('input[name="owner_phone"]');
    ownerPhone.on('change', function() {
        let phone = $(this).val();
        let id = $('input[name="id"]').val();
        $.get('/manage_product/apis/checkPhone', {phone, id}, (res) => {
            if (res.code!=200) 
                $('.phone-check').removeClass('hidden').text(res.msg);
            else
                $('.phone-check').addClass('hidden').text('');
        })
    });

    var addressInput = $('input[name="address"]');
    addressInput.on('change', function() {
        let address = $(this).val();
        let province_id = $('[name="province_id"] option:selected').val();
        let district_id = $('[name="district_id"] option:selected').val();
        let id = $('input[name="id"]').val();
        $.get('/manage_product/apis/checkAddress', {address, province_id, district_id, id}, (res) => {
            if (res.msg=='already') 
                $('.address-check').removeClass('hidden').text('Địa chỉ đã tồn tại');
            else
                $('.address-check').addClass('hidden').text('');
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
            else if (res.msg=='not valid') {
                container.addClass("has-error").removeClass('has-success');
                $('.code-check').removeClass('hidden').text('Mã bài viết phải gồm 8 ký tự 0 - 9');
            }
            else {
                container.removeClass("has-error").addClass('has-success');
                $('.code-check').addClass('hidden').text('');
            }
        })
    })

    // const numberMask = {
    //     mask: Number,
    //     min: 0,
    //     max: 999999999999,
    //     thousandsSeparator: ','
    // };

    // var priceMask = IMask(document.getElementById('price-mask'), numberMask);
    // var sale_bonusMask = IMask(document.getElementById('sale_bonus-mask'), numberMask);

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
            url: '/manage_product/getListLocationByPrarent',
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
         $('select[name="bank_name"]').select2();
         $('select[name="province_id"]').select2();
         $('select[name="district_id"]').select2();

         vnDatepickerInit( $('input[name="rent_enddate"]') );
         showRentTime();
    });
</script>