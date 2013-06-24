var selected_keydown = null;
function Comment() {
    this.selected_text = null,
    this.save_url = null,
    this.toolbar = 'Chat',//'toolbar' => 'Chat','skin'=>'hgrucomment'
    this.skin = 'hgrucomment',
    this.saveCommentUrl = null,
    this.entity = null,
    this.entity_id = null,
    this.model = 'Comment',
    this.scrollContainer = null,
    this.object_name = null
}

Comment.prototype.setParams = function (params) {
    for (var n in params) {
        if (typeof(this[n]) != undefined)
            this[n] = params[n];
    }
};

Comment.prototype.getId = function() {
    return 'comment_list_' + this.object_name;
};

Comment.prototype.getWrapperInstance = function() {
    return $('#' + this.getId()).siblings('#add_comment');
};

Comment.prototype.getScrollContainer = function() {
    return this.scrollContainer && $(this.scrollContainer).size() > 0 ? this.scrollContainer : document;
}

Comment.prototype.getInstance = function () {
    var instance = CKEDITOR.instances[this.model + '_text'];
    if (instance)
        return instance;
    return false;
};

Comment.prototype.createInstance = function (focus) {
    var instance = this.getInstance();
    if (instance) {
        instance.destroy(true);
    }

    var $this = this;
    CKEDITOR.replace(this.model + '_text', {
        toolbar:this.toolbar,
        skin:this.skin,
        height:'120px',
        on : focus ?
        {
            instanceReady : function( ev )
            {
                ev.editor.focus();
            }
        } : {}
    });
};

Comment.prototype.moveForm = function (container, focus, hide) {
    var instance = this.getInstance();
    if (instance)
        instance.destroy(true);
    var form = $('#add_comment', '#' + this.getId()).clone(true);
    $('#add_comment', '#' + this.getId()).remove();
    form.appendTo(container).show();

    var $this = this;

    if (!hide)
        setTimeout(function(){$this.showForm()}, 200);

    this.createInstance(focus);
};

Comment.prototype.newComment = function (el) {
    if ($(el).next().attr('id') == 'add_comment_form'){
        this.createInstance(true);

        var $this = this;
        setTimeout(function(){$this.showForm()}, 200);
    }
    else{
        this.cancel();
        this.moveForm($('#' + this.getId()), true);
    }
};

Comment.prototype.newPhotoComment = function (event) {
    this.cancel();
    $('.upload-btn .photo.PhotoComment a').trigger('click');
};

Comment.prototype.clearVariables = function () {
    this.clearResponse();
    this.clearQuote();
    $('#edit-id', '#' + this.getId()).val('');
};

Comment.prototype.response = function (link) {
    this.clearVariables();
    this.selected_text = null;
    this.showForm();
    this.moveForm($(link).parents('.item').find('.comment-action'), true);
    var id = $(link).parents('.item:eq(0)').attr('id').split('_')[1];
    $('#add_comment', '#' + this.getId()).find('.response input').val(id);
};

Comment.prototype.clearResponse = function () {
    $('#add_comment', '#' + this.getId()).find('.response input').val('');
};

Comment.prototype.quote = function (link) {
    this.clearVariables();
    this.showForm();
    this.moveForm($(link).parents('.item').find('.comment-action'), true);
    var id = $(link).parents('.item:eq(0)').attr('id').split('_')[1];
    var text = '';
    if (!this.selected_text) {
        text = $(link).parents('.item:eq(0)').find('.content-in').html();
    } else {
        $('#add_comment', '#' + this.getId()).find('.quote #Comment_selectable_quote').val(1);
        text = this.selected_text;
    }
    $('#add_comment', '#' + this.getId()).find('.quote #Comment_quote_id').val(id);
    this.getInstance().setData('<div class="quote">' + text + '</div><p></p>');
    this.selected_text = null;
};

Comment.prototype.clearQuote = function () {
    $('#add_comment', '#' + this.getId()).find('.quote #Comment_quote_id').val('');
    $('#add_comment', '#' + this.getId()).find('.quote #Comment_selectable_quote').val(0);
};

Comment.prototype.goTo = function (index, currentPage) {
    var page = Math.ceil(index / 25);
    if (page != currentPage) {
        var pager = $('#' + this.getId() + ' .yiiPager .page:eq(' + (page - 1) + ')');
        var url = false;
        if (pager.size() > 0)
            url = pager.children('a').attr('href');

        var h = new AjaxHistory(this.getId());
        var $this = this;
        h.load(this.getId(), url,
            function () {
                $this.changeScrollPosition(index);
            }).changeBrowserUrl(url);
    } else {
        this.changeScrollPosition(index);
    }
    return false;
};

Comment.prototype.changeScrollPosition = function (index) {
    var elem = $('#cp_' + index.toString());
    $(this.getScrollContainer()).animate({scrollTop:elem.get(0).offsetTop}, "normal");
};

Comment.prototype.remove = function (el) {
    $.fn.yiiListView.update(this.getId());
};

Comment.prototype.edit = function (button) {
    this.clearVariables();
    this.selected_text = null;

    this.showForm();
    this.moveForm($(button).parents('.item').find('.comment-action'), false);

    var id = $(button).parents('.item').attr('id').replace(/comment_/g, '');
    $('#edit-id', '#' + this.getId()).val(id);
    var editor = this.getInstance();

    if ($(button).parents('.item').find('.content .quote').size() > 0) {
        var html = '';
        html += '<div class="quote">' + $(button).parents('.item').find('.content .quote').html() + '</div>';
        html += $(button).parents('.item').find('.content-in').html();
        editor.setData(html);
        $('#add_comment', this.getWrapperInstance()).find('.quote #Comment_quote_id').val($(button).parents('.item').find('.content .quote').attr('id').split('_')[1]);
        $('#add_comment', this.getWrapperInstance()).find('.quote #Comment_selectable_quote').val($(button).parents('.item').find('input[name=selectable_quote]').val());
    }
    else
        editor.setData($(button).parents('.item').find('.content-in').html());
    $('#add_comment .button_panel .btn-green-medium span span', '#' + this.getId()).text('Редактировать');

    //$(this.getScrollContainer()).animate({scrollTop:$('#add_comment', '#' + this.getId()).offset().top - 100}, 'fast');
    return false;
};

Comment.prototype.send = function (form) {
    $(form).find('textarea').val(this.getInstance().getData());
    var $this = this;
    $.ajax({
        type:'POST',
        data:$(form).serialize(),
        dataType:'json',
        url:$this.save_url,
        success:function (response) {
            if (response.status == 'ok') {
                var pager = $('#' + $this.getId() + ' .yiiPager .page:last');
                var url = false;
                if (pager.size() > 0 && $('#add_comment .button_panel .btn-green-medium span span', $this.getWrapperInstance()).text() != 'Редактировать')
                    url = pager.children('a').attr('href');
                if (url !== false){
                    $.fn.yiiListView.update($this.getId(), {url:url, data:{lastPage:true}});
                    $this.goEndOfList();
                }
                else if ($('#add_comment .button_panel .btn-green-medium span span', $this.getWrapperInstance()).text() == 'Редактировать')
                    $.fn.yiiListView.update(this.getId());
                else{
                    $.fn.yiiListView.update($this.getId(), {data:{lastPage:true}});
                    $this.goEndOfList();
                }

                var editor = $this.getInstance();
                editor.setData('');
                editor.destroy();
                $this.cancel();
            }else{
                location.reload();
            }
        }
    });
    return false;
};

Comment.prototype.cancel = function () {
    this.clearVariables();
    this.selected_text = null;
    $('#add_comment .button_panel .btn-green-medium span span', '#' + this.getId()).text('Добавить');
    $('#edit-id', '#' + this.getId()).val('');

    //если верхний комментарий, то уменьшаем форму, инче переносим ее вверх
    var elem = $('#add_comment', '#' + this.getId());
    if (elem.parent().attr('id') == 'add_comment_wrapper'){
        this.hideForm();
    }else{
        this.hideForm();
        this.moveForm($('#add_comment_wrapper', '#' + this.getId()), false, true);
    }
    return false;
};

Comment.prototype.showForm = function () {
    var el = $('#' + this.getId() + ' #dummy-comment');
    el.hide().next().show().parents('.comment-add').addClass('active');
    el.parents('.comment-add').find('span.comment-add_username').show();
}

Comment.prototype.hideForm = function () {
    var el = $('#' + this.getId() + ' #dummy-comment');
    el.show().next().hide().parents('.comment-add').removeClass('active');
    el.parents('.comment-add').find('span.comment-add_username').hide();
}

Comment.prototype.goEndOfList = function () {
    $(this.getScrollContainer()).animate({scrollTop:$('#' + this.getId()).find('ul.items li').get(-1).offsetTop}, "normal");
}
Comment.prototype.goTop = function () {
    $(this.getScrollContainer()).animate({scrollTop:$('#' + this.getId()).find('ul.items li').get(1).offsetTop - 200}, "fast");
}




function addMenuToggle(el) {
    $(el).parents('.add-menu').find('ul').toggle();
    $(el).parents('.add-menu').find('.btn i').toggleClass('arr-t');
}

function setRedirectUrl(elem){
    Register.redirectUrl = location.href;
    Register.gotoComment = 1;
    $('#login-form input[name=redirect_to]').val(elem);
}