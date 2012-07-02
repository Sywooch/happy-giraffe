$(function() {
    var seoHrefs = " . CJSON::encode($this->seoHrefs) . ";
    var seoContent = " . CJSON::encode($this->seoContent) . ";
    $('[hashString]').each(function(){
        var key = $(this).attr('hashString');
        if($(this).attr('hashType') == 'href'){
            $(this).attr('href', Base64.decode(seoHrefs[key]));
        }else{
            $(this).replaceWith(Base64.decode(seoContent[key]));
        }
    });


});