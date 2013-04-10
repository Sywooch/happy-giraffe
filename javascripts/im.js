
/* im - instant messeger for user */
$(window).load(function() {

    var topLineMenuHeight = 100;
    var imTabsHeight = 53;
    var imMinHeight = 50;
    var imUserListIndentFix = 198;
    var imUserListIndent = 189;
    var imMinHeight = 460;

    var container = $('.layout-container');
    var im = $(".im");
    var imSidebar = $('.im-sidebar');
    var imUserList = $('.im-user-list');
    var imWrapper = $('.im-message-w');
    var imHold = $('.im-center_middle-hold');
    var imBottom = $('.im-center_bottom');
    var im__fixed = $(".im__fixed");

    var windowHeight = $(window).height();
    var headerHeight = $('#header-new').height();
    var imBottomHeight = $('.im-center_bottom').height();
    var imTopHeight = $('.im-center_bottom').height();
    var imHeight = imWrapper.height();
    var imViewHeight = windowHeight - imTopHeight - imBottomHeight - headerHeight - topLineMenuHeight; 

    /* Высчитывание ширины контейнера .layout-container без браузерного скрола */
    scrollFix();

    imWrapper.css('top',  -imHeight + imViewHeight);

    imHoldHeights ();

    /* Высота sidebar списка собеседников */
    imSidebarHeight(0, headerHeight);

    container.bind('scroll', function () {
        var containerScroll = container.scrollTop();
        scrollIm (containerScroll, headerHeight);
    });


    /* Подсказки при наведении */
    $('.im-tooltipsy').tooltipsy({
        offset:[0, -8],
        className: 'tooltipsy-im'
    });

    /* toggle блок инфо собедника .im-panel */
    var mousePosY = false;
    im.on("mousedown", ".im-panel .im_toggle", function(e) {
        e.preventDefault();
        mousePosY = e.pageY;
    }).on("mouseup", function(e) {
        if (mousePosY!=false) {
            $('.im-panel').toggleClass('im-panel__big');
        }
        mousePosY = false;
    });

    /* Изменение отступа от wysywig до конца стрнаицы */
    im.on("mousedown", ".im-center_bottom .im_toggle", function(e) {
        e.preventDefault();
        var imBottomHold = $('.im-center_bottom-hold');
        var imMiddle = $('.im-center_middle');
        im.on("mousemove", function(e) {
            imBottomMarg = windowHeight - e.pageY - 15;
            if (imBottomMarg > 11 && imBottomMarg < windowHeight - imBottomHold.height() - imMinHeight) {
                imBottomHold.stop().animate({'margin-bottom': imBottomMarg},10);
                imBottomHeight = imBottom.height();
                imMiddle.css('padding-bottom', imBottomHeight);
            }
        });

    }).on("mouseup", function(e) {
        im.off("mousemove");
    });

    /* Список скрытых пользователей в сайдбаре */
    $(".im-user-list_hide-a").click(function () {
      $(".im-user-list_hide-b").toggle("slow");
      return false;
    });

    $(window).resize(function() {
        scrollFix();

        containerScroll = container.scrollTop();
        windowHeight = $(window).height();
        imHoldHeights ();
            /* Высота видимой части сообщений */
            imViewHeight = windowHeight - imTopHeight - imBottomHeight - headerHeight - topLineMenuHeight;

        scrollIm (containerScroll);
        imSidebarHeight(containerScroll);
    });

    /* Высота в sidebar списка собеседников */
    function imSidebarHeight(containerScroll, headerHeight) {
        
        /* Класс управления фиксед элементами */
        var im__fixed = $(".im__fixed");
        if (im__fixed.length > 0) {
            imUserList.height(imSidebar.height() - imUserListIndentFix);
        } else {
            imUserList.height(windowHeight - headerHeight - imUserListIndent + containerScroll);
        }

    }

    /* Поизиция скрола */
    function scrollIm (containerScroll){
        if (containerScroll > headerHeight ) {
            /* Класс управления фиксед элементами */
            im.addClass("im__fixed");
            /* Позиция блока сообщений */
            var imTopScroll = -imHeight + imViewHeight + containerScroll*2 - headerHeight ;
                imWrapper.css('top', imTopScroll);

            /*imTopScroll = messagesHeight - messagesViewHeight - contanerScroll*2 - headerHeight - imBottomHeight;
            imWrapper.css('bottom', imTopScroll);*/

        } else {
            /* Класс управления фиксед элементами */
            im.removeClass("im__fixed");

            /* Высота sidebar списка собеседников */
            imSidebarHeight(containerScroll, headerHeight);

            /* Позиция блока сообщений */
            /*imTopScroll = imBottomHeight;
            imWrapper.css('bottom', imTopScroll);*/

             /* заглушка */
             $('.im-cap').css('top', headerHeight + imTabsHeight - containerScroll);
        }
    }

    function imHoldHeights () {
        if (imHeight > imViewHeight) {
            imHold.height(imHeight);
        } else {
            imHold.height(imViewHeight);
        }
    }

    /* Высчитывание ширины контейнера .layout-container без браузерного скрола */
    function scrollFix() {
        
        var widthFixBlock = $('.layout-container_hold')
        var widthFix = widthFixBlock.parent().width();
        widthFixBlock.width(widthFix - getScrollBarWidth() + 'px'); 
    }


});