<style type="text/css">
#sortable li{list-style:none;padding:6px 10px;margin:2px 0;width:100%;background:#f4f4f4;font-size:1.15em;cursor:all-scroll;position:relative}
#quick-search-result li{list-style:none;padding:3px 5px;margin:2px 0;border:1px solid #ccc;background:#f4f4f4;font-size:1em;cursor:pointer;}
#quick-search-result, #sortable{margin:0;padding:0}
.remove-it{position:absolute;display:block;width:20px;height:20px;text-align:center;top:0;right:0;cursor:pointer;}
</style>
<script>
    $( function() {
    $("#sortable" ).sortable({
        revert: true
    });
    });
    //search news
    $(document).on('click','#quick-search-btn', function(){
        var keyword = $('#quick-search-input').val();
        if(keyword == '') {
            return false;
        }
        $.get(domain + 'apis/token_search_news/?q='+keyword, function(resp){
            var data = jQuery.parseJSON(resp);
            var html = '';
            $.each(data,function(index, item){
                html += '<li data-id="'+item.id+'">'+item.name+'</li>';
            });
            $('#quick-search-result').html(html);
            return false;
        });
    });
    
    //Select news
    $(document).on('click','#quick-search-result li', function(){
        if($('#sortable li').length > 15)
        {
            alert('Sorry! Chỉ được chọn tối đa 15 bài viết');
            return false;
        }
        var id = $(this).data('id');
        var name = $(this).html();
        var selected = '<li class="ui-state-default"><input type="hidden" name="static_lastest_news[]" value="'+id+'">'+name+'</li>';
        if($('#sortable li').length == 0) {
            $('#sortable').html(selected);
        }
        else {
            $('#sortable li:last-child').after(selected);
        }
        $(this).remove();
    });
    
    //Remove from selected
    $("#sortable li" ).mouseenter(function(){
        var x = '<span class="remove-it" title="Xóa"><i class="fa fa-times" style="color:#d10000"></i></span>';
        $(this).append(x);
    }).mouseleave(function(){
        $(this).find('.remove-it').remove();
    });
    $(document).on('click','.remove-it', function(){
        var li = $(this).parent('li');
        li.remove();
    });
    
</script>