var SmilesCommand = {
    exec : function(editor) {
        cke_instance = editor.name;
        $.fancybox.open($('#wysiwygAddSmile').clone().show());
    }
}
$(function() {
    $('body').delegate('.hg-smiles a', 'click', function(e){
        e.preventDefault();
        set_smile($(this));
    });
    $("body").append('<div id="wysiwygAddSmile" class="popup" style="display: none;">'+
            '<a href="javascript:void(0);" class="popup-close" onclick="$.fancybox.close();">закрыть</a>'+
            '<div class="title">Вставить смайл</div>'+
            '<table class="hg-smiles"><tbody><tr><td><a href=""><img src="/images/widget/smiles/acute (1).gif"></a></td><td><a href=""><img src="/images/widget/smiles/acute.gif"></a></td><td><a href=""><img src="/images/widget/smiles/air_kiss.gif"></a></td><td><a href=""><img src="/images/widget/smiles/angel.gif"></a></td><td><a href=""><img src="/images/widget/smiles/bad.gif"></a></td><td><a href=""><img src="/images/widget/smiles/beach.gif"></a></td><td><a href=""><img src="/images/widget/smiles/beee.gif"></a></td><td><a href=""><img src="/images/widget/smiles/blush2.gif"></a></td></tr><tr><td><a href=""><img src="/images/widget/smiles/Cherna-girl_on_weight.gif"></a></td><td><a href=""><img src="/images/widget/smiles/connie_1.gif"></a></td><td><a href=""><img src="/images/widget/smiles/connie_33.gif"></a></td><td><a href=""><img src="/images/widget/smiles/connie_36.gif"></a></td><td><a href=""><img src="/images/widget/smiles/connie_6.gif"></a></td><td><a href=""><img src="/images/widget/smiles/connie_feedbaby.gif"></a></td><td><a href=""><img src="/images/widget/smiles/cray.gif"></a></td><td><a href=""><img src="/images/widget/smiles/dance.gif"></a></td></tr><tr><td><a href=""><img src="/images/widget/smiles/dash2.gif"></a></td><td><a href=""><img src="/images/widget/smiles/diablo.gif"></a></td><td><a href=""><img src="/images/widget/smiles/dirol.gif"></a></td><td><a href=""><img src="/images/widget/smiles/dntknw.gif"></a></td><td><a href=""><img src="/images/widget/smiles/drinks.gif"></a></td><td><a href=""><img src="/images/widget/smiles/d_coffee.gif"></a></td><td><a href=""><img src="/images/widget/smiles/d_lovers.gif"></a></td><td><a href=""><img src="/images/widget/smiles/facepalm.gif"></a></td></tr><tr><td><a href=""><img src="/images/widget/smiles/fie.gif"></a></td><td><a href=""><img src="/images/widget/smiles/first_move.gif"></a></td><td><a href=""><img src="/images/widget/smiles/fool.gif"></a></td><td><a href=""><img src="/images/widget/smiles/girl_cray2.gif"></a></td><td><a href=""><img src="/images/widget/smiles/girl_dance.gif"></a></td><td><a href=""><img src="/images/widget/smiles/girl_drink1.gif"></a></td><td><a href=""><img src="/images/widget/smiles/girl_hospital.gif"></a></td><td><a href=""><img src="/images/widget/smiles/girl_prepare_fish.gif"></a></td></tr><tr><td><a href=""><img src="/images/widget/smiles/girl_sigh.gif"></a></td><td><a href=""><img src="/images/widget/smiles/girl_wink.gif"></a></td><td><a href=""><img src="/images/widget/smiles/girl_witch.gif"></a></td><td><a href=""><img src="/images/widget/smiles/give_rose.gif"></a></td><td><a href=""><img src="/images/widget/smiles/good.gif"></a></td><td><a href=""><img src="/images/widget/smiles/help.gif"></a></td><td><a href=""><img src="/images/widget/smiles/JC_hiya.gif"></a></td><td><a href=""><img src="/images/widget/smiles/JC_hulahoop-girl.gif"></a></td></tr><tr><td><a href=""><img src="/images/widget/smiles/kirtsun_05.gif"></a></td><td><a href=""><img src="/images/widget/smiles/kuzya_01.gif"></a></td><td><a href=""><img src="/images/widget/smiles/LaieA_052.gif"></a></td><td><a href=""><img src="/images/widget/smiles/Laie_16.gif"></a></td><td><a href=""><img src="/images/widget/smiles/Laie_50.gif"></a></td><td><a href=""><img src="/images/widget/smiles/Laie_7.gif"></a></td><td><a href=""><img src="/images/widget/smiles/lazy2.gif"></a></td><td><a href=""><img src="/images/widget/smiles/l_moto.gif"></a></td></tr><tr><td><a href=""><img src="/images/widget/smiles/mail1.gif"></a></td><td><a href=""><img src="/images/widget/smiles/Mauridia_21.gif"></a></td><td><a href=""><img src="/images/widget/smiles/mosking.gif"></a></td><td><a href=""><img src="/images/widget/smiles/music2.gif"></a></td><td><a href=""><img src="/images/widget/smiles/negative.gif"></a></td><td><a href=""><img src="/images/widget/smiles/pardon.gif"></a></td><td><a href=""><img src="/images/widget/smiles/phil_05.gif"></a></td><td><a href=""><img src="/images/widget/smiles/phil_35.gif"></a></td></tr><tr><td><a href=""><img src="/images/widget/smiles/popcorm1.gif"></a></td><td><a href=""><img src="/images/widget/smiles/preved.gif"></a></td><td><a href=""><img src="/images/widget/smiles/rofl.gif"></a></td><td><a href=""><img src="/images/widget/smiles/sad.gif"></a></td><td><a href=""><img src="/images/widget/smiles/scratch_one-s_head.gif"></a></td><td><a href=""><img src="/images/widget/smiles/secret.gif"></a></td><td><a href=""><img src="/images/widget/smiles/shok.gif"></a></td><td><a href=""><img src="/images/widget/smiles/smile3.gif"></a></td></tr><tr><td><a href=""><img src="/images/widget/smiles/sorry.gif"></a></td><td><a href=""><img src="/images/widget/smiles/tease.gif"></a></td><td><a href=""><img src="/images/widget/smiles/to_become_senile.gif"></a></td><td><a href=""><img src="/images/widget/smiles/viannen_10.gif"></a></td><td><a href=""><img src="/images/widget/smiles/wacko2.gif"></a></td><td><a href=""><img src="/images/widget/smiles/wink.gif"></a></td><td><a href=""><img src="/images/widget/smiles/yahoo.gif"></a></td><td><a href=""><img src="/images/widget/smiles/yes3.gif"></a></td></tr><tr></tr></tbody></table>'+
            '</div>');
    
});
function set_smile(el){
    var pic = el.find('img').attr('src');
    CKEDITOR.instances[cke_instance].insertHtml('<img class="smile" src="' + pic + '" />');
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