var selected_keydown = null;
var Comment;
Comment = {
    seleted_text:null,
    save_url:null,
    toolbar:null,
    saveCommentUrl:null,
    entity:null,
    entity_id:null,
    setParams:function(params) {
        for(var n in params) {
            if(typeof(this[n]) != undefined)
                this[n] = params[n];
        }
    },
    getInstance:function () {
        var instance = CKEDITOR.instances['Comment_text'];
        if (instance)
            return instance;
        return false;
    },
    createInstance:function () {
        var instance = this.getInstance();
        if (instance) {
            instance.destroy(true);
        }
        CKEDITOR.replace('Comment_text', {toolbar:this.toolbar});
    },
    moveForm:function (container) {
        var instance = this.getInstance();
        if (instance)
            instance.destroy(true);
        var form = $('#add_comment').clone(true);
        $('#add_comment').remove();
        form.appendTo(container).show();
        this.createInstance();
    },
    newComment:function (event) {
        this.cancel();
        this.moveForm($('#new_comment_wrapper'));
    },
    newPhotoComment:function (event) {
        this.cancel();
        Attach.attachGuestPhoto = true;
        $('.upload-btn .photo.Comment a').trigger('click');
    },
    clearVariables:function () {
        Comment.clearResponse();
        Comment.clearQuote();
        $('#edit-id').val('');
    },
    response:function (link) {
        this.clearVariables();
        this.selected_text = null;
        this.moveForm($(link).parents('.item').find('.comment-action'));
        var id = $(link).parents('.item:eq(0)').attr('id').split('_')[1];
        $('#add_comment').find('.response input').val(id);
    },
    clearResponse:function () {
        $('#add_comment').find('.response input').val('');
    },
    quote:function (link) {
        this.clearVariables();
        this.moveForm($(link).parents('.item').find('.comment-action'));
        var id = $(link).parents('.item:eq(0)').attr('id').split('_')[1];
        var text = '';
        if (!this.selected_text) {
            text = $(link).parents('.item:eq(0)').find('.content-in').html();
        } else {
            $('#add_comment').find('.quote #Comment_selectable_quote').val(1);
            text = this.selected_text;
        }
        $('#add_comment').find('.quote #Comment_quote_id').val(id);
        this.getInstance().setData('<div class="quote">' + text + '</div><p></p>');
        this.selected_text = null;
    },
    clearQuote:function () {
        $('#add_comment').find('.quote #Comment_quote_id').val('');
        $('#add_comment').find('.quote #Comment_selectable_quote').val(0);
    },
    goTo:function (index, currentPage) {
        var page = Math.ceil(index / 10);
        if (page != currentPage) {
            var pager = $('#comment_list .yiiPager .page:eq(' + (page - 1) + ')');
            var url = false;
            if (pager.size() > 0)
                url = pager.children('a').attr('href');
            var h = new AjaxHistory('comment_list');
            h.load('comment_list', url,
                function () {
                    Comment.changeScrollPosition(index);
                }).changeBrowserUrl(url);
        } else {
            Comment.changeScrollPosition(index);
        }
        return false;
    },
    changeScrollPosition:function (index) {
        var elem = $('#cp_' + index.toString());
        $('html, body').animate({scrollTop:elem.offset().top}, 'fast');
    },
    remove:function (el) {
        $.fn.yiiListView.update('comment_list');
    },
    edit:function (button) {
        this.clearVariables();
        this.selected_text = null;

        this.moveForm($(button).parents('.item').find('.comment-action'));

        var id = $(button).parents('.item').attr('id').replace(/comment_/g, '');
        $('#edit-id').val(id);
        var editor = this.getInstance();

        if ($(button).parents('.item').find('.content .quote').size() > 0) {
            var html = '';
            html += '<div class="quote">' + $(button).parents('.item').find('.content .quote').html() + '</div>';
            html += $(button).parents('.item').find('.content-in').html();
            editor.setData(html);
            $('#add_comment').find('.quote #Comment_quote_id').val($(button).parents('.item').find('.content .quote').attr('id').split('_')[1]);
            $('#add_comment').find('.quote #Comment_selectable_quote').val($(button).parents('.item').find('input[name=selectable_quote]').val());
        }
        else
            editor.setData($(button).parents('.item').find('.content-in').html());
        $('#add_comment .button_panel .btn-green-medium span span').text('Редактировать');

        $('html,body').animate({scrollTop:$('#add_comment').offset().top - 100}, 'fast');
        return false;
    },
    send:function (form) {
        $(form).find('textarea').val(this.getInstance().getData());
        $.ajax({
            type:'POST',
            data:$(form).serialize(),
            dataType:'json',
            url:Comment.save_url,
            success:function (response) {
                if (response.status == 'ok') {
                    var pager = $('#comment_list .yiiPager .page:last');
                    var url = false;
                    if (pager.size() > 0 && $('#add_comment .button_panel .btn-green-medium span span').text() != 'Редактировать')
                        url = pager.children('a').attr('href');
                    if (url !== false)
                        $.fn.yiiListView.update('comment_list', {url:url, data:{lastPage:true}});
                    else if ($('#add_comment .button_panel .btn-green-medium span span').text() == 'Редактировать')
                        $.fn.yiiListView.update('comment_list');
                    else
                        $.fn.yiiListView.update('comment_list', {data:{lastPage:true}});
                    var editor = Comment.getInstance();
                    editor.setData('');
                    editor.destroy();
                    Comment.cancel();
                }
            }
        });
        return false;
    },
    cancel:function () {
        this.clearVariables();
        this.selected_text = null;
        $('#add_comment .button_panel .btn-green-medium span span').text('Добавить');
        $('#edit-id').val('');
        $('#add_comment').hide().appendTo('#new_comment_wrapper');
        return false;
    },
    getText:function () {
        var txt = '';
        if (txt = window.getSelection) {
            txt = window.getSelection().toString();
        } else {
            txt = document.selection.createRange().text;
        }
        if (txt != '') {
            var pattern = /\r\n|\r|\n/g;
            txt = txt.replace(pattern, "<br/>");
        }
        this.selected_text = txt != '' ? txt : null;
    }
};

function addMenuToggle(el) {
    $(el).parents('.add-menu').find('ul').toggle();
    $(el).parents('.add-menu').find('.btn i').toggleClass('arr-t');
}

$(function () {
    $('.default-comments').delegate('.content-in', 'mousedown', function () {
        selected_keydown = $(this);
    });
    $('.default-comments').delegate('.content-in', 'mouseup', function () {
        if (selected_keydown && $(this).parents('li:eq(0)').attr('id') == selected_keydown.parents('li:eq(0)').attr('id'))
            Comment.getText();
        selected_keydown = null;
    });
    $(document).mouseup(function (e) {
        e = e ? e : windows.event;
        if ($(e.target).parents('.default-comments').size() == 0) {
            Comment.selected_text = null;
            selected_keydown = null;
        }
    });
});
