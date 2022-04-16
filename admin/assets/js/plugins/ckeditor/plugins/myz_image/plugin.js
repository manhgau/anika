CKEDITOR.plugins.add( 'myz_image', {
    icons: 'myz_image',
    init: function( editor ) {
        editor.addCommand( 'myz_image',
    	{
    		exec : function( editor )
    		{    
		       var w=400,
                   h=300,
                   title='Form upload image',
                   url='http://localhost/ci_cms/admin/upload',
                   left = (screen.width/2)-(w/2),
                   top = (screen.height/2)-(h/2);
               window.open(url, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
    		}
    	});
        editor.ui.addButton( 'Myz_image', {
            label: 'Insert Image by Myz',
            command: 'myz_image',
            toolbar: 'insert,0'
        });
    }    
});