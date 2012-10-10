var galleryCmd =
{
    exec: function( editor )
    {
        var edata = editor.getData();
        var replaced_text = edata.replace('<hr class="gallery" />', '');
        editor.setData(replaced_text);
        editor.insertHtml('<hr class="gallery" />');
    }
};

CKEDITOR.plugins.add('gallery', {
    init : function(editor) {
        var command = editor.addCommand('gallery', galleryCmd);
        command.canUndo = true;

        editor.ui.addButton('Gallery', {
            label : 'Вставить галерею',
            command : 'gallery',
            className : 'cke_button_play'
        });
    }
});