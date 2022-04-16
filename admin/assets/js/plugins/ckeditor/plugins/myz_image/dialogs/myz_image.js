CKEDITOR.dialog.add( 'myz_imageDialog', function( editor )  
{  
   return {   
        title : 'Add a image',   
        minWidth : 400,   
        minHeight : 200,   
        contents :    
        [   
            {   
                id : 'addImage',   
                label : 'Add image',   
                title : 'Add image',   
                filebrowser : 'uploadButton',   
                elements :   
                [ 
                  {
                      type: 'html',
                      html: '<form name="formUpload" action="http://localhost/ci_cms/admin/upload" method="post" enctype="multipart/form-data" id="form-upload"><input type="file" name="fileUpload" id="imgUpload" size="38" /><input type="button" name="button" value="Upload" onclick="UploadFile();" /></form><div id="previewFile" style="background-color:#ccc;width:180px;height:180px"></div>'
                  } 
                ]   
            }   
       ], 
   
       onOk : function(){ 
       }   
   };  
} );  


function UploadFile() {
    var file = $('#imgUpload').val();
    $.ajax({
        url: 'http://localhost/ci_cms/admin/upload',
        type : 'post',
        dataType : 'html',
        data:  {
            imgUpload : file
        },
        success: function(d){
            $('#previewFile').html(d);
        }
    });
    
    return false;
}


/*CKEDITOR.dialog.add( 'myz_imageDialog', function( editor ) {
    return {
        title: 'Thêm hình ảnh cho bài viết',
        minWidth: 500,
        minHeight: 300,
        contents: [
            {
                id: 'tab1',
                label: 'Select Image From Your Computer',
                elements: [
                    {
                        type: 'file',
                        id: 'upload',
                        label: editor.lang.common.upload,
                        size: 40,
                        //validate: CKEDITOR.dialog.validate.notEmpty( "Abbreviation field cannot be empty." )
                    },
                    {
                    	type : 'fileButton',
                    	id : 'fileId',
                    	label: editor.lang.common.uploadSubmit,                  	
                    	filebrowser : {
      	                    action: 'QuickUpload',
                            params: { type: 'Files', currentFolder: '/folder/' },
                            target: 'tab1:upload',
                    		onSelect : function( fileUrl, data ) {
                    			alert( 'Successfully uploaded: ' + fileUrl );
                                //alert('yuplaod nahd demo');
                    		}                            
                    	},
                        'for' : [ 'tab1', 'upload' ],
                    }
                ]
            }
        ],
        onOk: function() {
            var dialog = this;
            var content = editor.document.createElement( 'abbr' );
            abbr.setAttribute( 'title', dialog.getValueOf( 'tab-basic', 'title' ) );
            abbr.setText( dialog.getValueOf( 'tab-basic', 'abbr' ) );
            var id = dialog.getValueOf( 'tab-adv', 'id' );
            if ( id )
                abbr.setAttribute( 'id', id );
                editor.insertElement( abbr );
        }
    };
});*/