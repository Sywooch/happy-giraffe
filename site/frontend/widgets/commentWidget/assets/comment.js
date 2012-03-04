var Comment = {
    response : function(link) {
        Comment.clearResponse();
        Comment.clearQuote();
        var id = $(link).parents('.item:eq(0)').attr('id').split('_')[1];
        var text = $(link).parents('.item:eq(0)').find('.user .username').text();
        $('#add_comment').find('.response input').val(id);
        $('#add_comment').find('.response .text').html(text);
    },
    clearResponse : function() {
        $('#add_comment').find('.response input').val('');
        $('#add_comment').find('.response .text').empty();
    },
    quote : function(link) {
        Comment.clearResponse();
        Comment.clearQuote();
        var id = $(link).parents('.item:eq(0)').attr('id').split('_')[1];
        var text = $(link).parents('.item:eq(0)').find('.content-in').html();
        $('#add_comment').find('.quote input').val(id);
        $('#add_comment').find('.quote .text').html(text);
    },
    clearQuote : function() {
        $('#add_comment').find('.quote input').val('');
        $('#add_comment').find('.quote .text').empty();
    },
    goTo : function(index, currentPage) {
        var page = Math.ceil(index / 10);
        if(page != currentPage) {
            var pager = $('#comment_list .yiiPager .page:eq(' + (page - 1) + ')');
            var url = false;
            if(pager.size() > 0)
                url = pager.children('a').attr('href');
            url += '#comment_' + index.toString();
            var h = new AjaxHistory('comment_list');
            h.load('comment_list', url).changeBrowserUrl(url);
        } else {
            document.location.hash = '#cp_' + index.toString();
        }
        return false;
    },
    remove : function(el) {
        var form = $(el).parents('form');
        $.post(form.attr('action'), form.serialize(), function() {
            $.fn.yiiListView.update('comment_list');
        })
    }
}