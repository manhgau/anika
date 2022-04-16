$(document).on('click', '.open-new-window', function(){
    openWindow($(this).data('href'));
});
$(document).on('click', '.btn-back', function(){
    openWindow('dialog.htm');
});
$(document).on('click', '.btn-preview', function(){
    var u = 'demo-'+$(this).data('id')+'.html';
    openWindow(u);
});
$(document).on('click', '#mce-insert-noibat', function(){
    var u = 'demo-'+$(this).data('id')+'.html';
    openWindow(u);
});

$(document).on('click', '#ttsp-insert-box', function(){
   var c = '<p></p><div class="boxsp"><h2><strong>Rượu hoa Cúc</strong> là phương pháp nâng cao sức khỏe của người xưa</h2><div class="left-boxsp"><p><img alt="giá bán Rượu hoa cúc" title="giá bán Rượu hoa cúc" src="http://media.ruouhoacuc.info/uploads/2017_04_25/tra-hoa-cuc1-1493130569.JPG" atl="ruou hoa cuc"></p><p><strong>Giá bán lẻ: 130.000đ / lít</strong></p></div><div class="right-boxsp"><p><b><a href="http://ruouhoacuc.info/">Tại sao sử dụng Rượu hoa Cúc?</a></b></p><p><span>1.</span> Giúp sáng mắt</p><p><span>2.</span> Giải cảm (người hay bị cảm nên sử dụng thường xuyên)</p><p><span>3.</span> Trị chứng hay đau đầu, hoa mắt, chóng mặt, thị lực giảm sút</p><p><i>* Sản phẩm này không phải là thuốc và không có tác dụng thay thế thuốc chữa bệnh</i></p></div></div><p></p>'; 
   execInsertContent(c);
});


function execInsertContent(content)
{
    tinyMCEPopup.editor.execCommand('mceInsertContent',false,content);
    tinyMCEPopup.close();
}