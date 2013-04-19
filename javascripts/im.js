/* Высчитывание ширины контейнера .layout-container без браузерного скрола */
function scrollFix() {
    
    var widthFixBlock = $('.layout-container_hold')
    var widthFix = widthFixBlock.parent().width();
    widthFixBlock.width(widthFix - getScrollBarWidth() + 'px'); 
}

var im = {};

im.topLineMenuHeight = 85;
im.tabsHeight = 53;
im.userListIndentFix = 198;
im.userListIndent = 189;
im.minHeight = 460;

im.viewHeight = function () {
    return im.windowHeight - im.topHeight - im.bottomHeight - im.headerHeight - im.topLineMenuHeight;
}

/* Высота в sidebar списка собеседников */
im.sidebarHeight = function () {
        
    /* Класс управления фиксед элементами */
    im.im__fixed = $(".im__fixed");
    if (im.im__fixed.length > 0) {
        im.userList.height(im.sidebar.height() - im.userListIndentFix);
    } else {
        im.userList.height(im.windowHeight - im.headerHeight - im.userListIndent + im.containerScroll);
    }

}

im.holdHeights = function  () {
    im.height = im.wrapper.height();
    if (im.height > im.viewHeight()) {
        im.hold.height(im.height);
    } else {
        im.hold.height(im.viewHeight());
    }
}

/* Поизиция скрола */
im.scrollIm = function (){
    if (im.containerScroll > im.headerHeight ) {
        /* Класс управления фиксед элементами */
        im.imBlock.addClass("im__fixed");
        /* Позиция блока сообщений */
        /*imTopScroll = -im.height + im.viewHeight() + im.containerScroll*2 - im.headerHeight;
        im.wrapper.css('top', imTopScroll);*/

    } else {
        /* Класс управления фиксед элементами */
        im.imBlock.removeClass("im__fixed");

        /* Высота sidebar списка собеседников */
        im.sidebarHeight();

        /* Позиция блока сообщений */
        /*imTopScroll = -im.height + im.viewHeight() + im.containerScroll;
        im.wrapper.css('top', imTopScroll);*/

         /* заглушка */
         $('.im-cap').css('top', im.headerHeight + im.tabsHeight - im.containerScroll);
    }
}

/* im - instant messeger for user */
$(window).load(function() {
    im.container = $('.layout-container');
    im.imBlock = $(".im");
    im.sidebar = $('.im-sidebar');
    im.userList = $('.im-user-list');
    im.hold = $('.im-center_middle-hold');
    im.wrapper = $('.im-center_middle-w');
    im.bottom = $('.im-center_bottom');

    im.windowHeight = $(window).height();
    im.headerHeight = $('#header-new').height();
    im.topHeight = $('.im-center_top').height();
    im.bottomHeight = im.bottom.height();
    im.height = im.wrapper.height();
    im.containerScroll = im.container.scrollTop();

    /* Высчитывание ширины контейнера .layout-container без браузерного скрола */
    scrollFix();

    /*im.wrapper.css('top',  -im.height + im.viewHeight());*/

    im.holdHeights ();
    /* Прокручивание в конец страницы */
    im.container.scrollTop($('.layout-container_hold').height());

    /* Высота sidebar списка собеседников */
    im.sidebarHeight(0);

    im.container.bind('scroll', function () {
        im.containerScroll = im.container.scrollTop();
        im.scrollIm ();
    });

    
    //$(".im-message_img").fancybox();

    /* Подсказки при наведении */
    $('.im-tooltipsy').powerTip({
        placement: 'n',
        smartPlacement: true,
        popupId: 'tooltipsy-im',
        offset: 8
    });

    /* toggle блок инфо собедника .im-panel */
    var mousePosY = false;
    im.imBlock.on("mousedown", ".im-panel .im_toggle", function(e) {
        e.preventDefault();
        mousePosY = e.pageY;
    }).on("mouseup", function(e) {
        if (mousePosY!=false) {
            $('.im-panel').toggleClass('im-panel__big');
        }
        mousePosY = false;
    });

    /* Изменение отступа от wysywig до конца стрнаицы */
    im.imBlock.on("mousedown", ".im-center_bottom .im_toggle", function(e) {
        e.preventDefault();
        var imBottomHold = $('.im-center_bottom-hold');
        var imMiddle = $('.im-center_middle');
        im.imBlock.on("mousemove", function(e) {
            imBottomMarg = im.windowHeight - e.pageY - 15;
            if (imBottomMarg > 11 && imBottomMarg < im.windowHeight - imBottomHold.height() - im.minHeight) {
                imBottomHold.stop().animate({'margin-bottom': imBottomMarg},10);
                im.bottomHeight = im.bottom.height();
                imMiddle.css('padding-bottom', im.bottomHeight);
            }
        });

    }).on("mouseup", function(e) {
        im.imBlock.off("mousemove");
    });

    /* Список скрытых пользователей в сайдбаре */
    $(".im-user-list_hide-a").click(function () {
      $(".im-user-list_hide-b").toggle("slow");
      return false;
    });

    $(window).resize(function() {
        scrollFix();

        im.containerScroll = im.container.scrollTop();
        im.windowHeight = $(window).height();
        im.holdHeights();

        im.scrollIm ();
        im.sidebarHeight();
    });

});