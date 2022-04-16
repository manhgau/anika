function openWindow(u) {
    tinyMCE.activeEditor.windowManager.open({
        url : u,
        width : 600,
        height : 400,
        scrollbars :   1,
        },
        {
            custom_param : 1
    });
    tinyMCEPopup.close();
}
$(document).on('click','.btn-preview', function(){
    var url = $(this).data('href');
    openWindow(url);
});

$(document).on('click','.btn-add-stylist', function(){
    var url = $(this).data('href');
    openWindow(url);
});

$(document).on('click','.exec-insert', function(){
    execInsertContent();
});

$(document).on('click','.exec-insert-youtube-video', function(){
    execInsertYoutubeVideoEmbed();
});

$(document).on('click','.exec-insert-action-button', function(){
    execInsertButton();
});

function execInsertButton()
{
    let url = $('input[name="url"]').val();
    let title = $('input[name="title"]').val();
    if (url=='' || title=='') {
        return false;
    }
    let content = '<p><a href="'+url+'" class="bg-gradient-green button rounded button-apply">'+title+'</a></p>';
    tinyMCEPopup.editor.execCommand('mceInsertContent', false, content);
    tinyMCEPopup.close();
}

function execInsertContent()
{
    var content = '<div class="entry-inner highlight"><p>'+$('#insert-content').val()+'</p></div><p></p>';
    tinyMCEPopup.editor.execCommand('mceInsertContent', false, content);
    tinyMCEPopup.close();
}

function execInsertYoutubeVideoEmbed()
{
    var content = '<div id="youtube-video-embed-container">';
    content += '<iframe src="https://www.youtube.com/embed/'+ $('#input-vid').val() +'?rel=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
    content += '</div>';
    tinyMCEPopup.editor.execCommand('mceInsertContent', false, content);
    tinyMCEPopup.close();
}