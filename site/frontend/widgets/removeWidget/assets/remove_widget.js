var RemoveWidget = {
    removeConfirm : function(el, author, entity, entity_id) {
        var options = {
            entity : entity,
            entity_id : entity_id
        }
        if(author)
            var tmpl_id = 'comment_delete_by_author_tmpl';
        else
            var tmpl_id = 'comment_delete_tmpl';
        $.fancybox.open($('#' + tmpl_id).tmpl([options]));
        return false;
    }
}