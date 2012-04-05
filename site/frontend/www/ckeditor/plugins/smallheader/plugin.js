var SmallHeaderCommand = {
    exec : function(editor) {
        editor.focus();
        editor.fire( 'saveSnapshot' );

        var config = editor.config;
        var style = new CKEDITOR.style( config[ 'format_h3' ] ),
            elementPath = new CKEDITOR.dom.elementPath( editor.getSelection().getStartElement() );

        style[ style.checkActive( elementPath ) ? 'remove' : 'apply' ]( editor.document );

        setTimeout( function()
        {
            editor.fire( 'saveSnapshot' );
        }, 0 );
    }
}

CKEDITOR.plugins.add('smallheader', {
    requires : [ 'styles' ],

	init : function(editor) {
        var command = editor.addCommand('smallheader', SmallHeaderCommand);
        command.canUndo = true;

        editor.ui.addButton('SmallHeader', {
			label : 'Средний заголовок',
			command : 'smallheader'
		});
	}
});