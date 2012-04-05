var AverageHeaderCommand = {
    exec:function (editor) {
        editor.focus();
        editor.fire('saveSnapshot');
        console.log('111');

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
                        var currentTag = this.getValue();
                        var elementPath = ev.data.path;
                        var style = new CKEDITOR.style(config[ 'format_h2' ])
                        style._.enterMode = editor.config.enterMode;
                        console.log('222');

                        if (style.checkActive(elementPath)) {
                            if ('h2' != currentTag)
                                this.setValue('h2', editor.lang.format[ 'tag_' + 'h2' ]);
                            return;
                        }

                        // If no styles match, just empty it.
                        this.setValue('');
                    },
                    this);
            }
        });
    }
});