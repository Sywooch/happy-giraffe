CKEDITOR.plugins.add('othertext', {
    requires:[ 'styles' ],

    init:function (editor) {
        editor.ui.add('othertext', editor.UI_othertext, {});
        editor.ui.addHandler(editor.UI_othertext, {create:function () {
                return{render:function (r, s) {
                    s.push('<span class="cke_othertext" role="separator">Добавить:</span>');
                    return{};
                }};
            }});
    }
});