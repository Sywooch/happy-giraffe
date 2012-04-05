var MyLinkCommand = {
    exec : function(editor) {
        var mySelection = editor.getSelection().getSelectedText();
        $.ajax({
            type : 'GET',
            url: base_url + '/site/link/',
            data:{text:mySelection},
            success : function(data) {
                $.fancybox.open(data);
            },
            async : false
        });
    }
}

function epic_func_mylink(el){
    var title = $(el).parents('.popup').find('.link-name').val();
    var href = $(el).parents('.popup').find('.link-address').val();
    CKEDITOR.instances['Comment_text'].insertHtml('<a href="' + href + '">'+ $.trim(title)+'</a> ');
    $.fancybox.close();
}

CKEDITOR.plugins.add('mylink', {
    init : function(editor) {
        var command = editor.addCommand('mylink', MyLinkCommand);
        command.canUndo = true;

        editor.ui.addButton('MyLink', {
            label : 'Вставить ссылку',
            command : 'mylink',
            onRender:function () {
                editor.on('selectionChange', function (ev) {
                     if (ev.data.element.getName() == 'a') {
                        editor.getCommand('mylink').setState(CKEDITOR.TRISTATE_DISABLED);
                        return;
                    }

                    editor.getCommand('mylink').setState(CKEDITOR.TRISTATE_OFF);
                });
            }
        });
    }
});