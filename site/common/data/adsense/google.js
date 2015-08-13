var jq = document.createElement('script');
jq.src = "https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js";
document.getElementsByTagName('head')[0].appendChild(jq);

var text = '';
$('a[href*="http://www.happy-giraffe.ru"]').not('[href*=translate]').each(function(index, el) {
    text += $(el).attr('href') + "\n";
});
window.open("data:text/json;charset=utf-8," + escape(text));


// ***

var jq = document.createElement('script');
jq.src = "https://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js";
document.getElementsByTagName('head')[0].appendChild(jq);

var text = '';
$('a.rg_l').each(function(index, el) {
    var matches = $(el).attr('href').match(/imgrefurl=([^&]+)&/);
    text += matches[1] + "\n";
});
window.open("data:text/json;charset=utf-8," + escape(text));