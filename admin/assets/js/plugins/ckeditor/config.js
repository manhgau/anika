/**
 * @license Copyright (c) 2003-2013, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For the complete reference:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config
    config.height = 400;

	// The toolbar groups arrangement, optimized for two toolbar rows.
	config.toolbarGroups = [
		{ name: 'clipboard',   groups: [ 'clipboard', 'undo', 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-' , 'Redo' ] },
		{ name: 'editing',     groups: [ 'find', 'selection', 'spellchecker' ] },        
        { name: 'paragraph', groups : [ 'NumberedList','BulletedList','-','Outdent','Indent','-','Blockquote','CreateDiv',
    '-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock','-','BidiLtr','BidiRtl' ] },
		{ name: 'links' },
		{ name: 'insert' , },
		{ name: 'forms' ,groups:[ 'Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 
        'HiddenField' ]},
        { name: 'tools' },
		{ name: 'document',	   groups: [ 'mode', 'document', 'doctools', 'Source', '-', 'NewPage', 'Preview', '-', 'Templates' ] },
		{ name: 'others' },
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' , 'Bold', 'Italic'  ] },
		{ name: 'styles' , groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: 'colors' },
		{ name: 'about' }
	];

	// Remove some buttons, provided by the standard plugins, which we don't
	// need to have in the Standard(s) toolbar.
	config.removeButtons = 'Underline,Subscript,Superscript';

	// Se the most common block elements.
	config.format_tags = 'p;h1;h2;h3;pre';

	// Make dialogs simpler.
	config.removeDialogTabs = 'image:advanced;link:advanced';
    
    //config.extraPlugins= 'abbr,myz_image';
    config.extraPlugins= '';
};
