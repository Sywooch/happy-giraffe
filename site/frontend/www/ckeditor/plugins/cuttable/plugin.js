var moreCmd =
{
	exec: function( editor )
	{
		editor.insertHtml('<hr class="cuttable" />');
	}
};

CKEDITOR.plugins.add('cuttable', {
	init : function(editor) {
		var command = editor.addCommand('cuttable', moreCmd);
		command.canUndo = true;

		editor.ui.addButton('Cuttable', {
			label : 'Убрать под Cut',
			command : 'cuttable',
			icon: '/ckeditor/plugins/cuttable/images/cuttable.png'
		});

		CKEDITOR.dialog.add('cuttable', this.path + 'dialogs/cuttable.js');
	}
});