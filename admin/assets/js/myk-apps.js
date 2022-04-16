var myk={};
redirect=function(url){window.location=url;}
$(function(){
    var url = window.location.href;
    if($('.filter-fields').length){
        var action = url.replace(/\?.*$/,''),params='?';
        var filters = $('.filter-fields');
        filters.on('change',function(){
            filters.each(function(index,item){
                var name=$(this).attr('name'),value=$(this).val();
                if(index > 0){
                    params += '&'+name+'='+value;
                } else {
                    params +=name+'='+value;
                }
            });
            redirect(action+params);
        });
    }
});

var modal = $('#dialog');
function showMessage(message) {
    modal.html(message);
    modal.dialog({
        modal: true,
        resizable: false,
        autoOpen: false,
        draggable: false,
        buttons: {
            'Close': function() {
                $(this).dialog('close');
            }
        }
    });
    modal.dialog("open");
}

function showModal(src) {
    bootModal.find('.modal-content').load(src);
    bootModal.modal('show');
}
function modal_close() {
    modal.html('');
    modal.dialog('close');
}
$(document).on('click','.modal-btn',function(){
   modal.empty();
   modal.load($(this).data('action'));
   modal.dialog({
       modal:true,
       resizable:false,
       autoOpen:false,
       draggable:false,
       buttons : {
           'Cancel' : function() {
               $(this).dialog('close');
           }
       }
       
   });
   modal.dialog('close');
});
function confirm_dialog(msg,buttons) {
    modal.html('<p>'+msg+'</p>');
    modal.dialog({
      resizable: false,
      modal: true,
      buttons: buttons
    });
    modal.dialog('open');
}

var bootModal = $('#app-modal');
$(document).find('a').each(function(){
  if( $(this).attr('data-toggle') == 'modal' )
  {
    $(this).bind('click', function(){
      var contentUrl = $(this).attr('data-href');
      bootModal.find('.modal-content').load(contentUrl);
    });
  }
});

function closeAppModal() {
  bootModal.find('.modal-header').find('button.close').trigger('click');
}

$('.delete-btns').on('click', function(e) {
  e.preventDefault();
  var h = $(this).data('href');
  // console.log(h);
  var msg = 'Bạn có chắc muốn xóa nội dung này?',
      btns = {
        'ok' : {
          'text' : 'Xóa',
          'class':'btn btn-xs btn-danger',
          click:function() {
            location.href = h;
          }
        },
        'cancel': {
          'text' : 'Hủy',
          'class':'btn btn-xs btn-default',
          click: function() {
            $( this ).dialog( "close" );
            return false;
          }
        }
      };
  confirm_dialog(msg, btns);
  return false;
});

var vnDateFormat = function(date) {
  return tx = (date.getHours()<10 ? '0' : '') + date.getHours() + ':' + (date.getMinutes()<10 ? '0' : '') + date.getMinutes() + ':' + (date.getSeconds()<10 ? '0' : '') + date.getSeconds() + ' ' + (date.getDate()<10 ? '0' : '') + date.getDate()  + '/' + ((date.getMonth()+1)<10 ? '0' : '')+(date.getMonth() + 1) + '/' + date.getFullYear();
}

const number_format = (num, decimal=0) => {
    return (decimal==0) ?  numeral(num).format('0,0') : numeral(num).format('0,0.00')
}

function vnDatepickerInit(e, selectedCallback=null) {
    e.datepicker({
        dateFormat: 'dd/mm/yy',
        changeMonth: true,
        changeYear: true,
        monthNamesShort: ["Th. 1", "Th. 2", "Th. 3", "Th. 4",
            "Th. 5", "Th. 6", "Th. 7", "Th. 8", "Th. 9",
            "Th. 10", "Th. 11", "Th. 12"
        ],
        dayNamesMin: ['CN', '2', '3', '4', '5', '6', '7'],
        numberOfMonths: 1,
        showButtonPanel: true,
        defaultDate: '-1',
        yearRange: "-100:+10",
        onSelect:(date)=>{
            if (selectedCallback && typeof(selectedCallback)=='function') 
                selectedCallback(date);
            else
                return false
        }
    });
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

var initTokenInput = function (container=null) {
    if (container==null)
    {
        if ($('input.app-tokeninput').offset()) {
            $('input.app-tokeninput').each(function(){
                let limit = ($(this).data('limit') !== undefined) ? $(this).data('limit') : 1000;
                $(this).tokenInput($(this).data('src'), {
                    theme : "facebook",
                    tokenDelimiter: ",",
                    tokenLimit: limit,
                    preventDuplicates: true,
                    prePopulate:$(this).data('prepopulate'),
                    zindex: 9999999
                });
            });
        }
    }
    else {
        if (container.find('input.app-tokeninput').offset()) {
            container.find('input.app-tokeninput').each(function(){
                let limit = ($(this).data('limit') !== undefined) ? $(this).data('limit') : 1000;
                $(this).tokenInput($(this).data('src'), {
                    theme : "facebook",
                    tokenDelimiter: ",",
                    tokenLimit: limit,
                    preventDuplicates: true,
                    prePopulate:$(this).data('prepopulate'),
                    zindex: 9999999
                });
            });
        }
    }
    
}

const getDateTime = (time, type='datetime') => {
    let h = (time.getHours()<10) ? ('0'+time.getHours()) : time.getHours();
    let m = (time.getMinutes()<10) ? ('0'+time.getMinutes()) : time.getMinutes();
    let s = (time.getSeconds()<10) ? ('0'+time.getSeconds()) : time.getSeconds();
    let d = (time.getDate()<10) ? ('0'+time.getDate()) : time.getDate();
    let mo = (time.getMonth()<9) ? ('0'+(time.getMonth()+1)) : (time.getMonth()+1);

    if (type=='datetime')
     return h + ':' + m + ':' +s+ ' ' + d + '/' + mo + '/' + time.getFullYear();
    else if (type=='date')
     return d + '/' + mo + '/' + time.getFullYear();
    else if (type=='time')
     return h + ':' + m + ':' + s;
}

var appCounter = () => {
    $.get('/apis/appCounter', (res) => {
        let resp = JSON.parse(res);
        if(resp.code===200) {
            $.each(resp.data, function(index, item) {
                $(`#${index}`).text( item )
            })
        }
    });
}

$(function() {

    // setup tooltip
    $('[data-toggle="tooltip"]').tooltip();

    // setup datepicker
    if ($('input.vn-datepicker').offset()) {
        var vnDatepicker = $('input.vn-datepicker');
        vnDatepicker.each(function() {
            vnDatepickerInit($(this));
        });
    }
    
    initTokenInput();

    appCounter();
    setInterval(appCounter, 60000);
});