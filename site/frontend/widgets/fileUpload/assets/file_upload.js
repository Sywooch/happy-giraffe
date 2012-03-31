function initForm() {
    $('#upload-input').hide();
    var binding = true;
    if($('#upload-control').data('__swfu') != undefined) {
        if($('#upload-control').find('.swfupload').size() > 0)
            $($('#upload-control').find('.swfupload')).replaceWith($('<button id="upload-button" class="btn btn-orange"><span><span>Загрузить</span></span></button>'));
        $('#upload-control').data('__swfu').destroy();
        $('#upload-control').data('__swfu', null);
        $($('#upload_finish_wrapper').find('.swfupload')).replaceWith($('<a id="upload-link" class="a-left" href="">Добавить еще фотографий</a>'));
        $('#upload_finish_wrapper').data('__swfu').destroy();
        $('#upload_finish_wrapper').data('__swfu', null);
        binding = false;
    }

    $('#upload-control').swfupload({
        upload_url:upload_ajax_url,
        file_size_limit:"6144",
        file_types:"*.jpg;*.png;*.gif;*.jpeg",
        file_upload_limit:"0",
        flash_url:upload_base_url + "/swfupload.swf",
        flash9_url:upload_base_url + "/swfupload_fp9.swf",

        button_text: '',
        button_width: 178,
        button_height: 34,
        button_image_url:"/images/btn_browse.png",
        button_placeholder:$('#upload-button')[0]
    });

    $('#upload_finish_wrapper').swfupload({
        upload_url:upload_ajax_url,
        file_size_limit:"6144",
        file_types:"*.jpg;*.png;*.gif;*.jpeg",
        file_upload_limit:"0",
        flash_url:upload_base_url + "/swfupload.swf",
        flash9_url:upload_base_url + "/swfupload_fp9.swf",

        button_text:'<span class="moreButton">Добавить еще фотографий</span>',
        button_text_style:'.moreButton {color: #54AFC3;display:block;height:34px;line-height:34px;font-size:12px;font-family:arial;}',
        button_width:178,
        button_height:34,
        button_placeholder:$('#upload-link')[0]
    });
    if(binding) {
        registerUploadEvents($('#upload-control'));
        registerUploadEvents($('#upload_finish_wrapper'));
        initForm();
    }
}

function registerUploadEvents(elem) {
    elem.bind('fileQueued', function (event, file) {
        var listitem = '<li class="clearfix" id="' + file.id + '" >' +
            '<div class="img"><i class="icon-error"></i></div>' +
            '<i class="icon-done"></i>' +
            '<div class="progress"><div class="in"></div></div>' +
            '<div class="progress-value"></div>' +
            '<div class="file-params" style="display:none;"></div>' +
            '<a class="remove" href="" onclick="$(this).parent().remove();return false;"></a>' +
            '</li>'
        $('#log').append(listitem);
        $('li#' + file.id + ' .remove').bind('click', function () { //Remove from queue on cancel click
            var swfu = $.swfupload.getInstance('#upload-control');
            swfu.cancelUpload(file.id);
            /*$('li#' + file.id).slideUp('fast');*/
        });
        // start the upload since it's queued
        $(this).swfupload('startUpload');
    })
        .bind('fileQueueError', function (event, file, errorCode, message) {
            var error = '';
            if (errorCode == '-130') {
                error = 'Загружать можно только изображения';
            } else if (errorCode == '-110') {
                error = 'Слишком большой размер';
            }
            var listitem = '<li class="clearfix upload-error" id="' + file.id + '" >' +
                '<div class="img"><i class="icon-error"></i></div>' +
                '<span>' + file.name + ' не был загружен. ' + error + '.</span>' +
                '</li>'
            $('#log').append(listitem);
        })
        .bind('fileDialogComplete', function (event, numFilesSelected, numFilesQueued) {
            /*$('#queuestatus').text('Files Selected: ' + numFilesSelected + ' / Queued Files: ' + numFilesQueued);*/
        })
        .bind('fileDialogStart', function() {
            $('#log').empty();
        })
        .bind('uploadStart', function (event, file) {
            $('#upload_button_wrapper').css({height:0});
            $('#upload_finish_wrapper').css('height', 'auto').addClass('is_visible');
            $('#log li#' + file.id).find('.progress-value').text('0%');
            $('#album_upload_step_1').css('height', 0);
            /*$('#album_upload_step_1').css('visibility', 'hidden');
            $('#album_upload_step_1').css('height', '1');*/
            $('#album_upload_step_2').css('visibility', 'show');
        })
        .bind('uploadProgress', function (event, file, bytesLoaded) {
            //Show Progress
            var percentage = Math.round((bytesLoaded / file.size) * 100);
            $('#log li#' + file.id).find('div.progress .in').css('width', percentage + '%');
            $('#log li#' + file.id).find('.progress-value').text(percentage + '%');
        })
        .bind('uploadSuccess', function (event, file, serverData) {
            $('#album_select').replaceWith($(serverData).find('#album_select'));
            $('#album_select_chzn').remove();
            $('#album_select').chosen({
                allow_single_deselect:true
            });

            $('#new_album_title').val('');
            Album.changeAlbum($('#album_select'));


            var item = $('#log li#' + file.id);
            item.addClass('upload-done');
            item.find('div.progress .in').css('width', '100%');
            item.find('.progress-value').text('100%');
            var pathtofile = '<a href="uploads/' + file.name + '" target="_blank" >view &raquo;</a>';

            var params = $(serverData).find('#params').text().split('||');
            item.find('.file-params').append('<span class="src">' + params[0] + '</span>');
            item.find('.file-params').append('<span class="fsn">' + params[1] + '</span>');
            if (params[2] != undefined)
                item.find('.file-params').append('<span class="fid">' + params[2] + '</span>');
            item.find('.img').append('<img src="' + params[0] + '" />')
        })
        .bind('uploadComplete', function (event, file) {
            $(this).swfupload('startUpload');
        })
        .bind('uploadError', function (file, errorCode, message) {
            cl(message);
            cl(errorCode);
        });
}

function initAttachForm() {
    $('#attach_form').iframePostForm({
        complete:function (response) {
            if(!response)
                return false;
            var params = $(response).find('#params').text().split('||');
            var html = '<img src="' + params[0] + '" width="170" alt="" />' +
                '<input type="hidden" name="fsn" value="' + params[1] + '" />' +
                '<a class="remove" href="" onclick="return removeAttachPhoto();"></a>';
            $('#upload_photo_container').html(html);
            $('#attach_form').hide();
            $('#save_attach_button').show();
        }
    });
}

function removeAttachPhoto() {
    $('#upload_photo_container').html('');
    $('#attach_form').show();
    $('#save_attach_button').hide();
    return false;
}

function savePhotos() {
    if ($('#comment_list_view').size() > 0)
        $.fn.yiiListView.update('comment_list_view');
    $.fancybox.close();
    if(Album.album_id && $('#comment_list_view').size() == 0) {
        document.location.href = base_url + '/albums/' + Album.album_id + '/';
    }
    return false;
}
