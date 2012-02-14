$(document).ready(function() {
    var fileInput = $('#upload-input');
    var form = $('#upload-form');
    // проверка html5
    if (window.File && window.FileReader && window.FileList && window.Blob && ('draggable' in document.createElement('span')))
    {
        HTML5Upload.init(fileInput, form);
    } else {
        fileInput.attr('multiple', false);
        form.iframePostForm({
        	post: function() {

        	},
        	complete: function(response) {
                ajax_upload_success(response);
        	}
        });
        //$(document).ready(function() {initSwfUpoad(fileInput, form);});
    }
});

var ProgressBar = {
    create : function(parent) {
        $('<div/>').addClass('progress').attr('rel', '0').text('0%').appendTo(parent);
    },
    update : function(bar, value) {
        var width = bar.width();
        var bgrValue = -width + (value * (width / 100));
        bar.attr('rel', value).css('background-position', bgrValue + 'px center').text(value + '%');
    }
}

var ru2en = {
  ru_str : "АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыьэюя",
  en_str : ['A','B','V','G','D','E','JO','ZH','Z','I','J','K','L','M','N','O','P','R','S','T',
    'U','F','H','C','CH','SH','SHH',String.fromCharCode(35),'I',String.fromCharCode(39),'JE','JU',
    'JA','a','b','v','g','d','e','jo','zh','z','i','j','k','l','m','n','o','p','r','s','t','u','f',
    'h','c','ch','sh','shh',String.fromCharCode(35),'i',String.fromCharCode(39),'je','ju','ja'],
  translit : function(org_str) {
    var tmp_str = "";
    for(var i = 0, l = org_str.length; i < l; i++) {
      var s = org_str.charAt(i), n = this.ru_str.indexOf(s);
      if(n >= 0) { tmp_str += this.en_str[n]; }
      else { tmp_str += s; }
    }
    return tmp_str;
  }
}

function ajax_upload_success(response)
{
    console.log(response)
    if(response == 1)
    {
        $.fancybox.close();
        document.location.reload();
    }
}