var FB_ACCESS_TOKEN = '';
var USER_ID = ($('input[name="userId"]').val()) ? $('input[name="userId"]').val() : null;
window.lastCode = null;
window.lastNews = null;

window.setLastPhoneChecker = (phone, data) => {
    data.phone = phone;
    data.failedTimes = (data.code===200) ? 0 : data.failedTimes+1;
    data.disabledTime = (data.failedTimes > 2) 
        ? data.disabledTime = new Date().getTime() + 2*60*60*1000
        : 0;
    window.localStorage.setItem("phone_checked", JSON.stringify(data))
}

window.getLastPhoneChecker = () => {
    return !!window.localStorage.getItem("phone_checked") 
        ? JSON.parse(window.localStorage.getItem("phone_checked")) 
        : null
}

function statusChangeCallback(response) {
    // console.log('statusChangeCallback');
    console.log(response);
    if (response.status === 'connected') {
        FB_ACCESS_TOKEN = response.authResponse.accessToken;
        loginFb(response.authResponse.accessToken);
        modal_close();
    } else {
        showLoginButton()
    }
}

function showLoginButton() {
    $('#fb-login').show();
}

function checkLoginState() { // Called when a person is finished with the Login Button.
    // console.log('checkLoginState');
    FB.getLoginStatus(function(response) {
        statusChangeCallback(response);
    });
}

function loginFb(accessToken) {
    $.post('/auth', {accessToken}, (res) => {
        USER_ID = res.data.fb_id;
        (res.code===200) ? $('#user-nav').html(res.data.user_nav) : alert('Hệ thống bận, thử lại sau');
        window.lastCode = null;
        window.lastNews = null;
    })
}

function getFbInfo() {// Testing Graph API after login.  See statusChangeCallback() for when this call is made.
    // console.log('Welcome!  Fetching your information.... ');
    FB.api(
        '/me',
        'GET',
        {"fields":"id,name,email"},
        function(response) {
            console.log(response);
            console.log('Successful login for: ' + response.name);
            // document.getElementById('status').innerHTML = response.name;
        }
        );
}

const fbLoginForm = () => {
    FB.login(function(response){
        console.log(response);
        if (response.status === 'connected') {
            loginFb(response.authResponse.accessToken);
            // console.log('login success');
            FB.api('/me', function(response) {
                console.log(response);
                console.log('Successful login for: ' + response.name);
                // document.getElementById('status').innerHTML ='Thanks for logging in, ' + response.name + '!';
                // document.getElementById('status').innerHTML = response.name;
            });
        } else {
            console.log('login failed');
        }
    }, {scope:'public_profile,email'});
}

function getNews(code) {
    $.get('/home/apis/getNews', {code}, (res) => {
        return res;
    })
}

const modal = $('#dialog');

const showUserId = function(id) {
    let pt = 'VN-000000',
    idlen = id.length;
    return pt.slice(0, -idlen) + id;
}

function showMessage(message, type='info', callback=null) {
    let c = '';
    if (type=='success') 
        c = 'text-success';
    else if(type=='error')
        c='text-danger';

    let msgContent = '<div class="'+c+'">'+message+'</div>';
    modal.html(msgContent);
    modal.dialog({
        modal: true,
        resizable: false,
        autoOpen: false,
        draggable: false,
        buttons: {
            'Close': function() {
                $(this).dialog('close');
                if (callback!==null)
                    eval(callback)
            }
        }
    });
    modal.dialog("open");
}

function modal_close() {
    modal.html('');
    modal.dialog('close');
}


function confirm_dialog(msg, buttons) {
    modal.html('<p>' + msg + '</p>');
    modal.dialog({
        resizable: false,
        modal: true,
        buttons: buttons
    });
    modal.dialog('open');
}

function confirmAction(rmAction, msg='xóa tài liệu này?', execLabel='Xác nhận') {
    let btns = {
        'ok': {
            text: execLabel,
            click: () => {
                modal.dialog('close');
                eval(rmAction)
            }
        },
        'cancel': {
            text:'Hủy',
            click: () => {
                modal.dialog('close');
            }
        }
    };
    confirm_dialog(msg, btns);
}

// setup appModal
var bootModal = $('#app-modal');
$(document).find('a').each(function() {
    if ($(this).attr('data-toggle') == 'modal') {
        $(this).bind('click', function() {
            var contentUrl = $(this).attr('data-href');
            bootModal.find('.modal-content').load(contentUrl);
        });
    }
});

function closeAppModal() {
    bootModal.find('.modal-header').find('button.close').trigger('click');
}

bootModal.on('hidden.bs.modal', function(e) {
    bootModal.find('.modal-content').empty();
});

function showModal(src) {
    bootModal.find('.modal-content').load(src);
    bootModal.modal('show');
}

window.checkAuth = () => {
    if (USER_ID==null) {
        showMessage(`Vui lòng <a href="javascript:;" onclick="fbLoginForm()"><i class="text-danger">Đăng nhập</i></a> để tiếp tục`)
        return false;
    }
    return true;
}

window.postRequest = function() {
    let form = $('#post-form');
    $.post('/home/apis/postRequest', form.serializeArray(), (res) => {
        showMessage(res.msg, (res.code===200) ? 'success' : 'error');
        if (res.code===200) {
            form.trigger('reset');
            updateUserView(res.data.me)
        }
    })
}

window.updateUserView = function(info=null) {
    if (!info) {}
    (info && $('#point-balance').offset()) ? $('#point-balance').text(info.point) : '';
}

window.logout = () => {
    $.post('/home/apis/logout', (res)=> {
        // FB.logout();
        updateUserView();
        USER_ID = null;
        $('#user-nav').html(res.data.user_nav);
        window.lastCode = null;
        window.lastNews = null;
    })
}

function fillNewsIntro(news=null) {
    $('#news-intro').html(`
        <div class="panel-body">
        <ul class="list-group bg-white text-left" style="margin-bottom:0">
            <li class="list-group-item">Số SRC: <strong class="text-danger text-xl" id="point-balance">${(news) ? news.point : ''}</strong></li>
            <li class="list-group-item">Dịch vụ: ${(news) ? news.service_type_name.join(', ') : ''}</li>
            <li class="list-group-item">Loại nhà: ${(news) ? news.type_name : ''}${(news && news.bedroom_number) ? `; PN: ${news.bedroom_number}` : ''}${(news && news.floor_number) ? `; ST: ${news.floor_number}` : ''}${(news && news.acreage) ? `; DT: ${news.acreage}` : ''}</li>
            <li class="list-group-item">Địa chỉ: ${(news) ? `${news.address}, ${news.province.name}` : ''}</li>
            <li class="list-group-item">Số điện thoại chủ nhà: ${(news) ? news.owner_phone : ''}</li>
            <li class="list-group-item">Link bài viết: ${(news.fb_page_url) ? `<a href="${news.fb_page_url}" target="_blank" class="text-info">Xem bài đăng &raquo;</a>` : ''}</li>
            <li class="text-center list-group-item"><button class="btn btn-danger" ${(news) ? `onClick="buyNews('${news.code}')"` : ''}>Lấy SĐT</button></li>
        </ul>
        </div>
    `);

}

window.getNew = (code) => {
    if (code != lastCode) {
        $.post('/home/apis/getNews', {code}, (res)=> {
            if (res.code===200) { 
                fillNewsIntro(res.data.news);
                lastNews = res.data.news;
                lastCode = code;
            } 
            else {
                showMessage(res.msg, 'error');
                fillNewsIntro(null)
            } 
        })
    }
    else
        fillNewsIntro(lastNews);

}

window.buyNews = (code) => {
    $.post('/home/apis/buyNews', {code}, (res)=> {
        (res.code===200) ? fillNewsIntro(res.data.news) : showMessage(res.msg, 'error');
        $('#user-nav').find('#point-balance').text(res.data.me.point);
        lastNews = res.data.news;
    })
}

 window.clickNews = (code) => {
    if (! checkAuth()) {
        return false
    }

    $.post('/home/apis/buyNews', {code}, (res)=> {
        (res.code===200) ? location.reload() : showMessage(res.msg, 'error');
    })
}

window.refundRequest = (data) => {
    $.post('/home/apis/refundRequest', data, (res)=> {
        (res.code===200) ? showMessage(res.msg, 'success') : showMessage(res.msg, 'error');
        if (res.code===200)
            $('#refund-form').trigger('reset');
    })
}

window.showPostPrice = (option) => {
    $('#post-form').find('#point-fee').text(option.text());
}

window.checkSalePhone = async (phone) => {
    await $.post('/home/apis/checkSalePhone', {phone}, (res) => {
        check = res;
    });

    return check;
}

$(function(){
    // setTimeout(checkLoginState, 500);
    if ($('#post-form').offset()) {
        // check timeout
        let lastPost = getLastPhoneChecker();
        // console.log(lastPost);
        let cTime = new Date().getTime();
        if(!!lastPost && !!lastPost.disabledTime && cTime<lastPost.disabledTime) {
            $('#post-form').html(`<p class="text-center text-danger">Bạn đã vượt quá số lần gửi yêu cầu. Vui lòng chờ ít phút để tiếp tục.</p>`);
        }
        else {
            $('#post-form').on('submit', function(event){
                event.preventDefault();
                if (! checkAuth()) {
                    return false
                }

                let $this = $(this);
                confirmAction('postRequest()', 'Gửi yêu cầu duyệt bài viết của bạn?', 'Gửi yêu cầu');
            })

            let pointSelector = $('#post-form').find('select[name="point"]');
            pointSelector.on('change', function(){
                showPostPrice($(this).find('option:selected'))
            })

            showPostPrice(pointSelector.find('option:selected'));
            let phoneSelector = $('#post-form').find('input[name="owner_phone"]');
            phoneSelector.on('change', async function(){
                let $this = $(this);
                let checked = await checkSalePhone($(this).val());
                phoneSelector.closest('div').find('.text-danger').remove();
                if (checked.code===201) {
                    phoneSelector.after(`<span class="text-danger">${checked.msg}</span>`);
                    $('#post-form').find('button').prop('disabled', false);
                    return;
                }
                if (checked.code !== 200 && checked.code !== 201) {
                    phoneSelector.after(`<span class="text-danger">${checked.msg}</span>`);
                    $('#post-form').find('button').prop('disabled', true);
                    return;
                }
                $('#post-form').find('button').prop('disabled', false);
            })
        }
        
    }

    if ($('#search-form').offset()) {
        $('#search-form input[name="code"]').on('change', function(event){
            event.preventDefault();
            let $this = $(this);
            let code = $(this).val();
            getNew(code);
        });

        $('#search-form').on('submit', function(event){
            event.preventDefault();
            let $this = $(this);
            let code = $(this).find('[name="code"]').val();
            getNew(code);
        })
    }

    if ($('#refund-form').offset()) {
        $('#refund-form').on('submit', function(event){
            event.preventDefault();
            if (! checkAuth()) {
                return false
            }
            
            let $this = $(this);
            refundRequest( $this.serializeArray() );
        })
    }

})