var AttachCommand = {
    exec : function(editor) {
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
        var command = editor.addCommand('attach', AttachCommand);
        command.canUndo = true;

        CKEDITOR.dialog.add( 'attach', this.path + 'dialog.js' );

        editor.ui.addButton('Attach', {
            label : 'Вставить изображение',
            command : 'attach',
            icon: '/ckeditor/plugins/attach/images/attach.png'
        });
    },
    afterInit : function(editor) {
        delete editor._.menuItems.image;
    }
});