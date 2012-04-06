var AverageHeaderCommand = {
    exec:function (editor) {
        editor.focus();
        editor.fire('saveSnapshot');

        var config = editor.config;
        var style = new CKEDITOR.style(config[ 'format_h2' ]),
            elementPath = new CKEDITOR.dom.elementPath(editor.getSelection().getStartElement());
        style._.enterMode = editor.config.enterMode;

        style[ style.checkActive(elementPath) ? 'remove' : 'apply' ](editor.document);

        setTimeout(function () {
            editor.fire('saveSnapshot');
        }, 0);
    }
}

CKEDITOR.plugins.add('avarageheader', {
    requires:[ 'styles' ],

    init:function (editor) {
        var command = editor.addCommand('avarageheader', AverageHeaderCommand);
        command.canUndo = true;

        editor.ui.addButton('Avarageheader', {
            label:'Средний заголовок',
            command:'avarageheader',
            onRender:function () {
                editor.on('selectionChange', function (ev) {
                    for(var i = 0; i < ev.data.path.elements.length; i++){
                        var tag = ev.data.path.elements[i].getName();
                        if (tag == 'h2') {
                            editor.getCommand('avarageheader').setState(CKEDITOR.TRISTATE_ON);
                            return;
                        }
                    }

                    editor.getCommand('avarageheader').setState(CKEDITOR.TRISTATE_OFF);
                });
            }
        });
    }
});