$(document).ready(function () {
    var fileInput = $('#upload-input');
    var form = $('#upload-form');
    // проверка html5
    if (window.File && window.FileReader && window.FileList && window.Blob && ('draggable' in document.createElement('span'))) {
        HTML5Upload.init(fileInput, form);
    } else {
        /*fileInput.attr('multiple', false);
         form.iframePostForm({
         post: function() {

         },
         complete: function(response) {
         ajax_upload_success(response);
         }
         });*/

        $('#upload-input').hide();
        $(document).ready(function() {
            $('#upload-control').swfupload({
                upload_url:upload_ajax_url,
                file_size_limit:"10240",
                file_types:"*.*",
                file_types_description:"All Files",
                file_upload_limit:"0",
                flash_url:upload_base_url + "/swfupload.swf",
                button_width:61,
                button_height:22,
                button_text:1123,
                button_placeholder:$('#upload-button')[0],
                debug:false,
                custom_settings:{something:"here"}
            })
                .bind('swfuploadLoaded', function (event) {
                    $('#log').append('<li>Loaded</li>');
                })
                .bind('fileQueued', function (event, file) {
                    $('#log').append('<li>File queued - ' + file.name + '</li>');
                    // start the upload since it's queued
                    $(this).swfupload('startUpload');
                })
                .bind('fileQueueError', function (event, file, errorCode, message) {
                    $('#log').append('<li>File queue error - ' + message + '</li>');
                })
                .bind('fileDialogStart', function (event) {
                    $('#log').append('<li>File dialog start</li>');
                })
                .bind('fileDialogComplete', function (event, numFilesSelected, numFilesQueued) {
                    $('#log').append('<li>File dialog complete</li>');
                })
                .bind('uploadStart', function (event, file) {
                    $('#log').append('<li>Upload start - ' + file.name + '</li>');
                })
                .bind('uploadProgress', function (event, file, bytesLoaded) {
                    $('#log').append('<li>Upload progress - ' + bytesLoaded + '</li>');
                })
                .bind('uploadSuccess', function (event, file, serverData) {
                    $('#log').append('<li>Upload success - ' + file.name + '</li>');
                })
                .bind('uploadComplete', function (event, file) {
                    $('#log').append('<li>Upload complete - ' + file.name + '</li>');
                    // upload has completed, lets try the next one in the queue
                    $(this).swfupload('startUpload');
                })
                .bind('uploadError', function (event, file, errorCode, message) {
                    $('#log').append('<li>Upload error - ' + message + '</li>');
                });
        });
    }
});

var ProgressBar = {
    create:function (parent) {
        $('<div/>').addClass('progress').attr('rel', '0').text('0%').appendTo(parent);
    },
    update:function (bar, value) {
        var width = bar.width();
        var bgrValue = -width + (value * (width / 100));
        bar.attr('rel', value).css('background-position', bgrValue + 'px center').text(value + '%');
    }
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