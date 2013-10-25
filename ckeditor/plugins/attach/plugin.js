var AttachCommand = {
    exec : function(editor) {
        cke_instance = editor.name;
        $.ajax({
            type : 'GET',
            url: $('.upload-btn a.btn').attr('href'),
            success : function(data) {
                $.fancybox.open(data);
            },
            async : false
        });
    }
}

CKEDITOR.plugins.add('attach', {
    init : function(editor) {
        //cke_instance = editor.name;
        var command = editor.addCommand('attach', AttachCommand);
        command.canUndo = true;

        CKEDITOR.dialog.add( 'attach', this.path + 'dialog.js' );

        editor.ui.addButton('Attach', {
            label : 'Вставить изображение',
            command : 'attach'
        });
    },
    afterInit : function(editor) {
        delete editor._.menuItems.image;
    }
});