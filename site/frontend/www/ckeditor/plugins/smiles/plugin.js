var SmilesCommand = {
    exec : function(editor) {
        $.fancybox.open('<div id="wysiwygAddSmile" class="popup">'+
            '<a href="javascript:void(0);" class="popup-close" onclick="$.fancybox.close();">закрыть</a>'+
            '<div class="title">Вставить смайл</div>'+
            '<table>'+
            '<tbody><tr>'+
            '<td><a onclick="epic_func_smile(this);return false;" href=""><img src="/images/widget/smiles/acute.gif"></a></td>'+
            '<td><a onclick="epic_func_smile(this);return false;" href=""><img src="/images/widget/smiles/beach.gif"></a></td>'+
            '<td><a onclick="epic_func_smile(this);return false;" href=""><img src="/images/widget/smiles/beee.gif"></a></td>'+
            '<td><a onclick="epic_func_smile(this);return false;" href=""><img src="/images/widget/smiles/fie.gif"></a></td>'+
            '<td><a onclick="epic_func_smile(this);return false;" href=""><img src="/images/widget/smiles/fool.gif"></a></td>'+
            '</tr>'+
            '<tr>'+
            '<td><a onclick="epic_func_smile(this);return false;" href=""><img src="/images/widget/smiles/help.gif"></a></td>'+
            '<td><a onclick="epic_func_smile(this);return false;" href=""><img src="/images/widget/smiles/mail1.gif"></a></td>'+
            '<td><a onclick="epic_func_smile(this);return false;" href=""><img src="/images/widget/smiles/music2.gif"></a></td>'+
            '<td><a onclick="epic_func_smile(this);return false;" href=""><img src="/images/widget/smiles/pardon.gif"></a></td>'+
            '<td><a onclick="epic_func_smile(this);return false;" href=""><img src="/images/widget/smiles/rofl.gif"></a></td>'+
            '</tr>'+
            '<tr>'+
            '<td><a onclick="epic_func_smile(this);return false;" href=""><img src="/images/widget/smiles/sorry.gif"></a></td>'+
            '<td><a onclick="epic_func_smile(this);return false;" href=""><img src="/images/widget/smiles/tease.gif"></a></td>'+
            '<td><a onclick="epic_func_smile(this);return false;" href=""><img src="/images/widget/smiles/wink.gif"></a></td>'+
            '<td><a onclick="epic_func_smile(this);return false;" href=""><img src="/images/widget/smiles/yes3.gif"></a></td>'+
            '<td><a onclick="epic_func_smile(this);return false;" href=""><img src="/images/widget/smiles/yahoo.gif"></a></td>'+
            '</tr>'+
            '</tbody></table>'+
            '</div>');
    }
}

function epic_func_smile(el){
    var pic = $(el).find('img').attr('src');
    CKEDITOR.instances['Comment_text'].insertHtml('<img src="' + pic + '" />');
    $.fancybox.close();
}

CKEDITOR.plugins.add('smiles', {
    init : function(editor) {
        var command = editor.addCommand('smiles', SmilesCommand);
        command.canUndo = true;

        editor.ui.addButton('Smiles', {
            label : 'Вставить смайлик',
            command : 'smiles'
        });
    }
});