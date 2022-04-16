<script type="text/javascript">
/*
$('.filter').change(function(){
    var i=$('#category-filter').val(),type=$('#filter-type').val(),u='<?php echo base_url('news/');?>/',uri_query='';
    var hot = $('#hot-filter').val(),popular = $('#popular-filter').val(), status=$('#status-filter').val();
    var author = $('#autoComplete').val();
    uri_query += 'cat=' + i + '&status='+ status + '&is_hot=' + hot + '&is_popular=' + popular + '&authorName=' + author + '&page=1';
    u += '?'+uri_query;
    window.location=u;
});
*/
</script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?=base_url('admin/assets/js/datatables/news.js');?>"></script>
<script type="text/javascript">
$(function(){
   $('.delete-btn').on('click',function(){
       var url = $(this).attr('href');
       $.get( url, function( data ) {
           location.reload();
        });
        return false;
   }); 
});

$(document).on('click','.btn-return-news',function(){
    var id=$(this).data('id');
    confirm_dialog('Bạn muốn trả lại bài viết này?',{
        'Trả bài':function(){
            exec_return_news(id);
            $(this).dialog('close');
        },
        'Hủy':function(){
            $(this).dialog('close');
        },
        
    });
});

function exec_return_news(id)
{
    $.ajax({
        url : baseUrl + 'apis/returnNews',
        type:'post',
        dataType:'json',
        data:{id:id},
        success:function(re){
            if(re.code==0)
            {
                $('#row-'+id).remove();
            }
            else{
                showMessage(re.msg);
            }
        }
    });
}
</script>

<script>
  $( function() {
    var availableTags = [<?php foreach($authors as $val){ $arrName[] = '"'.$val->name.'"';} echo implode(',', $arrName);?>];
    $( "#autoComplete" ).autocomplete({
      source: availableTags
    });
  } );

  $('#modal-preview-content').on('show.bs.modal', function (event) {
    var $this = $(this);
      var newsId = $(event.relatedTarget).data('id');
      $.ajax({
        url : domain + 'apis/getNews2Preview/' + newsId,
        type:'get',
        dataType : 'json',
        success: function(res){
            if(res.code === 0) {
                var ctxt = '<p style="font-weight:600">'+res.data.description+'</p>';
                ctxt += res.data.content;
                $this.find('.modal-body').html(ctxt);
                $this.find('.modal-title').text(res.data.title);
            }
        }
      });

      //$(this).find(".modal-body").text(myVal);
    });
  </script>