var selected_keydown = null;
var Comment = {
    seleted_text : null,
    save_url : null,
    moveForm : function(container) {
        $('#add_comment').appendTo(container).show();
    },
    newComment : function()
    {
        this.cancel();
        this.moveForm($('#new_comment_wrapper'));
    },
    clearVariables : function() {
        CKEDITOR.instances['Comment[text]'].setData('');
        Comment.clearResponse();
        Comment.clearQuote();
        $('#edit-id').val('');
    },
    response : function(link) {
        this.clearVariables();
        this.selected_text = null;
        this.moveForm($(link).parents('.item'));
        var id = $(link).parents('.item:eq(0)').attr('id').split('_')[1];
        var text = $(link).parents('.item:eq(0)').find('.user .username').text();
        $('#add_comment').find('.response input').val(id);
    },
    clearResponse : function() {
        $('#add_comment').find('.response input').val('');
    },
    quote : function(link) {
        this.clearVariables();
        this.moveForm($(link).parents('.item'));
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
            url += '#cp_' + index.toString();
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
    edit : function(button) {
        this.clearVariables();
        this.selected_text = null;

        this.moveForm($(button).parents('.item'));

        var id = $(button).parents('.item').attr('id').replace(/comment_/g, '');
        $('#edit-id').val(id);
        var editor = CKEDITOR.instances['Comment[text]'];

        if($(button).parents('.item').find('.quote').size() > 0)
        {
            var html = '';
            html += '<div class="quote">'+$(button).parents('.item').find('.quote').html()+'</div>';
            html += $(button).parents('.item').find('.content-in').html();
            editor.setData(html);
            $('#add_comment').find('.quote #Comment_quote_id').val($(button).parents('.item').find('.quote').attr('id').split('_')[1]);
            $('#add_comment').find('.quote #Comment_selectable_quote').val($(button).parents('.item').find('input[name=selectable_quote]').val());
        }
        else
            editor.setData($(button).parents('.item').find('.content-in').html());
        $('#add_comment .button_panel .btn-green-medium span span').text('Редактировать');

        $('html,body').animate({scrollTop: $('#add_comment').offset().top - 100},'fast');
        return false;
    },
    send : function(form, e) {
        $(form).find('textarea').val(CKEDITOR.instances['Comment[text]'].getData());
        e = e ? e : window.event;
        e.preventDefault();
        $.ajax({
            type: 'POST',
            data: $(form).serialize(),
            dataType: 'json',
            url: Comment.save_url,
            success: function(response) {
                if (response.status == 'ok')
                {
                    var pager = $('#comment_list .yiiPager .page:last');
                    var url = false;
                    if(pager.size() > 0 && $('#add_comment .button_panel .btn-green-medium span span').text() != 'Редактировать')
                        url = pager.children('a').attr('href');
                    if(url !== false)
                        $.fn.yiiListView.update('comment_list', {url : url, data : {lastPage : true}});
                    else if($('#add_comment .button_panel .btn-green-medium span span').text() == 'Редактировать')
                        $.fn.yiiListView.update('comment_list');
                    else
                        $.fn.yiiListView.update('comment_list', {data : {lastPage : true}});
                    var editor = CKEDITOR.instances['Comment[text]'];
                    editor.setData('');
                    Comment.cancel();
                }
            }
        });
        return false;
    },
    cancel : function(e) {
        e = e ? e : window.event;
        if(e)
            e.preventDefault();
        this.clearVariables();
        this.selected_text = null;
        $('#add_comment .button_panel .btn-green-medium span span').text('Добавить');
        $('#edit-id').val('');
        $('#add_comment').hide().appendTo('#new_comment_wrapper');
        return false;
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
