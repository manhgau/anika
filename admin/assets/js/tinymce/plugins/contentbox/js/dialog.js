tinyMCEPopup.requireLangPack();

var ContentboxDialog = {
	init : function() {
		var f = document.forms[0];

		// Get the selected contents as text and place it in the input
		f.someval.value = tinyMCEPopup.editor.selection.getContent({format : 'text'});
		f.somearg.value = tinyMCEPopup.getWindowArg('some_custom_arg');
	},

	insert : function() {
		// Insert the contents from the input into the document
		tinyMCEPopup.editor.execCommand('mceInsertContent', false, document.forms[0].someval.value);
		tinyMCEPopup.close();
	}
};

tinyMCEPopup.onInit.add(ContentboxDialog.init, ContentboxDialog);

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