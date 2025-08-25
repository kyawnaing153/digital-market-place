var editorTextarea;
$(function (e) {
"use strict";
ClassicEditor
		.create( document.querySelector( '#theme-editor' ), {
		} )
		.then( editor => {
			editorTextarea = editor;
		} )
		.catch( err => {
		} );
		
});