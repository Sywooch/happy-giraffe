var selected_keydown = null;
var Comment = {
    seleted_text : null,
    response : function(link) {
        Comment.clearResponse();
        Comment.clearQuote();
        var id = $(link).parents('.item:eq(0)').attr('id').split('_')[1];
        var text = $(link).parents('.item:eq(0)').find('.user .username').text();
        $('#add_comment').find('.response input').val(id);
    },
    clearResponse : function() {
        $('#add_comment').find('.response input').val('');
    },
    quote : function(link) {
        Comment.clearResponse();
        Comment.clearQuote();
        var id = $(link).parents('.item:eq(0)').attr('id').split('_')[1];
        if(!this.selected_text) {
            var text = $(link).parents('.item:eq(0)').find('.content-in').html();
        } else {
            $('#add_comment').find('.quote #Comment_selectable_quote').val(1);
            var text = this.selected_text;
        }
        $('#add_comment').find('.quote #Comment_quote_id').val(id);
        CKEDITOR.instances['Comment[text]'].setData('<div class="quote">'+text+'</div><p></p>');
        this.selected_text = null;
    },
    clearQuote : function() {
        $('#add_comment').find('.quote #Comment_quote_id').val('');
        $('#add_comment').find('.quote #Comment_selectable_quote').val(0);
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
        $.fn.yiiListView.update('comment_list');
    },
    getText : function()
    {
        var txt = '';
        if (txt = window.getSelection) {
            txt = window.getSelection().toString();
        } else {
            txt = document.selection.createRange().text;
        }
        if(txt != '') {
            var pattern = /\r\n|\r|\n/g;
            txt = txt.replace(pattern, "<br/>");
        }
        this.selected_text = txt != '' ? txt : null;
    }
}

$(function() {
    $('.default-comments').delegate('.content-in', 'mousedown', function() {
        selected_keydown = $(this);
    });
    $('.default-comments').delegate('.content-in', 'mouseup', function() {
        if(selected_keydown && $(this).parents('li:eq(0)').attr('id') == selected_keydown.parents('li:eq(0)').attr('id'))
            Comment.getText();
        selected_keydown = null;
    });
    $(document).mouseup(function(e) {
        e = e ? e : windows.event;
        if($(e.target).parents('.default-comments').size() == 0) {
            Comment.selected_text = null;
            selected_keydown = null;
        }
    });
});
