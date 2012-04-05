var MyLinkCommand = {
    exec : function(editor) {
        $.ajax({
            type : 'GET',
            url: base_url + '/site/link/',
            success : function(data) {
                $.fancybox.open(data);
            },
            async : false
        });
    }
}

CKEDITOR.plugins.add('mylink', {
    init : function(editor) {
        var command = editor.addCommand('mylink', MyLinkCommand);
        command.canUndo = true;

        CKEDITOR.dialog.add( 'mylink', this.path + 'dialog.js' );

        editor.ui.addButton('MyLink', {
            label : 'Вставить ссылку',
            command : 'mylink'
        });
    }
});