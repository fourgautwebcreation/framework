/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here.
	// For complete reference see:
	// http://docs.ckeditor.com/#!/api/CKEDITOR.config

	// The toolbar groups arrangement, optimized for a single toolbar row.
	/*
	config.toolbarGroups = [
		{ name: '',	   groups: [ 'mode', 'document', 'doctools' ] },
		{ name: '',   groups: [ 'clipboard', 'undo' ] },
		{ name: '',     groups: [ 'find', 'selection', 'spellchecker' ] },
		{ name: '', groups : ['Link','Unlink','Anchor'] },
		{ name: '', groups: [ 'basicstyles', 'cleanup' ] },
		{ name: '',   groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ] },
		{ name: '' },
		{ name: '' },
		{ name: '' },
		{ name: '' },
		{ name: '' },
		{ name: '' },
		{ name: '' }
	];
*/
	config.toolbar = [
   ['Styles','Format','Font','FontSize'],
   '/',
   ['Bold','Italic','Underline','StrikeThrough','-','Undo','Redo','-','Cut','Copy','Paste','Find','Replace','-','Outdent','Indent','-','Print'],
   '/',
   ['NumberedList','BulletedList','-','JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
   ['Image','Table','-','Link','Flash','Smiley','TextColor','BGColor','Source']
] ;

	// The default plugins included in the basic setup define some buttons that
	// are not needed in a basic editor. They are removed here.
	config.removeButtons = 'Cut,Copy,Paste,Undo,Redo,Underline,Strike,Subscript,Superscript';

};
