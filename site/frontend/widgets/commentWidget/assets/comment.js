var Comment = {
    response : function(link) {
        Comment.clearResponse();
        var id = $(link).parents('.item:eq(0)').attr('id').split('_')[1];
        var text = $(link).parents('.text:eq(0)').find('.comment-content').clone();
        text.append('<a href="javascript:void(0);" onclick="Comment.clearResponse();">Отменить цитирование</a>');
        $('#add_comment').find('.quote input').val(id);
        $('#add_comment').find('.quote .text').html(text);
        return false;
    },
    clearResponse : function() {
        $('#add_comment').find('.quote input').val('');
        $('#add_comment').find('.quote .text').empty();
    },
    goTo : function() {
        var h = new AjaxHistory('yw0');
        var url = 'http://happyfront/community/2/forum/post/447/?Comment_page=3';
        h.load('yw0', url).changeBrowserUrl(url);
    }
}