/*
Copyright (c) 2003-2011, CKSource - Frederico Knabben. All rights reserved.
For licensing, see LICENSE.html or http://ckeditor.com/license
*/

CKEDITOR.editorConfig = function( config )
{
	CKEDITOR.lang.languages['ru-hg'] = 1;
	config.language = 'ru-hg';
	
	config.filebrowserBrowseUrl = '/ckfinder/ckfinder.html';
	config.filebrowserImageBrowseUrl = '/ckfinder/ckfinder.html?Type=Images';
	config.filebrowserFlashBrowseUrl = '/ckfinder/ckfinder.html?Type=Flash';
	config.filebrowserUploadUrl = '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files';
	config.filebrowserImageUploadUrl = '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images';
	config.filebrowserFlashUploadUrl = '/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash';
	
	config.extraPlugins = 'cuttable';
	
	config.toolbar = 'Main';

	config.toolbar_Main =
	[
		{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike', ] },
		{ name: 'styles', items : [ 'Format','Font' ] },
		{ name: 'colors', items : [ 'TextColor','BGColor' ] },
		{ name: 'clipboard', items : [ 'Copy','Paste','-','Undo','Redo' ] },
		'/',
		{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent' ] },
		{ name: 'links', items : [ 'Link','Unlink' ] },
		{ name: 'insert', items : [ 'Image' ] },
		{ name: 'document', items : [ 'Source' ] },
		{ name: 'cut', items : [ 'Cuttable' ] },
	];

    config.toolbar_Chat =
        [
            { name: 'basicstyles', items : [ 'Bold','Italic','Underline' ] },
        ];
	
	config.toolbar_Nocut =
	[
		{ name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike', ] },
		{ name: 'styles', items : [ 'Format','Font' ] },
		{ name: 'colors', items : [ 'TextColor','BGColor' ] },
		{ name: 'clipboard', items : [ 'Copy','Paste','-','Undo','Redo' ] },
		'/',
		{ name: 'paragraph', items : [ 'NumberedList','BulletedList','-','Outdent','Indent' ] },
		{ name: 'links', items : [ 'Link','Unlink' ] },
		{ name: 'insert', items : [ 'Image' ] },
		{ name: 'document', items : [ 'Source' ] },
	];
	
	CKEDITOR.config.format_tags = 'psmall;p;pbig;h2;h3';
	config.format_psmall = { element : 'p', attributes : { 'style' : 'font-size: 10px;' } };
	config.format_pbig = { element : 'p', attributes : { 'style' : 'font-size: 14px;' } };
};