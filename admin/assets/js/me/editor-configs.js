tinyMCE.init({
    // General options
    mode : "exact",
    elements : "tinymce1",
    theme : "advanced",
    width : '100%',
    height : '400',
    skin : "o2k7",
    plugins : "lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave",
    relative_urls: false,
    remove_script_host : false,
    content_css: [
        baseUrl + 'admin/assets/css/editor.css?1'
    ],
    // Theme options
    theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
    theme_advanced_buttons2 : "bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,anchor,image,cleanup,code,|,insertdate,preview,|,forecolor,backcolor,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,nonbreaking,pagebreak",
    theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen,|,contentbox",
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

tinyMCE.init({
        // General options
    mode : "exact",
    elements : "tinymce",
    theme : "advanced",
    skin : "o2k7",
    width : '100%',
    height : '400',
    plugins : "lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave,contentbox",
    relative_urls: false,
    remove_script_host :false,
    content_css: [
        baseUrl + 'admin/assets/css/editor.css?1'
    ],
    // Theme options
    theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
    theme_advanced_buttons2 : "bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,anchor,image,cleanup,code,|,insertdate,preview,|,forecolor,backcolor,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,nonbreaking,pagebreak",
    theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen,|,contentbox",
    theme_advanced_buttons4 : "",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "bottom",
    theme_advanced_resizing : true,
    //allow iframe tag in the content
    extended_valid_elements: "iframe[class|src|frameborder=0|alt|title|width|height|align|name]",
    // Example content CSS (should be your site CSS)
    //content_css : "css/content.css",
    // Drop lists for link/image/media/template dialogs
    template_external_list_url : "lists/template_list.js",
    external_link_list_url : "lists/link_list.js",
    external_image_list_url : "lists/image_list.js",
    media_external_list_url : "lists/media_list.js",
    // Replace values for the template plugin
    template_replace_values : {
        username : "Some User",
        staffid : "991234"
    }
});
tinyMCE.init({
        // General options
    mode : "exact",
    elements : "editor-2",
    theme : "advanced",
    skin : "o2k7",
    width : '100%',
    plugins : "lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave,contentbox",
    relative_urls: false,
    remove_script_host :false,
    content_css: [
        baseUrl + 'admin/assets/css/editor.css?1'
    ],
    // Theme options
    theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
    // theme_advanced_buttons2 : "bullist,numlist,|,outdent,indent,blockquote,|,link,unlink,anchor,image,cleanup,code,|,insertdate,preview,|,forecolor,backcolor,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,nonbreaking,pagebreak",
    // theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen,|,contentbox",
    // theme_advanced_buttons4 : "",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "bottom",
    theme_advanced_resizing : true,
    //allow iframe tag in the content
    extended_valid_elements: "iframe[class|src|frameborder=0|alt|title|width|height|align|name]",
    // Example content CSS (should be your site CSS)
    //content_css : "css/content.css",
    // Drop lists for link/image/media/template dialogs
    template_external_list_url : "lists/template_list.js",
    external_link_list_url : "lists/link_list.js",
    external_image_list_url : "lists/image_list.js",
    media_external_list_url : "lists/media_list.js",
    // Replace values for the template plugin
    template_replace_values : {
        username : "Some User",
        staffid : "991234"
    }
});
tinyMCE.init({
        // General options
    mode : "exact",
    elements : "editor-3",
    theme : "advanced",
    skin : "o2k7",
    plugins : "lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave,contentbox",
    relative_urls: false,
    remove_script_host :false,
    content_css: [
        baseUrl + 'admin/assets/css/editor.css?1'
    ],
    // Theme options
    theme_advanced_buttons1 : "bold,italic,underline,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,styleselect",
    theme_advanced_buttons2 : "formatselect,fontselect,fontsizeselect",
    // theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen,|,contentbox",
    // theme_advanced_buttons4 : "",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "bottom",
    theme_advanced_resizing : true,
    //allow iframe tag in the content
    extended_valid_elements: "iframe[class|src|frameborder=0|alt|title|width|height|align|name]",
    // Example content CSS (should be your site CSS)
    //content_css : "css/content.css",
    // Drop lists for link/image/media/template dialogs
    template_external_list_url : "lists/template_list.js",
    external_link_list_url : "lists/link_list.js",
    external_image_list_url : "lists/image_list.js",
    media_external_list_url : "lists/media_list.js",
    // Replace values for the template plugin
    template_replace_values : {
        username : "Some User",
        staffid : "991234"
    }
});
tinyMCE.init({
        // General options
    mode : "exact",
    elements : "editor-4",
    theme : "advanced",
    skin : "o2k7",
    plugins : "lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,inlinepopups,autosave,contentbox",
    relative_urls: false,
    remove_script_host :false,
    content_css: [
        baseUrl + 'admin/assets/css/editor.css?1'
    ],
    // Theme options
    theme_advanced_buttons1 : "bold,italic,underline,strikethrough,justifyleft,justifycenter,justifyright,justifyfull,styleselect",
    theme_advanced_buttons2 : "formatselect,fontselect,fontsizeselect",
    // theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen,|,contentbox",
    // theme_advanced_buttons4 : "",
    theme_advanced_toolbar_location : "top",
    theme_advanced_toolbar_align : "left",
    theme_advanced_statusbar_location : "bottom",
    theme_advanced_resizing : true,
    //allow iframe tag in the content
    extended_valid_elements: "iframe[class|src|frameborder=0|alt|title|width|height|align|name]",
    // Example content CSS (should be your site CSS)
    //content_css : "css/content.css",
    // Drop lists for link/image/media/template dialogs
    template_external_list_url : "lists/template_list.js",
    external_link_list_url : "lists/link_list.js",
    external_image_list_url : "lists/image_list.js",
    media_external_list_url : "lists/media_list.js",
    // Replace values for the template plugin
    template_replace_values : {
        username : "Some User",
        staffid : "991234"
    }
});