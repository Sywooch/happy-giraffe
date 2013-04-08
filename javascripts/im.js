$(function() {

const topLineMenuHeight = 60;
const imTabsHeight = 53;
const imUserListIndentFix = 198;
const imUserListIndent = 189;
/* im - instant messeger for user */
$(window).load(function() {
    /* Высчитывание ширины контейнера .layout-container без браузерного скрола */
    scrollFix();

    /* Проверка есть ли окно чата */
    var im = $(".im");
    if (im.length > 0) {

        
        $('.im-tooltipsy').tooltipsy({
            offset:[0, -8],
            className: 'tooltipsy-im'
        });

        var headerHeight = $('#header-new').height();
        var massageWrapper = $('.im-center_middle-w')
        var messagesHeight = massageWrapper.height();
        /* 43 - высота top-line-menu */
        var messagesViewHeight = $(window).height() - $('.im-center_top').height() - $('.im-center_bottom').height() - headerHeight - topLineMenuHeight; 
        var massageHold = $('.im-center_middle-hold');

        if (messagesHeight > messagesViewHeight) {
            $('.im-center_middle-hold').height(messagesHeight);
            massageWrapper.css('top', -messagesHeight + messagesViewHeight );
        } else {
            $('.im-center_middle-hold').height(messagesHeight);
            massageWrapper.css('top',  -messagesHeight + messagesViewHeight);
        }

        /* Высота sidebar списка собеседников */
        imSidebarHeight(0,headerHeight );

        var contaner = $('.layout-container');
        contaner.scroll(function () {
            var contanerScroll = contaner.scrollTop();
            
            if (contanerScroll > headerHeight ) {
                /* Класс управления фиксед элементами */
                im.addClass("im__fixed");
                /* Позиция top у сообщений */
                var messageTopScroll = -messagesHeight + messagesViewHeight + contanerScroll*2 - headerHeight ;
                massageWrapper.css('top', messageTopScroll);
                /* Высота sidebar списка собеседников */
                imSidebarHeight(contanerScroll, headerHeight);

            } else {
                /* Класс управления фиксед элементами */
                im.removeClass("im__fixed");
                /* Позиция top у сообщений */
                var messageTopScroll = -messagesHeight + messagesViewHeight + contanerScroll  ;
                 massageWrapper.css('top', messageTopScroll );
                 imSidebarHeight(contanerScroll, headerHeight);
                 /* заглушка */
                 $('.im-cap').css('top', $('#header-new').height() + imTabsHeight - contanerScroll);
            }

        });
    }

    $('.im-panel .im_toggle').click(function () {
        $('.im-panel').toggleClass('im-panel__big');
        /* при смене высоты учитывать разницу для блока с сообщениями */
        if($('.im-panel').hasClass('im-panel__big')) {
            $('.im-center_middle').css('padding-top', '190px');
        } else {
            $('.im-center_middle').css('padding-top', '140px');
        }
        return false;
    })

    $(".im-user-list_hide-a").click(function () {
      $(".im-user-list_hide-b").toggle("slow");
      return false;
    }); 
    
});


$(window).resize(function() {
    scrollFix();
    /* Высота sidebar списка собеседников */
    var contanerScroll = $('.layout-container').scrollTop();
    imSidebarHeight(contanerScroll);
});

/* Высота sidebar списка собеседников */
function imSidebarHeight(contanerScroll, headerHeight) {
    /* Класс управления фиксед элементами */
    
    if (im__fixed.length > 0) {
        imUserList.height(imSidebar.height() - imUserListIndent);
    } else {
        imUserList.height(windowHeight - headerHeight - imUserListIndent + contanerScroll);
    }

}

/* Высчитывание ширины контейнера .layout-container без браузерного скрола */
function scrollFix() {
    
    var widthFixBlock = $('.layout-container_hold')
    var widthFix = widthFixBlock.parent().width();
    widthFixBlock.width(widthFix - getScrollBarWidth() + 'px'); 
}

var windowHeight = $(window).height();
var im__fixed = $(".im__fixed");
var imSidebar = $('.im-sidebar');
var imUserList = $('.im-user-list');

});