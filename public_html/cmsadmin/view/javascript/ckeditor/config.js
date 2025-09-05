/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
	config.entities_greek = false;
	config.extraPlugins = 'codemirror';
	config.codemirror_theme = 'monokai';//erlang-dark, monokai, rubyblue, twilight, xq-dark 
	//config.codemirror = {
	//	theme: 'monokai'
	//};
	// Remove multiple plugins.
	config.removePlugins = 'about,forms,smiley,specialchar';
	// console.log(config.plugins);

};
