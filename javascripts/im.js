var im = {};
/* Прокручивание в конец сообщений */
im.scrollTop = function () {
    im.hold.scrollTop(im.wrapper.height());
}

im.messagesHeight = function () {
    var h = im.windowHeight - im.headerHeight - im.topHeight - im.bottom.height() - 21; // 21 - отступы в блоках
    im.hold.height(h);
}

im.sidebarHeight = function () {
    var h = im.windowHeight - im.headerHeight - im.bottom.height() - 156; // 156 - отступы в блоках
    im.userList.height(h - );
}


$(window).load(function() {

    im.windowHeight = $(window).height(); 
    im.imBlock = $(".im");

    im.userList = $('.im-user-list');
    im.hold = $('.im-center_middle-hold');
    im.wrapper = $('.im-center_middle-w');
    im.bottom = $('.im-center_bottom');

    im.headerHeight = $('.layout-header').height();
    im.topHeight = $('.im-center_top').height();

    im.messagesHeight();
    im.sidebarHeight();
    im.scrollTop();


    $(window).resize(function() {
        im.windowHeight = $(window).height();
        im.messagesHeight();
        im.sidebarHeight();
    });
});