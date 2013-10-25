var galleryCmd =
{
    exec: function( editor )
    {
        var html = '<hr class="gallery" />';
        if (editor.getData().indexOf(html) == -1) {
            editor.insertHtml(html);
        } else {
            alert('В тексте может быть только одна галерея.');
        }
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