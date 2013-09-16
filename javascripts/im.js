var im = {};

/* Прокручивание в конец сообщений, для показа последнего сообщения
 * Зпускать при загрузке сообщений беседы
 */
im.scrollTop = function () {
    im.hold.scrollTop(im.wrapper.height());
}

/* Высота блока с сообщениями
 * Запускать при начальной загрузке страницы и изменении высоты окна браузера
 */
im.messagesHeight = function () {
    var h = im.windowHeight - im.headerHeight - im.topHeight - im.bottom.height() - 17; // 17 - отступы в блоках
    im.hold.height(h);
}

/* Высота блока списка диалогов
 * Запускать при начальной загрузке страницы и изменении высоты окна браузера
 */
im.sidebarHeight = function () {

    var h = im.windowHeight - im.headerHeight - im.bottom.height() - im.contactHide.outerHeight() - 147; // 155 - отступы в блоках
    if (im.userListHeight > h ) {
        console.log( im.userListHeight);
        im.userList.height(h);
    } else {
        im.userList.height(im.userListHeight);
    }
}


$(window).load(function() {

    im.windowHeight = $(window).height(); 
    im.imBlock = $(".im");

    im.userList = $('.im-user-list');
    im.userListHeight = im.userList.height();
    im.hold = $('.im-center_middle-hold');
    im.wrapper = $('.im-center_middle-w');
    im.bottom = $('.im-center_bottom');

    im.headerHeight = $('.layout-header').height();
    im.topHeight = $('.im-center_top').height();
    im.contactHide = $('.im-sidebar_hide-a');


    im.messagesHeight();
    im.sidebarHeight();
    im.scrollTop();


    $(window).resize(function() {
        im.windowHeight = $(window).height();
        im.messagesHeight();
        im.sidebarHeight();
    });
});