var Album = {
    editMode:false,
    album_id:false,
    current_album_id:null,
    initJ:false,
    initFlash:false
};
Album.editDescription = function (link, tmp) {
    var note = $(link).parents('.note:eq(0)');
    $('.fast-actions', note).hide();
    if (!tmp) {
        var html = $('<form><textarea placeholder="Введите комментарий к альбому не более 140 символов"></textarea><button class="btn btn-green-small"><span><span>Ок</span></span></button></form>');
        $('textarea', html).val($('p', note).text());
        $('p', note).remove();
        html.appendTo(note);
    } else {
        $('form', note).show();
    }
    $('form', note).bind('submit', function () {
        Album.saveDescription(this);
        return false;
    });
    return false;
};

Album.saveDescription = function (button, tmp) {
    var note = $(button).parents('.note:eq(0)');
    var text = $('textarea', note).val();
    $('<p></p>').text(text).appendTo(note);
    $('.fast-actions', note).show();
    if (tmp) {
        $('form', note).hide();
    } else {
        $('form', note).remove();
        $.post($('.fast-actions a', note).attr('href'), {text:text});
        if (text == '')
            $('.fast-actions a', note).removeClass('edit').addClass('add');
        else
            $('.fast-actions a', note).removeClass('add').addClass('edit');
    }
};

Album.removeDescription = function (link) {
    $.post(link.href, {text:''});
    $(link).parents('.note:eq(0)').remove();
    return false;
};

/* Изменение названия фотографии */
Album.editPhoto = function (link) {
    $(link).parents('tr:eq(0)').addClass('editing');
    var text = $(link).siblings('span').text();
    $(link).parent().hide().siblings('div').show().find('input[type=text]').val(text);
    return false;
};

/* Сохранение названия фотографии */
Album.savePhoto = function (button) {
    $(button).parents('tr:eq(0)').removeClass('editing');
    var text = $(button).siblings('input[type=text]').val();
    $(button).parent().hide().siblings('div').show().find('span').text(text);
    if (!this.editMode) {
        var url = $(button).parent().hide().siblings('div').find('a.edit').attr('href');
        $.post(
            url,
            {title:text}
        );
    }
    return false;
};

Album.removePhoto = function (button, data) {
    $('#album_photo_' + data['Removed[entity_id]']).remove();
    if (!this.editMode) {
        console.log($('#photosList').length);
        $('#photosList').length == 0 ?
            $('*:data(id=' + data['Removed[entity_id]'] + ')').parents('li').remove()
            :
            $.fn.yiiListView.update('photosList');
    }
};

Album.removeAlbum = function () {
    document.location.href = base_url + '/albums';
};

Album.changeAlbum = function (select) {
    if ($(select).val() == '') {
        Album.album_id = null;
        if ($('#new_album_title').val() == '') {
            if (this.initFlash) {
                Album.clearFlash();
                $('#upload_button_wrapper').addClass('disabled');
            } else {
                $('#j-upload-input1').parent().hide();
            }
        }
        return false;
    }
    Album.album_id = $(select).val();

    upload_ajax_url = upload_ajax_url.replace(new RegExp('/a/(.*)', 'g'), '/a/' + $(select).val() + '/');
    $('#new_album_title').val('');
    if (!$('#upload_finish_wrapper').is('.is_visible')) {
        if (this.initFlash) {
            $('#upload_button_wrapper').removeClass('disabled');
        } else {
            $('#j-upload-input1').parent().show();
        }
    }
    Album.initUploadForm();
};

Album.initUploadForm = function () {
    if ($('#log').children('li').not('.upload-done').not('.upload-error').size() == 0) {
        if (FlashDetect.installed == true)
            Album.initUForm();
        else {
            if ($('#j-upload-input1').data('fileupload') == undefined)
                Album.initJForm();
            else
                $('#j-upload-input1').data('fileupload').options.url = upload_ajax_url;
        }
    } else {
        setTimeout(function () {
            Album.initUploadForm()
        }, 500);
    }
}

Album.changeAlbumTitle = function (input) {
    if ($(input).val() != '') {
        if ($('#upload_finish_wrapper').not('.is_visible')) {
            if (this.initFlash) {
                $('#upload_button_wrapper').removeClass('disabled');
            } else {
                $('#j-upload-input1').parent().show();
            }
        }
        $('#album_select_chzn .search-choice-close').trigger('mouseup');
        upload_ajax_url = upload_ajax_url.replace(new RegExp('/a/(.*)', 'g'), '/a/0/text/' + $(input).val() + '/u/' + $('#author_id').val() + '/');
        Album.initUploadForm();
    } else {
        if (this.initFlash) {
            Album.clearFlash();
            $('#upload_button_wrapper').addClass('disabled');
        } else {
            $('#j-upload-input1').parent().hide();
        }
    }

};

Album.changeTitle = function (link, id) {
    var span = $(link).parent().find('.album_title');
    var text = span.text();
    span.empty().append($('<input type="text" name="title_input" value="' + text + '" /><input type="hidden" name="album_id" value="' + id + '" /><button class="btn btn-green-small" onclick="return Album.appendTitle(this);"><span><span>Ок</span></span></button>'));
    $(link).hide();
    return false;
};

Album.appendTitle = function (button) {
    var span = $(button).parent();
    var text = span.find('input[name=title_input]').val();
    var id = span.find('input[name=album_id]').val();
    $.post(base_url + '/albums/changeTitle/', {title:text, id:id}, function(result) {
        if(result.result == true) {
            $(button).parent().parent().parent().children('a.edit').show();
            span.empty().text(text);
        } else {
            span.find('input[name=title_input]').addClass('error');
        }
    }, 'json');
    return false;
}

Album.changePhotoTitle = function (link, id) {
    var span = $(link).parent().find('.album_title');
    var text = span.text();
    if (text == '...')
        text = '';
    span.empty().append($('<input type="text" name="title_input" value="' + text + '" />&nbsp;<input type="hidden" name="album_id" value="' + id + '" /><button class="btn btn-green-small" onclick="return Album.appendPhotoTitle(this);"><span><span>Ок</span></span></button>'));
    $(link).hide();
    return false;
};

Album.appendPhotoTitle = function (button) {
    $(button).parent().parent().children('a.edit').show();
    var span = $(button).parent();
    var text = span.find('input[name=title_input]').val();
    var id = span.find('input[name=album_id]').val();
    $.post(base_url + '/albums/editPhotoTitle/', {title:text, id:id});
    if (text == '')
        text = '...';
    span.empty().text(text);
    return false;
};

Album.initJForm = function () {
    this.initJ = true;
    $('#j-upload-input1').parent().show();
    $('.j-upload-input').fileupload({
        url:upload_ajax_url,
        dataType:'html',
        add:function (e, data) {
            data.id = Math.floor(Math.random() * (100000 - 1) + 1);
            Album.appendUploadItem(data.id);
            Album.uploadStart(data.id);
            data.submit();
        },
        progress:function (e, data) {
            Album.uploadProgress(data.id, parseInt(data.loaded / data.total * 100, 10));
        },
        done:function (e, data) {
            Album.uploadSuccess(data.id, data.files[0].name, data.result);
        }
    });
};

Album.initUForm = function () {
    this.initFlash = true;
    $('#upload-file-fake').hide();
    $('#upload-input').hide();
    Album.clearFlash();

    $('#upload-control').swfupload({
        upload_url:upload_ajax_url,
        file_size_limit:"6144",
        file_types:"*.jpg;*.png;*.gif;*.jpeg",
        file_upload_limit:"0",
        flash_url:"/javascripts/flash_upload/swfupload.swf",
        flash9_url:"/javascripts/flash_upload/swfupload_fp9.swf",

        button_text:'',
        button_width:178,
        button_height:34,
        /*button_image_url:"/images/btn_browse.png",*/
        button_window_mode:SWFUpload.WINDOW_MODE.TRANSPARENT,
        button_cursor:SWFUpload.CURSOR.HAND,
        button_placeholder:$('#upload-button')[0]
    });

    $('#upload_finish_wrapper').swfupload({
        upload_url:upload_ajax_url,
        file_size_limit:"6144",
        file_types:"*.jpg;*.png;*.gif;*.jpeg",
        file_upload_limit:"0",
        flash_url:"/javascripts/flash_upload/swfupload.swf",
        flash9_url:"/javascripts/flash_upload/swfupload_fp9.swf",

        button_text:'<span class="moreButton">Добавить еще фотографий</span>',
        button_text_style:'.moreButton {color: #54AFC3;display:block;height:34px;line-height:34px;font-size:12px;font-family:arial;}',
        button_width:178,
        button_height:34,
        button_placeholder:$('#upload-link')[0]
    });

    Album.registerUploadEvents($('#upload-control'));
    Album.registerUploadEvents($('#upload_finish_wrapper'));
};

Album.clearFlash = function () {
    if ($('#upload-control').data('__swfu') != undefined) {
        if ($('#upload-control').find('.swfupload').size() > 0) {
            $('#upload-control .swfupload').get(0).parentNode.removeChild($('#upload-control .swfupload').get(0));
            $('<button id="upload-button" class="btn btn-orange"><span><span>Загрузить</span></span></button>').appendTo('#upload-control .row-btn-left');
        }
        $('#upload-control').data('__swfu').destroy();
        $('#upload-control').data('__swfu', null);
        $('#upload_finish_wrapper .swfupload').get(0).parentNode.removeChild($('#upload_finish_wrapper .swfupload').get(0));
        $('#upload_finish_wrapper').prepend('<a id="upload-link" class="a-left" href="">Добавить еще фотографий</a>')
        $('#upload_finish_wrapper').data('__swfu').destroy();
        $('#upload_finish_wrapper').data('__swfu', null);
        return false;
    }
    return true;
};

Album.appendUploadItem = function (id) {
    var listitem = '<li class="clearfix not-loaded" id="' + id + '">' +
        '<div class="img"><div class="actions"><a href="javascript:;" class="remove tooltip" title="Удалить фото" onclick="return Album.removeUploadItem(this);"></a></div></div>' +
        '<div class="loading"><table><tr><td>Загрузка<div class="progress-bar"><div class="in"></div></div></td></tr></table><a href="" class="remove"></a></div>' +
        '<div class="file-params" style="display:none;"></div>' +
        '</li>';
    $('#log').append(listitem);
};


Album.removeUploadItem = function (link) {
    if ($(link).parent().siblings('.file-params').children('span.fid').size() > 0) {
        var id = $(link).parent().siblings('.file-params').children('span.fid').text();
        $.post('/albums/removeUploadPhoto/', {id:id});
    }
    $(link).parent().parent().remove();
    return false;
}

Album.appendUploadErrorItem = function (id, name, error) {
    $('#upload_button_wrapper').css({height:0});
    $('#upload_finish_wrapper').css('height', 'auto').addClass('is_visible');
    $('#album_upload_step_1').css('height', 0);
    $('#album_upload_step_2').show();
    var listitem = '<li class="clearfix" id="' + id + '" >' +
        '<div class="loading error"><table><tbody><tr><td><i class="icon-error"></i><br>' + name + '<br>не загружен</td></tr></tbody></table></div>' +
        '</li>';
    $('#log').append(listitem);
};



Album.uploadStart = function (id) {
    $('#upload_button_wrapper').css({height:0});
    $('#upload_finish_wrapper').css('height', 'auto').addClass('is_visible');
    $('#album_upload_step_1').css('height', 0);
    $('#album_upload_step_2').show();
};

Album.uploadProgress = function (id, percentage) {
    $('#log li#' + id).find('div.progress-bar .in').css('width', percentage + '%');
};

Album.uploadSuccess = function (id, name, serverData) {

    $('.scroll').jScrollPane({showArrows: true, autoReinitialise : true});
    $('#log li#' + id).removeClass('not-loaded');
    $('#album_select').replaceWith($(serverData).find('#album_select'));
    $('#album_select_chzn').remove();
    $('#album_select').chosen({
        allow_single_deselect:true
    });

    $('#new_album_title').val('');
    Album.changeAlbum($('#album_select'));


    var item = $('#log li#' + id);
    item.addClass('upload-done');
    item.find('div.progress-bar .in').css('width', '100%');
    var pathtofile = '<a href="uploads/' + name + '" target="_blank" >view &raquo;</a>';

    var params = $(serverData).find('#params').text().split('||');
    item.find('.file-params').append('<span class="src">' + params[0] + '</span>');
    item.find('.file-params').append('<span class="fsn">' + params[1] + '</span>');
    if (params[2] != undefined)
        item.find('.file-params').append('<span class="fid">' + params[2] + '</span>');
    item.find('.img').append('<img src="' + params[0] + '" />');
};

Album.registerUploadEvents = function (elem) {
    elem.unbind('fileQueued').bind('fileQueued', function (event, file) {
        Album.appendUploadItem(file.id);
        $('li#' + file.id + ' .remove').bind('click', function () {
            var swfu = $.swfupload.getInstance('#upload-control');
            swfu.cancelUpload(file.id);
        });
        $(this).swfupload('startUpload');
    })
        .unbind('fileQueueError').bind('fileQueueError', function (event, file, errorCode, message) {
            var error = '';
            if (errorCode == '-130') {
                error = 'Загружать можно только изображения';
            } else if (errorCode == '-110') {
                error = 'Слишком большой размер';
            }
            Album.appendUploadErrorItem(file.id, file.name, error);
        })
        .unbind('fileDialogStart').bind('fileDialogStart', function () {
            $('#log').empty();
            if($('.upload-files-list').data('jsp') != undefined)
                $('.upload-files-list').data('jsp').destroy()
        })
        .unbind('uploadStart').bind('uploadStart', function (event, file) {
            Album.uploadStart(file.id);
        })
        .unbind('uploadProgress').bind('uploadProgress', function (event, file, bytesLoaded) {
            var percentage = Math.round((bytesLoaded / file.size) * 100);
            Album.uploadProgress(file.id, percentage);
        })
        .unbind('uploadSuccess').bind('uploadSuccess', function (event, file, serverData) {
            Album.uploadSuccess(file.id, file.name, serverData);
        })
        .unbind('uploadComplete').bind('uploadComplete', function (event, file) {
            $(this).swfupload('startUpload');
        })
        .unbind('uploadError').bind('uploadError', function (file, errorCode, message) {
            cl(message);
        });
}

Album.savePhotos = function () {
    if (Album.current_album_id != Album.album_id) {
        document.location.href = base_url + '/albums/redirect/' + Album.album_id + '/';
    } else {
        $.fn.yiiListView.update('photosList');
    }
    $.fancybox.close();
    return false;
};

Album.changePhoto = function(link) {
    var params = link.split('/');
    var id = params[params.length - 2];
    $.get(link.href, {}, function(data) {
        var html = $(data);
        cl(html.find('.big-photo'));
    }, 'html');
    Comment.entity_id = id;
}

Album.updateField = function(el) {
    var textRow = $(el).parents('.row-elements');
    var inputRow = textRow.next();
    textRow.hide();
    inputRow.show();
    inputRow.find('input,textarea').focus();
}

Album.updateFieldSubmit = function(el, selector) {
    var inputRow = $(el).parents('.row-elements');
    var textRow = inputRow.prev();
    textRow.show();
    inputRow.hide();
    var newVal = inputRow.find('input,textarea').val();
    textRow.find(selector).text(newVal);
}