<script type="text/javascript">
$('.filter').change(function(){
    var i=$('#category-filter').val(),type=$('#filter-type').val(),u='<?php echo base_url('news/');?>/',uri_query='';
    var hot = $('#hot-filter').val(),popular = $('#popular-filter').val(), status=$('#status-filter').val();
    var author = $('#autoComplete').val();
    uri_query += 'cat=' + i + '&status='+ status + '&is_hot=' + hot + '&is_popular=' + popular + '&authorName=' + author + '&page=1';
    u += '?'+uri_query;
    window.location=u;
});
</script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.1.2/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="<?=base_url('admin/assets/js/datatables/report-news.js');?>"></script>
<script type="text/javascript">
$(function(){
   $('.delete-btn').on('click',function(){
       var url = $(this).attr('href');
       $.get( url, function( data ) {
           location.reload();
        });
        return false;
   });
   $('#time-range').daterangepicker();
});
</script>

<script>
  $( function() {
    var availableTags = [<?php foreach($authors as $val){ $arrName[] = '"'.$val->name.'"';} echo implode(',', $arrName);?>];
    $( "#autoComplete" ).autocomplete({
      source: availableTags
    });
  } );
  </script>