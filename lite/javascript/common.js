document.domain = document.domain;

function addBaron(el) {
    $(el).each(function() {
        if (this.baron) {
            this.baron.update();
        } else {
            this.baron = $(this).baron({
                scroller: '.scroll_scroller',
                barOnCls: 'scroll__on',
                container: '.scroll_cont',
                track: '.scroll_bar-hold',
                bar: '.scroll_bar'
            });
            // Т.к. по спецификации у события onScroll нет bubbling'а,
            // то обработчик надо вешать на каждый конкретный элемент
            $('.scroll_scroller', this).scroll(function(e) {
                // стриггерим jquery событие, у которого есть bubbling,
                // но, что бы не уйти в цикл, проверим флаг.
                if(!e.fake) {
                    e.fake = true;
                    $(this).trigger(e);
                }
            });
        }
    });
}

$(function() {


    /* Для работы select2 в magnificPopup */
    $.magnificPopup.instance._onFocusIn = function(e) {
          // Do nothing if target element is select2 input
          if( $(e.target).hasClass('select2-input') ) {
            return true;
          } 
          // Else call parent method
          $.magnificPopup.proto._onFocusIn.call(this,e);
    };

    $('.popup-a').magnificPopup({
        type: 'inline',
        overflowY: 'auto',
        tClose: 'Закрыть',
        fixedBgPos: true,
        
        // When elemened is focused, some mobile browsers in some cases zoom in
        // It looks not nice, so we disable it:
        callbacks: {
            open: function() {
                $('html').addClass('mfp-html');
                addBaron('.scroll');
            },
            close: function() {
                $('html').removeClass('mfp-html');
            }
        }
    });

});


$(document).ready(function () {

    /* видео с youtube, что б не перекрывало всплывающие окна */
    $("iframe").each(function(){
        var ifr_source = $(this).attr('src');
        if (ifr_source !== undefined){
            var wmode = "wmode=transparent";
            if(  ifr_source.indexOf('youtube.com')>-1 ) {
                if(ifr_source.indexOf('?') != -1) {
                    var getQString = ifr_source.split('?');
                    var oldString = getQString[1];
                    var newString = getQString[0];
                    $(this).attr('src',newString+'?'+wmode+'&'+oldString);
                }
                else $(this).attr('src',ifr_source+'?'+wmode);
            }
        }
    });

    /* Подсказки при наведении */
    $('.powertip').powerTip({
        placement: 'n',
        offset: 5
    });

});

function cl(value) {
    console.log(value);
}
