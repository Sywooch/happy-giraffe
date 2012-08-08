var MyLinkCommand = {
    exec:function (editor) {
        var mySelection = editor.getSelection().getSelectedText();
        $.ajax({
            type:'GET',
            url:base_url + '/ajax/link/',
            data:{text:mySelection},
            success:function (data) {
                $.fancybox.open(data);
            },
            async:false
        });
    }
}

function epic_func_mylink(el) {
    var title = $(el).parents('.popup').find('.link-name').val();
    if (!title){

    }
    var href = $(el).parents('.popup').find('.link-address').val();
    var urlRegex = /^((?:http|https):\/\/)?(.*)$/;

    if (href.substring(0, 7) != 'http://' && href.substring(0, 8) != 'https://')
        href = 'http://' + href;

    var urlMatch;
    if (href && ( urlMatch = href.match(urlRegex) )) {
        CKEDITOR.instances[cke_instance].insertHtml('<a href="' + href + '">' + $.trim(title) + '</a> ');
        $.fancybox.close();
    }
}

CKEDITOR.plugins.add('mylink', {
    init:function (editor) {
        var command = editor.addCommand('mylink', MyLinkCommand);
        command.canUndo = true;

        editor.ui.addButton('MyLink', {
            label:'Вставить ссылку',
            command:'mylink',
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