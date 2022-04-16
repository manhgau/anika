// O2k7 skin
tinyMCE.init({
    // General options
    mode : "exact",
    elements : "input-html",
    theme : "advanced",
    skin : "o2k7",
    plugins : "lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",
    relative_urls: false,
    remove_script_host : false,
    content_css: [
            //baseUrl + 'admin/assets/css/editor.css?1'
    ],
    // Theme options
    theme_advanced_buttons1 : "preview,|,link,unlink,anchor,image,cleanup,code",
    //theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "bottom",
    theme_advanced_resizing : true,
    // Example content CSS (should be your site CSS)
    //content_css : "css/content.css",
    // Drop lists for link/image/media/template dialogs
    template_external_list_url : "lists/template_list.js",
    external_link_list_url : "lists/link_list.js",
    external_image_list_url : "lists/image_list.js",
    media_external_list_url : "lists/media_list.js",
    //disable replace domain name in image url
    convert_urls:true,
    relative_urls:false,
    remove_script_host:false,
    // Replace values for the template plugin
    template_replace_values : {
        username : "Some User",
        staffid : "991234"
    }
});