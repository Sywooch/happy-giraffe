var AttachCommand = {
    exec : function(editor) {
        $.ajax({
            type : 'GET',
            url: base_url + '/albums/attach/entity/Comment/entity_id/',
            success : function(data) {
                $.fancybox.open(data);
            },
            async : false
        });
    }
}

CKEDITOR.plugins.add('attach', {
    init : function(editor) {
        var command = editor.addCommand('attach', AttachCommand);
        command.canUndo = true;

        CKEDITOR.dialog.add( 'attach', this.path + 'dialog.js' );

        editor.ui.addButton('Attach', {
            label : 'Вставить фото',
            command : 'attach',
            icon: '/ckeditor/plugins/attach/images/attach.png'
        });
    }
});