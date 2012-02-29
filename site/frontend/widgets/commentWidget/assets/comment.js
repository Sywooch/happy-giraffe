var Comment = {
    response : function(link) {
        Comment.clearResponse();
        Comment.clearQuote();
        var id = $(link).parents('.item:eq(0)').attr('id').split('_')[1];
        var text = $(link).parents('.item:eq(0)').find('.user .username').text();
        $('#add_comment').find('.response input').val(id);
        $('#add_comment').find('.response .text').html(text);
        return false;
    },
    clearResponse : function() {
        $('#add_comment').find('.response input').val('');
        $('#add_comment').find('.response .text').empty();
    },
    quote : function(link) {
        Comment.clearResponse();
        Comment.clearQuote();
        var id = $(link).parents('.item:eq(0)').attr('id').split('_')[1];
        var text = $(link).parents('.item:eq(0)').find('.comment-content').html();
        $('#add_comment').find('.quote input').val(id);
        $('#add_comment').find('.quote .text').html(text);
        return false;
    },
    clearQuote : function() {
        $('#add_comment').find('.quote input').val('');
        $('#add_comment').find('.quote .text').empty();
    },
    goTo : function() {
        var h = new AjaxHistory('yw0');
        var url = 'http://happyfront/community/2/forum/post/447/?Comment_page=3';
        h.load('yw0', url).changeBrowserUrl(url);
    }
}