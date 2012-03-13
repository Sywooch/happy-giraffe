function initForm() {
    $('#upload-input').hide();
    $('#upload-control').swfupload({
        upload_url:upload_ajax_url,
        file_size_limit:"4096",
        file_types:"*.*",
        file_upload_limit:"0",
        flash_url:upload_base_url + "/swfupload.swf",

        button_text:'',
        button_width:91,
        button_height:34,
        button_image_url : "/images/btn_browse.png",
        button_placeholder:$('#upload-button')[0]
    });
    $('#upload_finish_wrapper').swfupload({
        upload_url:upload_ajax_url,
        file_size_limit:"4096",
        file_types:"*.*",
        file_upload_limit:"0",
        flash_url:upload_base_url + "/swfupload.swf",

        button_text:'<span class="moreButton">Добавить еще фотографий</span>',
        button_text_style : '.moreButton {color: #54AFC3;display:block;height:34px;line-height:34px;font-size:12px;font-family:arial;}',
        button_width:152,
        button_height:34,
        button_placeholder:$('#upload-link')[0]
    });
    registerUploadEvents($('#upload-control'));
    registerUploadEvents($('#upload_finish_wrapper'));
}

function registerUploadEvents(elem)
{
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
        var listitem = '<li class="clearfix upload-error" id="' + file.id + '" >' +
            '<div class="img"><i class="icon-error"></i></div>' +
            '<span>'+file.name+' не был загружен. Слишком большой размер.</span>' +
            '</li>'
        $('#log').append(listitem);
    })
    .bind('fileDialogComplete', function (event, numFilesSelected, numFilesQueued) {
        /*$('#queuestatus').text('Files Selected: ' + numFilesSelected + ' / Queued Files: ' + numFilesQueued);*/
    })
    .bind('uploadStart', function (event, file) {
        $('#upload_button_wrapper').css({visibility:'hidden',height:0});
        $('#upload_finish_wrapper').show();
        $('#log li#' + file.id).find('.progress-value').text('0%');
    })
    .bind('uploadProgress', function (event, file, bytesLoaded) {
        //Show Progress
        var percentage = Math.round((bytesLoaded / file.size) * 100);
        $('#log li#' + file.id).find('div.progress .in').css('width', percentage + '%');
        $('#log li#' + file.id).find('.progress-value').text(percentage + '%');
    })
    .bind('uploadSuccess', function (event, file, serverData) {
        var item = $('#log li#' + file.id);
        item.addClass('upload-done');
        item.find('div.progress .in').css('width', '100%');
        item.find('.progress-value').text('100%');
        var pathtofile = '<a href="uploads/' + file.name + '" target="_blank" >view &raquo;</a>';

        var fsn = serverData.split('/')[serverData.split('/').length - 1];
        item.find('.file-params').append('<span class="src">'+serverData+'</span><span class="fsn">'+fsn+'</span>');
        item.find('.img').append('<img src="'+serverData+'" />')
    })
    .bind('uploadComplete', function (event, file) {
        $(this).swfupload('startUpload');
    })
    .bind('uploadError', function(file, errorCode, message) {
        cl(message);
        cl(errorCode);
    });
}

function savePhotos() {
    if($('#galleryUploadPhotos #log li .file-params').size() == 0)
        return false;
    return false;
}


var ru2en = {
    ru_str:"АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыьэюя",
    en_str:['A', 'B', 'V', 'G', 'D', 'E', 'JO', 'ZH', 'Z', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T',
        'U', 'F', 'H', 'C', 'CH', 'SH', 'SHH', String.fromCharCode(35), 'I', String.fromCharCode(39), 'JE', 'JU',
        'JA', 'a', 'b', 'v', 'g', 'd', 'e', 'jo', 'zh', 'z', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f',
        'h', 'c', 'ch', 'sh', 'shh', String.fromCharCode(35), 'i', String.fromCharCode(39), 'je', 'ju', 'ja'],
    translit:function (org_str) {
        var tmp_str = "";
        for (var i = 0, l = org_str.length; i < l; i++) {
            var s = org_str.charAt(i), n = this.ru_str.indexOf(s);
            if (n >= 0) {
                tmp_str += this.en_str[n];
            }
            else {
                tmp_str += s;
            }
        }
        return tmp_str;
    }
}

function ajax_upload_success(response) {
    if (response == 1) {
        $.fancybox.close();
        document.location.reload();
    }
}