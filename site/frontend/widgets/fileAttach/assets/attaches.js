var currentAttach;

function Attach() {
    this.entity = null,
        this.entity_id = null,
        this.base_url = null, /* TODO не уверен, что где-то используется. Проверить. */
        this.params = new Array(),
        this.many = false,
        this.object_name = null;
    currentAttach = this;
}

Attach.prototype.changeView = function (link) {
    $('#attach_content').load(link.href, function () {
        $(link).parent().addClass('active').siblings().removeClass('active');
    });
    return false;
};

Attach.prototype.updateEntity = function (entity, entity_id) {
    this.entity = entity;
    this.entity_id = entity_id;
    return true;
};

Attach.prototype.changeAlbum = function (link) {
    $('#attach_content').load(link.href);
    return false;
};

Attach.prototype.selectPhoto = function (button, id) {
    var image = $(button).parent().siblings('a').children('img').clone(true);
    $('.upload-file .photo').find('a').hide();
    $('.upload-file .photo .upload-container').append(image);
    $('.upload-file .photo .upload-container').append($('<input type="hidden" name="photo_id" />').val(id));
    $('.upload-file .photo .upload-container').append($('<input type="hidden" name="ContestWork[file]" />').val(1));
    $('<a class="remove" href="javascript:;" onclick="' + this.object_name + '.closeUpload(this);"></a>').insertAfter($('.upload-file .photo'));
    if ($('#change_ava').size() > 0 && this.entity != "PhotoComment" && this.entity != 'Comment' && this.entity != 'CommunityPost' && this.entity != 'CommunityVideo') {
        this.crop(id);
    }
    else if (this.entity == 'Message' || this.entity == 'Comment' || this.entity == 'CommunityPost' || this.entity == 'CommunityVideo') {
        this.insertToComment(id);
    } else if (this.entity == "PhotoComment") {
        this.saveCommentPhoto(id);
    } else if (this.entity == "Product") {
        this.saveProductPhoto(id);
    } else if (this.entity == "CookDecoration") {
        this.CookDecorationEdit(id);
    } else if (this.entity == 'CommunityContent') {
        this.saveCommunityContent(id);
    } else {
        $.fancybox.close();
    }
};

Attach.prototype.selectBrowsePhoto = function (button) {
    var image = $('#upload_photo_container').children('img').clone(true);
    var fsn = $('#upload_photo_container').children('input').val();
    $('.upload-file .photo').find('a').hide();
    $('.upload-file .photo .upload-container').append(image);
    $('.upload-file .photo .upload-container').append($('<input type="hidden" name="photo_fsn" />').val(fsn));
    $('.upload-file .photo .upload-container').append($('<input type="hidden" name="ContestWork[file]" />').val(1));
    $('<a class="remove" href="javascript:;" onclick="' + this.object_name + '.closeUpload(this);"></a>').insertAfter($('.upload-file .photo'));
    if ($('#change_ava').size() > 0 && this.entity != 'PhotoComment' && this.entity != 'Comment' && this.entity != 'CommunityPost' && this.entity != 'CommunityVideo') {
        this.crop(fsn);
        $.fancybox.center(true);
    } else if (this.entity == "Product") {
        this.saveProductPhoto(fsn);
    } else if (this.entity == "PhotoComment") {
        this.saveCommentPhoto(fsn);
    } else if (this.entity == 'Message' || this.entity == 'Comment' || this.entity == 'CommunityPost' || this.entity == 'CommunityVideo') {
        this.insertToComment(fsn);
    } else if (this.entity == 'Humor') {
        this.insertToHumor(fsn);
    } else if (this.entity == 'CookDecoration') {
        this.CookDecorationEdit(fsn);
    } else if (this.entity == 'CookRecipe' || this.entity == 'SimpleRecipe' || this.entity == 'MultivarkaRecipe') {
        this.insertToRecipe(fsn);
    } else if (this.entity == 'UserPartner' || this.entity == 'Baby') {
        this.insertToPartner(fsn);
    } else if (this.entity == 'CommunityContent') {
        this.saveCommunityContent(fsn);
    } else {
        $.fancybox.close();
    }
    return false;
};

Attach.prototype.saveProductPhoto = function (val) {
    $.post(base_url + '/albums/productPhoto/', {val:val, entity:this.entity, entity_id:this.entity_id}, function (data) {
        if (data.status == true) {
            $.fancybox.close();
            document.location.reload();
        }
    }, 'json');
}

Attach.prototype.closeUpload = function (link) {
    $(link).siblings('.photo').find('.upload-container').empty();
    $(link).siblings('.photo').find('a').show();
    $(link).remove();
};

Attach.prototype.insertToComment = function (val) {
    var title = $('#photo_title').size() > 0 ? $('#photo_title').val() : null;
    $.post(base_url + '/albums/commentPhoto/', {val:val, title:title}, function (data) {
        if (CKEDITOR.instances[cke_instance] != undefined) {
            if (data.title != null && data.title != 'null')
                CKEDITOR.instances[cke_instance].insertHtml('<p><img src="' + data.src + '" alt="' + data.title + '" title="' + data.title + '" /></p>');
            else
                CKEDITOR.instances[cke_instance].insertHtml('<p><img src="' + data.src + '" /></p>');
        }
        $.fancybox.close();
    }, 'json');
};

Attach.prototype.insertToHumor = function (fsn) {
    $.post(base_url + '/albums/humorPhoto/', {val:fsn}, function (data) {
        if (data)
            document.location.reload();
    }, 'json');
}

Attach.prototype.insertToRecipe = function (fsn) {
    var $this = this;
    $.post(base_url + '/albums/recipePhoto/', {val:fsn, many:this.many,entity:this.entity,entity_id:this.entity_id}, function (data) {
        if (data.status) {
            if (! $this.many) {
                $('#' + $this.entity + '_photo_id').val(data.id);
                $('a.attach').html($('<img />').attr('src', data.src));
                if (!$('div.add-photo').hasClass('uploaded'))
                    $('div.add-photo').addClass('uploaded');
                $.fancybox.close();
            } else {
                document.location.reload();
            }
        }
    }, 'json');
}

Attach.prototype.insertToPartner = function (fsn) {
    var $this = this;
    $.post(base_url + '/albums/partnerPhoto/', {val:fsn, many:this.many,entity:this.entity,entity_id:this.entity_id}, function (data) {
        if (data.status) {
            var list = $('ul:data(entity=' + $this.entity + '):data(entityId=' + $this.entity_id + ')');
            var box = $('#photoTmpl').tmpl({
                img: data.src,
                title: (($this.entity == 'UserPartner') ? Family.partnerOf[Family.relationshipStatus][2] : 'Мой ребёнок') + ' - фото ' + list.find('li').length,
                id:$this.entity_id
            });
            list.append(box).masonry('appended', box);

            $.fancybox.close();
        }
    }, 'json');
}

Attach.prototype.CommunityContentEdit = function(val) {
    $.post(base_url + '/albums/communityContentEdit/', {val:val, widget_id:this.object_name}, function (html) {
        $('#attach_content').html(html);
    }, 'html');
}

Attach.prototype.CommunityContentInsert = function(val) {
    if($('#attach_content textarea').val().length > 1000) {
        $('#attach_content textarea').addClass('error');
        return false;
    } else {
        $('#attach_content textarea').removeClass('error');
    }

    $.post(
        '/albums/communityContentSave/',
        {
            title:$('input[name="title"]').val(),
            description:$('#attach_content textarea').val(),
            val:val
        },
        function (data) {
            var item = $('#photo_item').tmpl({id:data.id, title:data.title, description:data.description, src: data.photo})
                .insertBefore('.row-gallery .gallery-photos ul li:last-child');
            $('.tooltip', item).tooltip({
                delay: 100,
                track: false,
                showURL: false,
                showBody: false,
                top: -20,
                left: 10
            });
            $.fancybox.close();
        }, 'json');
}

Attach.prototype.insertToCookDecoration = function (id) {
    if($('#attach_content textarea').val().length > 200) {
        $('#attach_content textarea').addClass('error');
        return false;
    } else {
        $('#attach_content textarea').removeClass('error');
    }
    $.post(
        '/albums/cookDecorationPhoto/',
        {
            title:$('#attach_content input[name="title"]').val(),
            description:$('#attach_content textarea').val(),
            category:$('#attach_content select[name="category"]').val(),
            id:id
        },
        function (data) {
            if (data.status) {
//                $('#dishes').load(document.location+' #dishes', function(){
//                    $('.list-view li.dish div.img a').pGallery({entity:'CookDecorationCategory', entity_id:data.id});
//                });
                window.location.href = '/cook/decor/photo'+data.id+'/';
                //$.fancybox.close();
            } else {
                if (data.message) {
                    alert(data.message);
                } else {
                    alert('Ошибка загрузки, попробуйте еще раз');
                }
            }
        }, 'json');
}

Attach.prototype.CookDecorationEdit = function (fsn) {
    $.post(base_url + '/albums/cookDecorationCategory/', {val:fsn, widget_id:this.object_name}, function (response) {
        if (response.success) {
            $('#attach_content').html(response.html);
            if (response.title) {
                if ($('#file_attach_menu li.decorationTab').length == 0)
                    $('#file_attach_menu').append('<li class="active decorationTab"><a href="#" onclick="' + response.tab + '; return false;">' + response.title + '</a></li>');
                $('#file_attach_menu li').removeClass('active');
                $('#file_attach_menu li.decorationTab').addClass('active');
            }
            $(".chzn").chosen();
        } else {
            if (response.hasOwnProperty('error'))
                alert(response.error);
            else
                $('#attach_content').html(response.html);
        }
    }, 'json')
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

Attach.prototype.crop = function (val) {
    var $this = this;

    $.post(base_url + '/albums/crop/', {val:val, widget_id:this.object_name}, function (data) {
        $('#photoPick').replaceWith($(data));
        $('#crop_target').Jcrop({
            onChange:$this.showPreview,
            onSelect:$this.showPreview,
            aspectRatio:1
        });
    });
};

Attach.prototype.showPreview = function (coords) {
    $('#photoPick .form-bottom').show();
    var rx = 72 / coords.w;
    var ry = 72 / coords.h;

    $.fancybox.center(true);

    $('#coords_value').val(JSON.stringify(coords));
    $('#preview').css({
        width:Math.round(rx * $('#crop_target').width()) + 'px',
        height:Math.round(ry * $('#crop_target').height()) + 'px',
        marginLeft:'-' + Math.round(rx * coords.x) + 'px',
        marginTop:'-' + Math.round(ry * coords.y) + 'px'
    });
}

Attach.prototype.changeAvatar = function (form) {
    var data = $(form).serialize();
    data += '&width=' + $('#crop_target').width() + '&height=' + $('#crop_target').height();
    $.post(base_url + '/albums/changeAvatar/', data, function (data) {
        $('#change_ava').addClass('filled').empty().append($('<img />').attr('src', data));
        if ($('#refresh_upload').size() > 0)
            document.location.reload();
    });
    $.fancybox.close();
    return false;
};


function initAttachForm() {
    $('#attach_form').iframePostForm({
        complete:function (response) {
            if (!response)
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
                if (currentAttach.entity == "CommunityContent")
                    currentAttach.CommunityContentEdit(params[1]);
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