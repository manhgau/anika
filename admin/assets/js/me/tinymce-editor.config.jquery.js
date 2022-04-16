    // O2k7 skin
    tinyMCE.init({
        // General options
        mode : "exact",
        elements : "tinymce",
        theme : "advanced",
        skin : "o2k7",
        width : '100%',
        height : '500',
        plugins : "lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,iespell,preview,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,visualblocks,xhtmlxtras,template,autosave,contentbox",
        visualblocks_default_state: true,
        relative_urls: false,
        remove_script_host:false,
        content_css: [
            baseUrl + 'admin/assets/css/editor.css?1'
        ],
        // Theme options
        theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,fontselect,fontsizeselect,|,image,sub,sup,|,forecolor,backcolor",
        theme_advanced_buttons2 : "bullist,numlist,blockquote,|,link,unlink,cleanup,removeformat,code,|,preview,|,tablecontrols,|,contentbox",
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