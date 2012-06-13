var currentAttach;

function Attach() {
    this.entity = null,
        this.entity_id = null,
        this.base_url = null, /* TODO не уверен, что где-то используется. Проверить. */
        this.params = new Array(),
        this.object_name = null;
    currentAttach = this;
}

Attach.prototype.changeView = function(link) {
    $('#attach_content').load(link.href, function() {
        $(link).parent().addClass('active').siblings().removeClass('active');
    });
    return false;
};

Attach.prototype.updateEntity = function(entity, entity_id) {
    this.entity = entity;
    this.entity_id = entity_id;
    return true;
};

Attach.prototype.changeAlbum = function(link) {
    $('#attach_content').load(link.href);
    return false;
};

Attach.prototype.selectPhoto = function(button, id) {
    var image = $(button).parent().siblings('a').children('img').clone(true);
    $('.upload-file .photo').find('a').hide();
    $('.upload-file .photo .upload-container').append(image);
    $('.upload-file .photo .upload-container').append($('<input type="hidden" name="photo_id" />').val(id));
    $('.upload-file .photo .upload-container').append($('<input type="hidden" name="ContestWork[file]" />').val(1));
    $('<a class="remove" href="javascript:;" onclick="' + this.object_name + '.closeUpload(this);"></a>').insertAfter($('.upload-file .photo'));
    if($('#change_ava').size() > 0 && this.entity != "PhotoComment" && this.entity != 'Comment' && this.entity != 'CommunityPost' && this.entity != 'CommunityVideo') {
        this.crop(id);
    }
    else if (this.entity == 'Comment' || this.entity == 'CommunityPost' || this.entity == 'CommunityVideo') {
        this.insertToComment(id);
    } else if(this.entity == "PhotoComment"){
        this.saveCommentPhoto(id);
    } else if (this.entity == "Product") {
        this.saveProductPhoto(id);
    } else if (this.entity == "CookDecoration") {
        this.CookDecorationEdit(id);
    } else {
        $.fancybox.close();
    }
};

Attach.prototype.selectBrowsePhoto = function(button) {
    var image = $('#upload_photo_container').children('img').clone(true);
    var fsn = $('#upload_photo_container').children('input').val();
    $('.upload-file .photo').find('a').hide();
    $('.upload-file .photo .upload-container').append(image);
    $('.upload-file .photo .upload-container').append($('<input type="hidden" name="photo_fsn" />').val(fsn));
    $('.upload-file .photo .upload-container').append($('<input type="hidden" name="ContestWork[file]" />').val(1));
    $('<a class="remove" href="javascript:;" onclick="' + this.object_name + '.closeUpload(this);"></a>').insertAfter($('.upload-file .photo'));
    if($('#change_ava').size() > 0 && this.entity != 'PhotoComment' && this.entity != 'Comment' && this.entity != 'CommunityPost' && this.entity != 'CommunityVideo') {
        this.crop(fsn);
    } else if(this.entity == "Product") {
        this.saveProductPhoto(fsn);
    } else if(this.entity == "PhotoComment"){
        this.saveCommentPhoto(fsn);
    } else if (this.entity == 'Comment' || this.entity == 'CommunityPost' || this.entity == 'CommunityVideo') {
        this.insertToComment(fsn);
    } else if(this.entity == 'Humor') {
        this.insertToHumor(fsn);
    }else if(this.entity == 'CookDecoration') {
        this.CookDecorationEdit(fsn);
    } else if(this.entity == 'CookRecipe') {
        this.insertToRecipe(fsn);
    } else {
        $.fancybox.close();
    }
    return false;
};

Attach.prototype.saveProductPhoto = function(val) {
    $.post(base_url + '/albums/productPhoto/', {val : val,  entity: this.entity, entity_id: this.entity_id}, function(data) {
        if(data.status == true) {
            $.fancybox.close();
            document.location.reload();
        }
    }, 'json');
}

Attach.prototype.closeUpload = function(link) {
    $(link).siblings('.photo').find('.upload-container').empty();
    $(link).siblings('.photo').find('a').show();
    $(link).remove();
};

Attach.prototype.insertToComment = function(val) {
    var title = $('#photo_title').size() > 0 ? $('#photo_title').val() : null;
    $.post(base_url + '/albums/commentPhoto/', {val : val, title : title}, function(data) {
        if(CKEDITOR.instances[cke_instance] != undefined){
            if (data.title != null && data.title != 'null')
                CKEDITOR.instances[cke_instance].insertHtml('<p><img src="' + data.src + '" alt="' + data.title + '" title="' + data.title + '" /></p>');
            else
                CKEDITOR.instances[cke_instance].insertHtml('<p><img src="' + data.src + '" /></p>');
        }
        $.fancybox.close();
    }, 'json');
};

Attach.prototype.insertToHumor = function(fsn) {
    $.post(base_url + '/albums/humorPhoto/', {val:fsn}, function(data) {
        if(data)
            document.location.reload();
    }, 'json');
}

Attach.prototype.insertToRecipe = function(fsn) {
    $.post(base_url + '/albums/recipePhoto/', {val:fsn}, function(data) {
        if(data.status) {
            $('#CookRecipe_photo_id').val(data.id);
            $('a.attach').html($('<img />').attr('src', data.src));
            if (! $('div.add-photo').hasClass('uploaded'))
                $('div.add-photo').addClass('uploaded');
            $.fancybox.close();
        }
    }, 'json');
}

Attach.prototype.insertToCookDecoration = function (id) {
    $.post(
        '/albums/cookDecorationPhoto/',
        {
            //val:$('#upload_photo_container').children('input').val(),
            title:$('#attach_content input[name="title"]').val(),
            category:$('#attach_content select[name="category"]').val(),
            id:id
        },
        function (data) {
            if (data) {
                $('#dishes').load('/cook/decor/ #dishes');
                $.fancybox.close();
            }
        });
}

Attach.prototype.CookDecorationEdit = function (fsn) {
    $.post(base_url + '/albums/cookDecorationCategory/', {val:fsn, widget_id:this.object_name}, function (data) {
        $('#attach_content').html(data.html);
        if (data.title) {
            if ($('#file_attach_menu li.decorationTab').length == 0)
                $('#file_attach_menu').append('<li class="active decorationTab"><a href="#" onclick="' + data.tab + '; return false;">' + data.title + '</a></li>');
            $('#file_attach_menu li').removeClass('active');
            $('#file_attach_menu li.decorationTab').addClass('active');
        }
        $(".chzn").chosen();
    })
}


Attach.prototype.saveCommentPhoto = function (val) {
    $.post(base_url + '/albums/commentPhoto/', {entity:attach_comment_obj.entity, entity_id:attach_comment_obj.entity_id, val:val},
        function (response) {
            if (response.status) {
                $.fancybox.close();
                var pager = $('#comment_list .yiiPager .page:last');
                var url = false;
                if (pager.size() > 0 && $('#add_comment .button_panel .btn-green-medium span span').text() != 'Редактировать')
                    url = pager.children('a').attr('href');
                if (url !== false)
                    $.fn.yiiListView.update(attach_comment_obj.getId(), {url:url, data:{lastPage:true}});
                else if ($('#add_comment .button_panel .btn-green-medium span span').text() == 'Редактировать')
                    $.fn.yiiListView.update(attach_comment_obj.getId());
                else
                    $.fn.yiiListView.update(attach_comment_obj.getId(), {data:{lastPage:true}});
                var editor = attach_comment_obj.getInstance();
                editor.setData('');
                editor.destroy();
                attach_comment_obj.cancel();
            }
        }, 'json');
};

Attach.prototype.crop = function(val) {
    var $this = this;
    $.post(base_url + '/albums/crop/', {val : val, widget_id : this.object_name}, function(data) {
        $('#photoPick').replaceWith($(data));
        $('#crop_target').Jcrop({
            onChange: $this.showPreview,
            onSelect: $this.showPreview,
            aspectRatio: 1
        });
    });
};

Attach.prototype.showPreview = function(coords) {
    $('#photoPick .form-bottom').show();
    var rx = 72 / coords.w;
    var ry = 72 / coords.h;
    $('#coords_value').val(JSON.stringify(coords));
    $('#preview').css({
        width: Math.round(rx * $('#crop_target').width()) + 'px',
        height: Math.round(ry * $('#crop_target').height()) + 'px',
        marginLeft: '-' + Math.round(rx * coords.x) + 'px',
        marginTop: '-' + Math.round(ry * coords.y) + 'px'
    });
}

Attach.prototype.changeAvatar = function(form) {
    var data = $(form).serialize();
    data += '&width=' + $('#crop_target').width() + '&height=' + $('#crop_target').height();
    $.post(base_url + '/albums/changeAvatar/', data, function(data) {
        $('#change_ava').addClass('filled').empty().append($('<img />').attr('src', data));
        if($('#refresh_upload').size() > 0)
            document.location.reload();
    });
    $.fancybox.close();
    return false;
};


function initAttachForm() {
    $('#attach_form').iframePostForm({
        complete:function (response) {
            if(!response)
                return false;
            var params = $(response).find('#params').text().split('||');
            var html = '<img src="' + params[0] + '" width="170" alt="" />' +
                '<input type="hidden" name="fsn" value="' + params[1] + '" />' +
                '<a class="remove" href="" onclick="return removeAttachPhoto();"></a>';

            $('#attach_content div.note').hide();
            $('#attach_content div.photo_title').show();

            $('#upload_photo_container').html(html);
            $('#attach_form').hide();
            $('#save_attach_button').show();

            if (currentAttach.entity == "CookDecoration")
                currentAttach.CookDecorationEdit(params[1]);
        }
    });
}

function removeAttachPhoto() {
    $('#upload_photo_container').html('');
    $('#attach_form').show();
    $('#save_attach_button').hide();

    $('#attach_content div.note').show();
    $('#attach_content div.photo_title').hide();

    return false;
}