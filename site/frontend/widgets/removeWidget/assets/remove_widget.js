var RemoveWidget = {
    removeConfirm : function(el, author, entity, entity_id, callback, titles) {
        var options = {
            entity : entity,
            entity_id : entity_id,
            callback : callback
        }
        if(author)
            var tmpl_id = 'comment_delete_by_author_tmpl';
        else
            var tmpl_id = 'comment_delete_tmpl';
        $.fancybox.open($('#' + tmpl_id).tmpl([options]));
        $('.popup-confirm span.title0').html(titles[0]);
        $('.popup-confirm span.title1').html(titles[1]);

        return false;
    },
    remove : function(el, callback) {
        var form = $(el).parents('form');

        $.post(form.attr('action'), form.serialize(), function(data) {
            confirmMessage(el, form.serializeArray(), callback);
        });
    }
}