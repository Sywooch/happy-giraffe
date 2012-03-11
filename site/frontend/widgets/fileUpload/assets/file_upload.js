function initForm() {
    $('#upload-control').swfupload({
        upload_url:upload_ajax_url,
        file_size_limit:"10240",
        file_types:"*.*",
        file_types_description:"All Files",
        file_upload_limit:"0",
        flash_url:upload_base_url + "/swfupload.swf",
        button_text:'Upload',
        button_width:100,
        button_width:61,
        button_height:22,
        button_placeholder:$('#upload-button')[0],
        debug:true,
        custom_settings:{something:"here"}
    })
        .bind('fileQueued', function (event, file) {
            var listitem = '<li id="' + file.id + '" >' +
                'File: <em>' + file.name + '</em> (' + Math.round(file.size / 1024) + ' KB) <span class="progressvalue" ></span>' +
                '<div class="progressbar" ><div class="progress" ></div></div>' +
                '<p class="status" >Pending</p>' +
                '<span class="cancel" >&nbsp;</span>' +
                '</li>';
            $('#log').append(listitem);
            $('li#' + file.id + ' .cancel').bind('click', function () { //Remove from queue on cancel click
                var swfu = $.swfupload.getInstance('#upload-control');
                swfu.cancelUpload(file.id);
                $('li#' + file.id).slideUp('fast');
            });
            // start the upload since it's queued
            $(this).swfupload('startUpload');
        })
        .bind('fileQueueError', function (event, file, errorCode, message) {
            alert('Size of the file ' + file.name + ' is greater than limit');
        })
        .bind('fileDialogComplete', function (event, numFilesSelected, numFilesQueued) {
            $('#queuestatus').text('Files Selected: ' + numFilesSelected + ' / Queued Files: ' + numFilesQueued);
        })
        .bind('uploadStart', function (event, file) {
            $('#log li#' + file.id).find('p.status').text('Uploading...');
            $('#log li#' + file.id).find('span.progressvalue').text('0%');
            $('#log li#' + file.id).find('span.cancel').hide();
        })
        .bind('uploadProgress', function (event, file, bytesLoaded) {
            //Show Progress
            var percentage = Math.round((bytesLoaded / file.size) * 100);
            $('#log li#' + file.id).find('div.progress').css('width', percentage + '%');
            $('#log li#' + file.id).find('span.progressvalue').text(percentage + '%');
        })
        .bind('uploadSuccess', function (event, file, serverData) {
            var item = $('#log li#' + file.id);
            item.find('div.progress').css('width', '100%');
            item.find('span.progressvalue').text('100%');
            var pathtofile = '<a href="uploads/' + file.name + '" target="_blank" >view &raquo;</a>';
            item.addClass('success').find('p.status').html('Done!!! | ' + pathtofile);
        })
        .bind('uploadComplete', function (event, file) {
            // upload has completed, try the next one in the queue
            $(this).swfupload('startUpload');
        })
        .bind('uploadError', function(file, errorCode, message) {
            cl(message);
            cl(errorCode);
        });
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